package com.example.smartpt;

import android.content.ContentValues;
import android.content.Context;
import android.content.Intent;
import android.graphics.Bitmap;
import android.os.Bundle;
import android.text.method.ScrollingMovementMethod;
import android.view.View;
import android.widget.Button;
import android.widget.ImageView;
import android.widget.RadioButton;
import android.widget.TextView;
import android.widget.Toast;

import androidx.appcompat.app.AppCompatActivity;

import com.wonderkiln.camerakit.CameraKitError;
import com.wonderkiln.camerakit.CameraKitEvent;
import com.wonderkiln.camerakit.CameraKitEventListener;
import com.wonderkiln.camerakit.CameraKitImage;
import com.wonderkiln.camerakit.CameraKitVideo;
import com.wonderkiln.camerakit.CameraView;

import java.util.List;
import java.util.concurrent.Executor;
import java.util.concurrent.Executors;

import com.example.smartpt.network.NetworkTask;
import com.example.smartpt.network.Opcode;


public class CameraActivity extends AppCompatActivity {
    private static final String MODEL_PATH = "60food_tf.tflite";
    private static final boolean QUANT = false;
    private static final String LABEL_PATH = "labels.txt";
    private static final int INPUT_SIZE = 50;

    private Classifier classifier;

    private Executor executor = Executors.newSingleThreadExecutor();
    private Button btnDetectObject, btnSearch, btnFood1,btnFood2,btnFood3;
    private CameraView cameraView;
    private String id1,id2,id3;
    private RadioButton btnRadio1,btnRadio2,btnRadio3;
    private Integer amount=0;


    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_camera);
        cameraView = findViewById(R.id.cameraView);
        Intent gintent = getIntent();

        final int data=gintent.getIntExtra("data",1);


        final ContentValues values = new ContentValues();
        final Context appContext = this.getApplicationContext();

        int id = PreferenceManager.getID(appContext);
        final String url = "https://smartpt.ml/updatefoodinput.php?code="+id;
        btnRadio1 = findViewById(R.id.radio0);
        btnRadio2 = findViewById(R.id.radio1);
        btnRadio3 = findViewById(R.id.radio2);

        btnFood1 = findViewById(R.id.btn_food1);
        btnFood2 = findViewById(R.id.btn_food2);
        btnFood3 = findViewById(R.id.btn_food3);

        btnSearch = findViewById(R.id.btnSearch);
        btnDetectObject = findViewById(R.id.btnDetectObject);

        btnFood1.setVisibility(btnFood1.INVISIBLE);
        btnFood2.setVisibility(btnFood2.INVISIBLE);
        btnFood3.setVisibility(btnFood3.INVISIBLE);

        btnSearch.setVisibility(btnSearch.INVISIBLE);

        btnRadio1.setVisibility(btnRadio1.INVISIBLE);
        btnRadio2.setVisibility(btnRadio2.INVISIBLE);
        btnRadio3.setVisibility(btnRadio3.INVISIBLE);

        cameraView.addCameraKitListener(new CameraKitEventListener() {

            @Override
            public void onEvent(CameraKitEvent cameraKitEvent) {

            }

            @Override
            public void onError(CameraKitError cameraKitError) {

            }

            @Override
            public void onImage(CameraKitImage cameraKitImage) {

                Bitmap bitmap = cameraKitImage.getBitmap();

                bitmap = Bitmap.createScaledBitmap(bitmap, INPUT_SIZE, INPUT_SIZE, false);


                List<Classifier.Recognition> results = classifier.recognizeImage(bitmap);


                btnFood1.setText("BUTTON1");
                btnFood1.setEnabled(false);
                btnFood2.setText("BUTTON2");
                btnFood2.setEnabled(false);
                btnFood3.setText("BUTTON3");
                btnFood3.setEnabled(false);

                id1="";
                id2="";
                id3="";

                String[] array = results.toString().split(",");
                for(int i =0;i<array.length;i++) {
                    if(i==0) {
                        btnFood1.setText(results.get(0).getTitle());
                        btnFood1.setEnabled(true);

                        id1 = results.get(0).getId();
                    }if(i==1) {
                        btnFood2.setText(results.get(1).getTitle());
                        btnFood2.setEnabled(true);

                        id2 = results.get(1).getId();
                    }if(i==2) {
                        btnFood3.setText(results.get(2).getTitle());
                        btnFood3.setEnabled(true);

                        id3 = results.get(2).getId();
                    }
                }
                btnFood1.setVisibility(btnFood1.VISIBLE);
                btnFood2.setVisibility(btnFood2.VISIBLE);
                btnFood3.setVisibility(btnFood3.VISIBLE);

                btnSearch.setVisibility(btnSearch.VISIBLE);

                btnRadio1.setVisibility(btnRadio1.VISIBLE);
                btnRadio2.setVisibility(btnRadio2.VISIBLE);
                btnRadio3.setVisibility(btnRadio3.VISIBLE);


            }

            @Override
            public void onVideo(CameraKitVideo cameraKitVideo) {

            }
        });

        btnSearch.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {

                Intent myIntent = new Intent(getApplicationContext(), inputfood.class);
                myIntent.putExtra("data",data);
                startActivity(myIntent);
            }
        });

        btnDetectObject.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                cameraView.captureImage();
            }
        });

        initTensorFlowAndLoadModel();



        btnFood1.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                if(btnRadio1.isChecked())
                    amount=0;
                else if(btnRadio2.isChecked())
                    amount=1;
                else if(btnRadio3.isChecked())
                    amount=2;


                values.put("foodnum", Integer.parseInt(id1)+1);
                values.put("eaten_time",Integer.parseInt(String.valueOf(data)));
                values.put("serving",Integer.parseInt(String.valueOf(amount)));
                NetworkTask networkTask = new NetworkTask(url, values, appContext, Opcode.LoginRequest, "POST");
                networkTask.execute();
                //Intent myIntent = new Intent(getApplicationContext(), MainActivity.class);
                //startActivity(myIntent);
            }
        });
        btnFood2.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                if(btnRadio1.isChecked())
                    amount=0;
                else if(btnRadio2.isChecked())
                    amount=1;
                else if(btnRadio3.isChecked())
                    amount=2;

                btnFood2.setText(id2);

                values.put("foodnum", Integer.parseInt(id2)+1);
                values.put("eaten_time",data);
                values.put("serving",amount);
                NetworkTask networkTask = new NetworkTask(url, values, appContext, Opcode.LoginRequest, "POST");
                networkTask.execute();
                Intent myIntent = new Intent(getApplicationContext(), MainActivity.class);
                startActivity(myIntent);
            }
        });
        btnFood3.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                if(btnRadio1.isChecked())
                    amount=0;
                else if(btnRadio2.isChecked())
                    amount=1;
                else if(btnRadio3.isChecked())
                    amount=2;

                btnFood3.setText(id3);

                values.put("foodnum", Integer.parseInt(id3)+1);
                values.put("eaten_time",data);
                values.put("serving",amount);
                NetworkTask networkTask = new NetworkTask(url, values, appContext, Opcode.LoginRequest, "POST");
                networkTask.execute();
                Intent myIntent = new Intent(getApplicationContext(), MainActivity.class);
                startActivity(myIntent);
            }
        });
    }

    @Override
    protected void onResume() {
        super.onResume();
        cameraView.start();
    }

    @Override
    protected void onPause() {
        cameraView.stop();
        super.onPause();
    }

    @Override
    protected void onDestroy() {
        super.onDestroy();
        executor.execute(new Runnable() {
            @Override
            public void run() {
                classifier.close();
            }
        });
    }

    private void initTensorFlowAndLoadModel() {
        executor.execute(new Runnable() {
            @Override
            public void run() {
                try {
                    classifier = TensorFlowImageClassifier.create(
                            getAssets(),
                            MODEL_PATH,
                            LABEL_PATH,
                            INPUT_SIZE,
                            QUANT);
                    makeButtonVisible();
                } catch (final Exception e) {
                    throw new RuntimeException("Error initializing TensorFlow!", e);
                }
            }
        });
    }

    private void makeButtonVisible() {
        runOnUiThread(new Runnable() {
            @Override
            public void run() {
                btnDetectObject.setVisibility(View.VISIBLE);
            }
        });
    }
    public void onButtonClicked(View view) {
        Toast.makeText(getApplicationContext(),"Click", Toast.LENGTH_LONG).show();
        finish();
    }

    public CameraActivity getCameraActivity() {
        return this;
    }
}

