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
    private TextView textViewResult;
    private Button btnDetectObject, btnSearch, btnFood1,btnFood2,btnFood3;
    private ImageView imageViewResult;
    private CameraView cameraView;
    private String id1,id2,id3;
    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_camera);
        cameraView = findViewById(R.id.cameraView);
        imageViewResult = findViewById(R.id.imageViewResult);
        textViewResult = findViewById(R.id.textViewResult);
        textViewResult.setMovementMethod(new ScrollingMovementMethod());

        btnFood1 = findViewById(R.id.btn_food1);
        btnFood2 = findViewById(R.id.btn_food2);
        btnFood3 = findViewById(R.id.btn_food3);

        btnSearch = findViewById(R.id.btnSearch);
        btnDetectObject = findViewById(R.id.btnDetectObject);

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

                imageViewResult.setImageBitmap(bitmap);

                List<Classifier.Recognition> results = classifier.recognizeImage(bitmap);


                btnFood1.setText("BUTTON1");
                btnFood2.setText("BUTTON2");
                btnFood3.setText("BUTTON3");
                id1="";
                id2="";
                id3="";

                String[] array = results.toString().split(",");
                for(int i =0;i<array.length;i++) {
                    if(i==0) {
                        btnFood1.setText(results.get(0).getTitle());
                        id1 = results.get(0).getId();
                    }if(i==1) {
                        btnFood2.setText(results.get(1).getTitle());
                        id2 = results.get(1).getId();
                    }if(i==2) {
                        btnFood3.setText(results.get(2).getTitle());
                        id3 = results.get(2).getId();
                    }
                }

            }

            @Override
            public void onVideo(CameraKitVideo cameraKitVideo) {

            }
        });

        btnSearch.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                Intent myIntent = new Intent(getApplicationContext(), MainActivity.class);
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
        final ContentValues values = new ContentValues();
        final Context appContext = this.getApplicationContext();
        final String url = "https://smartpt.ml/test.php";

        btnFood1.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                btnFood1.setText(id1);
                values.put("foodid", id1);
                NetworkTask networkTask = new NetworkTask(url, values, appContext, Opcode.LoginRequest, "POST");
                networkTask.execute();
            }
        });
        btnFood2.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                btnFood2.setText(id2);
                values.put("foodid", id2);
                NetworkTask networkTask = new NetworkTask(url, values, appContext, Opcode.LoginRequest, "POST");
                networkTask.execute();
            }
        });
        btnFood3.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                btnFood3.setText(id3);
                values.put("foodid", id3);
                NetworkTask networkTask = new NetworkTask(url, values, appContext, Opcode.LoginRequest, "POST");
                networkTask.execute();
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

