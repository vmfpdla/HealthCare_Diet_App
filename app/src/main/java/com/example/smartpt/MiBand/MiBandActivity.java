package com.example.smartpt.MiBand;

import android.Manifest;
import android.content.ContentValues;
import android.content.Context;
import android.content.DialogInterface;
import android.content.Intent;
import android.content.pm.PackageManager;
import android.net.Uri;
import android.os.Bundle;
import android.provider.Settings;
import android.util.Log;

import androidx.annotation.NonNull;
import androidx.appcompat.app.AlertDialog;
import androidx.appcompat.app.AppCompatActivity;
import androidx.core.app.ActivityCompat;
import androidx.core.content.ContextCompat;

import com.example.smartpt.MainActivity;
import com.example.smartpt.PreferenceManager;
import com.example.smartpt.R;
import com.example.smartpt.SmartPT;
import com.example.smartpt.bluetooth.BluetoothActivity;
import com.example.smartpt.network.NetworkTask;
import com.example.smartpt.network.Opcode;
import com.google.android.gms.auth.api.signin.GoogleSignIn;
import com.google.android.gms.fitness.Fitness;
import com.google.android.gms.fitness.FitnessActivities;
import com.google.android.gms.fitness.FitnessOptions;
import com.google.android.gms.fitness.data.Bucket;
import com.google.android.gms.fitness.data.DataPoint;
import com.google.android.gms.fitness.data.DataSet;
import com.google.android.gms.fitness.data.DataType;
import com.google.android.gms.fitness.data.Field;
import com.google.android.gms.fitness.data.Value;
import com.google.android.gms.fitness.request.DataReadRequest;
import com.google.android.gms.fitness.result.DataReadResponse;
import com.google.android.gms.tasks.OnCompleteListener;
import com.google.android.gms.tasks.OnFailureListener;
import com.google.android.gms.tasks.OnSuccessListener;
import com.google.android.gms.tasks.Task;

import java.text.DateFormat;
import java.text.SimpleDateFormat;
import java.util.Calendar;
import java.util.Date;
import java.util.List;
import java.util.concurrent.TimeUnit;

public class MiBandActivity extends AppCompatActivity {

    public static final String TAG = "SmartPT";
    private static final int PERMISSION_ALL = 0x1001;
    private static final int REQUEST_OAUTH_REQUEST_CODE = 0x1002;


    static String[] categories = {"Walking", "Running", "Nothing", "Others"};
    private static float[] calories = {0, 0, 0, 0};
    private static float[] distances = {0, 0, 0, 0};
    private static int[] minutes = {0, 0, 0, 0};
    private static float[] move = {0, 0, 0, 0};
    private static float[] power = {0, 0, 0, 0};
    private int calorie = 0;
    private long step = 0;
    private int distance = 0;

    private FitnessOptions fitnessOptions;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);

        checkPermission();
        initializeHealth();

        setContentView(R.layout.activity_mi_band);

    }

    //권한 확인
    public void checkPermission(){
        String[] PERMISSIONS = {
                Manifest.permission.ACTIVITY_RECOGNITION,
                Manifest.permission.ACCESS_FINE_LOCATION
        };
        //권한없음

        if (ContextCompat.checkSelfPermission(this, PERMISSIONS[1]) != PackageManager.PERMISSION_GRANTED){
            ActivityCompat.requestPermissions(this, PERMISSIONS, PERMISSION_ALL);
            Log.e(TAG, "권한 없음");
        }
        //권한있음
        else{
            Log.e(TAG, "권한 있음");
        }
    }

    @Override
    public void onRequestPermissionsResult(int requestCode, @NonNull String[] permissions, @NonNull int[] grantResults) {
        super.onRequestPermissionsResult(requestCode, permissions, grantResults);
        switch (requestCode) {
            case PERMISSION_ALL:
                if (grantResults.length > 0){// && grantResults[0] == PackageManager.PERMISSION_GRANTED) {
                    for(int i=0;i<grantResults.length;i++){
                        if(grantResults[i] == PackageManager.PERMISSION_DENIED){
                            AlertDialog.Builder alertDialog = new AlertDialog.Builder(this);
                            alertDialog.setTitle("앱 권한");
                            alertDialog.setMessage("해당 앱의 원할한 기능을 이용하시려면 애플리케이션 정보>권한> 에서 모든 권한을 허용해 주십시오");
                            // 권한설정 클릭시 이벤트 발생
                            alertDialog.setPositiveButton("권한설정",
                                    new DialogInterface.OnClickListener() {
                                        public void onClick(DialogInterface dialog, int which) {
                                            Intent intent = new Intent(Settings.ACTION_APPLICATION_DETAILS_SETTINGS).setData(Uri.parse("package:" + getApplicationContext().getPackageName()));
                                            startActivity(intent);
                                            dialog.cancel();
                                        }
                                    });
                            //취소
                            alertDialog.setNegativeButton("취소",
                                    new DialogInterface.OnClickListener() {
                                        public void onClick(DialogInterface dialog, int which) {
                                            dialog.cancel();
                                        }
                                    });
                            alertDialog.show();
                        }
                    }
                }
                return;
        }
    }

    public void initializeHealth() {
        for(int i=0;i<4;i++){
            calories[i] = 0;
            distances[i] = 0;
            minutes[i] = 0;
            move[i] = 0;
        }
        fitnessOptions =
                FitnessOptions.builder()
                        .addDataType(DataType.TYPE_CALORIES_EXPENDED)
//                        .addDataType(DataType.TYPE_STEP_COUNT_DELTA)
                        .addDataType(DataType.TYPE_MOVE_MINUTES)
                        .addDataType(DataType.TYPE_POWER_SAMPLE)
                        .addDataType(DataType.TYPE_ACTIVITY_SEGMENT)
                        .addDataType(DataType.TYPE_DISTANCE_DELTA)
                        .build();

        //구글로그인안된경우
        if (!GoogleSignIn.hasPermissions(GoogleSignIn.getLastSignedInAccount(this), fitnessOptions)) {
            GoogleSignIn.requestPermissions(
                    this,
                    REQUEST_OAUTH_REQUEST_CODE,
                    GoogleSignIn.getLastSignedInAccount(this),
                    fitnessOptions);
            Log.i(TAG, "initializeHealth: Fitness Counter Background Permission denied ");
        }

        //구글로그인된경우
        else {
            //총걸음
//            initializeStep();
            //총칼로리
//            initializeCalorie();
            //총거리
//            initializeDistance();
            //하루동안의 운동
            readHistoryData();
        }
    }

    public void initializeCalorie() {
        //칼로리권한확인
        Fitness.getRecordingClient(this , GoogleSignIn.getLastSignedInAccount(this))
                .subscribe(DataType.TYPE_CALORIES_EXPENDED)
                .addOnCompleteListener(
                        new OnCompleteListener<Void>() {
                            @Override
                            public void onComplete(@NonNull Task<Void> task) {
                                //권한 있는 경우
                                if (task.isSuccessful()) {
                                    Log.i(TAG, "Successfully subscribed for calorie!");
                                    //칼로리 읽음
                                    readCalorieData();
                                } else {
                                    Log.w(TAG, "There was a problem subscribing.", task.getException());
                                }
                            }
                        })
                .addOnFailureListener(new OnFailureListener() {
                    @Override
                    public void onFailure(@NonNull Exception e) {
                        Log.i(TAG, "There was a problem subscribing."+ e.getMessage());
                    }
                });
    }

    public void readCalorieData() {
        Fitness.getHistoryClient(this, GoogleSignIn.getLastSignedInAccount(this))
                .readDailyTotal(DataType.TYPE_CALORIES_EXPENDED)
                .addOnSuccessListener(
                        new OnSuccessListener<DataSet>() {
                            @Override
                            public void onSuccess(DataSet dataSet) {
                                int total =
                                        (int) (dataSet.isEmpty()
                                                ? 0
                                                : dataSet.getDataPoints().get(0).getValue(Field.FIELD_CALORIES).asFloat());
                                Log.i(TAG, "Total calories = " + total);
                                calorie = total;
                            }
                        })
                .addOnFailureListener(
                        new OnFailureListener() {
                            @Override
                            public void onFailure(@NonNull Exception e) {
                                Log.w(TAG, "There was a problem getting the calorie count.", e);
                            }
                        });

    }

    public void initializeStep() {
        Fitness.getRecordingClient(this, GoogleSignIn.getLastSignedInAccount(this))
                .subscribe(DataType.TYPE_STEP_COUNT_DELTA)
                .addOnCompleteListener(
                        new OnCompleteListener<Void>() {
                            @Override
                            public void onComplete(@NonNull Task<Void> task) {
                                //권한 있는 경우
                                if (task.isSuccessful()) {
                                    Log.i(TAG, "Successfully subscribed!");
                                    //걸음 수 읽음
                                    readStepCountData();
                                } else {
                                    Log.w(TAG, "There was a problem subscribing.", task.getException());
                                }
                            }
                        })
                .addOnFailureListener(new OnFailureListener() {
                    @Override
                    public void onFailure(@NonNull Exception e) {
                        Log.w(TAG, "There was a problem subscribing. steps"+ e.getMessage());
                    }
                });

    }

    public void readStepCountData() {
        Fitness.getHistoryClient(this, GoogleSignIn.getLastSignedInAccount(this))
                .readDailyTotal(DataType.TYPE_STEP_COUNT_DELTA)
                .addOnSuccessListener(
                        new OnSuccessListener<DataSet>() {
                            @Override
                            public void onSuccess(DataSet dataSet) {
                                long total =
                                        dataSet.isEmpty()
                                                ? 0
                                                : dataSet.getDataPoints().get(0).getValue(Field.FIELD_STEPS).asInt();
                                step = total;
                                Log.i(TAG, "Total steps = " + total);
                            }
                        })
                .addOnFailureListener(
                        new OnFailureListener() {
                            @Override
                            public void onFailure(@NonNull Exception e) {
                                Log.w(TAG, "There was a problem getting the step count.", e);
                            }
                        });
    }

    public void initializeDistance() {
        Fitness.getRecordingClient(this , GoogleSignIn.getLastSignedInAccount(this))
                .subscribe(DataType.TYPE_DISTANCE_DELTA)
                .addOnCompleteListener(
                        new OnCompleteListener<Void>() {
                            @Override
                            public void onComplete(@NonNull Task<Void> task) {
                                if (task.isSuccessful()) {
                                    Log.i(TAG, "Successfully subscribed for distance!");
                                    readDistanceData();//false
                                } else {
                                    Log.w(TAG, "There was a problem distance subscribing.", task.getException());
                                }
                            }
                        })
                .addOnFailureListener(new OnFailureListener() {
                    @Override
                    public void onFailure(@NonNull Exception e) {
                        Log.i(TAG, "There was a problem distance subscribing."+ e.getMessage());
                    }
                });
    }


    public void readDistanceData() {
        Fitness.getHistoryClient(this, GoogleSignIn.getLastSignedInAccount(this))
                .readDailyTotal(DataType.TYPE_DISTANCE_DELTA)
                .addOnSuccessListener(
                        new OnSuccessListener<DataSet>() {
                            @Override
                            public void onSuccess(DataSet dataSet) {
                                int total =
                                        (int) (dataSet.isEmpty()
                                                ? 0
                                                : dataSet.getDataPoints().get(0).getValue(Field.FIELD_DISTANCE).asFloat());
                                distance = total;
                                Log.i(TAG, "Total distance = " + total);
                            }
                        })
                .addOnFailureListener(
                        new OnFailureListener() {
                            @Override
                            public void onFailure(@NonNull Exception e) {
                                Log.w(TAG, "There was a problem getting the distance count.", e);
                            }
                        });

    }

    public static DataReadRequest queryFitnessData(){
        Calendar cal = Calendar.getInstance();
        Date now = new Date();
        cal.setTime(now);
        long endTime = cal.getTimeInMillis();
        cal.set(Calendar.HOUR_OF_DAY, 00);
        cal.set(Calendar.MINUTE, 0);
        cal.set(Calendar.SECOND, 0);
//        cal.add(Calendar.DAY_OF_YEAR, -16);
        long startTime = cal.getTimeInMillis();
//        cal.add(Calendar.DAY_OF_YEAR, 1);
//        endTime = cal.getTimeInMillis();

        SimpleDateFormat format = new SimpleDateFormat("yyyy년 MM월dd일 HH시mm분ss초");
        Log.i(TAG, "Range Start" + format.format(startTime));
        Log.i(TAG, "Range End" + format.format(endTime));

        DataReadRequest readRequest =
                new DataReadRequest.Builder()
                        .aggregate(DataType.TYPE_ACTIVITY_SEGMENT)
                        .aggregate(DataType.TYPE_CALORIES_EXPENDED)
                        .aggregate(DataType.TYPE_DISTANCE_DELTA)
                        .aggregate(DataType.TYPE_MOVE_MINUTES)
                        .aggregate(DataType.TYPE_POWER_SAMPLE)
                        .bucketByActivityType(1, TimeUnit.MILLISECONDS)
                        .setTimeRange(startTime, endTime, TimeUnit.MILLISECONDS)
                        .build();

        return readRequest;
    }

    private Task<DataReadResponse> readHistoryData() {
        DataReadRequest readRequest = queryFitnessData();

        // Invoke the History API to fetch the data with the query
        return Fitness.getHistoryClient(this, GoogleSignIn.getLastSignedInAccount(this))
                .readData(readRequest)
                .addOnSuccessListener(
                        new OnSuccessListener<DataReadResponse>() {
                            @Override
                            public void onSuccess(DataReadResponse dataReadResponse) {
                                //Log.e(TAG, "NO PROBLEM");
                                printData(dataReadResponse);
                                storeBandData();
                                connectToServer();
                            }
                        })
                .addOnFailureListener(
                        new OnFailureListener() {
                            @Override
                            public void onFailure(@NonNull Exception e) {
                                Log.e(TAG, "There was a problem reading history data.", e);
                            }
                        });
    }

    private void connectToServer() {
        final ContentValues values = new ContentValues();
        final Context appContext = this.getApplicationContext();
        int id = PreferenceManager.getID(appContext);
        int val=PreferenceManager.getWeight(appContext);
        float run_cal;
        float walk_cal;
        final String url2 = "https://smartpt.ml/form_miband.php?code="+id;
        SmartPT smartPT = SmartPT.getInstance();
        BandData bandData = smartPT.getBandData();
      //  values.put("cal", String.valueOf(bandData.calories));
       // values.put("dist", String.valueOf(bandData.distances));
        //values.put("min", String.valueOf(bandData.minutes));
        walk_cal= (float) (bandData.minutes[0]*val*0.07);
        run_cal= (float) (bandData.minutes[1]*val*0.1225);

        values.put("walk_cal", walk_cal);
        values.put("walk_dist",bandData.distances[0]);
        values.put("walk_min",bandData.minutes[0]);
        values.put("run_cal", run_cal);
        values.put("run_dist",bandData.distances[1]);
        values.put("run_min",bandData.minutes[1]);
        NetworkTask networkTask = new NetworkTask(url2, values, appContext, Opcode.LoginRequest, "POST");
        networkTask.execute();
        //bandData의 크기5calories, distances, minutes
    }

    void storeBandData(){
        BandData bandData = new BandData();
        bandData.distances = distances;
        bandData.calories = calories;
        bandData.minutes = minutes;
        SmartPT smartPT = SmartPT.getInstance();
        smartPT.setBandData(bandData);
        Log.d(TAG, bandData.toString());
    }

    static void dumpDataSet(DataSet dataSet, String activity) {
        if (dataSet.isEmpty()) {
            Log.e(TAG, "빈 셋");
            return;
        }
        SimpleDateFormat dateFormat = new SimpleDateFormat();
        for (DataPoint dp : dataSet.getDataPoints()) {
            String s = String.format("Data point: %s -> %s   %s",
                    dp.getDataType().getName(),
                    dateFormat.format(dp.getStartTime(TimeUnit.MILLISECONDS)),
                    dateFormat.format(dp.getEndTime(TimeUnit.MILLISECONDS)));
            Log.i(TAG, s);

            //칼로리
            if(dp.getDataType().equals(DataType.TYPE_CALORIES_EXPENDED))
                setActivityCal(activity, dp.getValue(Field.FIELD_CALORIES).asFloat());
            //거리
            else if(dp.getDataType().equals(DataType.TYPE_DISTANCE_DELTA))
                setActivityDis(activity, dp.getValue(Field.FIELD_DISTANCE).asFloat());
            //운동시간
            else if(dp.getDataType().equals(DataType.TYPE_MOVE_MINUTES))
                setActivitymov(activity, dp.getValue(Field.FIELD_DURATION).asInt());
            //시간
            else
                setActivityMin(dp.getValue(Field.FIELD_ACTIVITY).asInt(), dp.getValue(Field.FIELD_DURATION).asInt());

            for(Field field : dp.getDataType().getFields()) {
                String name = field.getName();
                Value value = dp.getValue(field);
                Log.i(TAG, "\t" + name + " = " + value.toString());
            }
        }
    }

    public static void printData(DataReadResponse dataReadResult) {
        int bucketSize = dataReadResult.getBuckets().size();
        if (bucketSize > 0) {
            Log.i(TAG, "Number of returned buckets of DataSets is: " + bucketSize);
            for (Bucket bucket : dataReadResult.getBuckets()) {
                String bucketActivity = bucket.getActivity();
                List<DataSet> dataSets = bucket.getDataSets();
                for (DataSet dataSet : dataSets) {
                    dumpDataSet(dataSet, bucketActivity);
                }
            }
        }
        else{
            Log.i(TAG, "Nothing to print");
        }
    }

    private static int getCategory(int activity){
        if(activity == 7)
            return 0;//Walking
        else if(activity == 8)
            return 1;//Running
        else if(activity == 3)
            return 2;//Nothing
        else
            return 3;//Others
    }
    private static int getCategory(String activity){
        if(activity.contains(FitnessActivities.WALKING))
            return 0;
        else if(activity.contains(FitnessActivities.RUNNING))
            return 1;
        else if(activity.contains(FitnessActivities.STILL))
            return 2;
        else
            return 3;
    }

    private static void setActivityMin(int category, int millisecond){
        int c = getCategory(category);
        minutes[c] += millisecond/1000/60;
        for(int i=0;i<4;i++){
            Log.i(TAG, "활동 : "+categories[i] +"분 : "+ minutes[i]);
        }
    }
    private static void setActivityCal(String activity, float calorie){
        int c = getCategory(activity);
        calories[c] += calorie;
        for(int i=0;i<4;i++){
            Log.i(TAG, "활동 : "+categories[i] +"칼로리 : "+ calories[i]);
        }
    }
    private static void setActivityDis(String activity, float distance){
        int c = getCategory(activity);
        distances[c] += distance;
        for(int i=0;i<4;i++){
            Log.i(TAG, "활동 : "+categories[i] +"거리 : "+ distances[i]);
        }
    }

    private static void setActivitymov(String activity, float distance){
        int c = getCategory(activity);
        move[c] += distance;
        for(int i=0;i<4;i++){
            Log.i(TAG, "활동 : "+categories[i] +"무브 : "+ move[i]);
        }
    }
}