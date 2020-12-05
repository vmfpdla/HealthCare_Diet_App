package com.example.smartpt.MiScale;

import android.bluetooth.BluetoothAdapter;
import android.bluetooth.BluetoothManager;
import android.content.ContentValues;
import android.content.Context;
import android.content.Intent;
import android.os.Bundle;
import android.os.Handler;
import android.os.Message;
import android.util.Log;
import android.view.View;
import android.widget.AdapterView;
import android.widget.AdapterView.OnItemClickListener;
import android.widget.ArrayAdapter;
import android.widget.ImageView;
import android.widget.ListView;
import android.widget.TextView;
import android.widget.Toast;
import com.example.smartpt.bluetooth.BluetoothActivity;

import androidx.appcompat.app.AppCompatActivity;
import androidx.fragment.app.FragmentManager;
import androidx.fragment.app.FragmentTransaction;

import com.example.smartpt.MiBand.BandData;
import com.example.smartpt.PreferenceManager;
import com.example.smartpt.R;
import com.example.smartpt.SmartPT;
import com.example.smartpt.bluetooth.BluetoothSettingsFragment;
import com.example.smartpt.network.NetworkTask;
import com.example.smartpt.network.Opcode;

import java.lang.reflect.Array;

import timber.log.Timber;

public class MiScaleActivity extends AppCompatActivity {

    private TextView kgTv, bmiTv, waterTv, muscleTv, fatTv;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_mi_scale);

//        SmartPT smartPT = SmartPT.getInstance();
//        ScaleData scaleData = new ScaleData();
//        scaleData.bmi = 1;
//        scaleData.weight = 0;
//        scaleData.water = 2;
//        scaleData.muscle = 3;
//        scaleData.fat = 4;
//        smartPT.setScaleData(scaleData);
        initiateTextView();

    }

    private void initiateTextView() {
        kgTv = findViewById(R.id.kg_tv);
        bmiTv = findViewById(R.id.bmi_tv);
        waterTv = findViewById(R.id.water_tv);
        muscleTv = findViewById(R.id.muscle_tv);
        fatTv = findViewById(R.id.fat_tv);

        SmartPT smartPT = SmartPT.getInstance();
        if(smartPT.getScaleData()!=null){
            Log.d("SmartPT", "DD");
            ScaleData scaleData = smartPT.getScaleData();
            String status;
            if(scaleData.bmi<20){
                status = " (저체중)";
            }
            else if(scaleData.bmi<=24){
                status = " (정상)";
            }
            else if(scaleData.bmi<=29){
                status = " (과체중)";
            }
            else{
                status = " (비만)";
            }
            kgTv.setText(Float.toString(scaleData.weight)+ " Kg");
            bmiTv.setText("BMI : "+Float.toString(scaleData.bmi)+status);
            waterTv.setText("체수분 : "+Float.toString(scaleData.water) + "%");
            muscleTv.setText("근육량 : "+Float.toString(scaleData.muscle) + "%");
            fatTv.setText("체지방 : "+Float.toString(scaleData.fat) + "%");
            connectToServer(scaleData);
        }
        else{
            //finish();
            Log.d("SmartPT","끝내기");
        }
    }

    private void connectToServer(ScaleData scaleData) {
        final ContentValues values = new ContentValues();
        final Context appContext = this.getApplicationContext();
        int id = PreferenceManager.getID(appContext);
        final String url2 = "https://smartpt.ml/form_miscale.php?code="+id;

        //  values.put("cal", String.valueOf(bandData.calories));
        // values.put("dist", String.valueOf(bandData.distances));
        //values.put("min", String.valueOf(bandData.minutes));
        values.put("bmi",scaleData.bmi);
        values.put("muscle",scaleData.muscle);
        values.put("fat",scaleData.fat);
        values.put("weight",scaleData.weight);
        NetworkTask networkTask = new NetworkTask(url2, values, appContext, Opcode.miscaleRequest, "POST");
        networkTask.execute();
        //bandData의 크기5calories, distances, minutes
    }
}