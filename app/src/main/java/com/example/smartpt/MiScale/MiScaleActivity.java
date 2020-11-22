package com.example.smartpt.MiScale;

import android.bluetooth.BluetoothAdapter;
import android.bluetooth.BluetoothManager;
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

import androidx.appcompat.app.AppCompatActivity;
import androidx.fragment.app.FragmentManager;
import androidx.fragment.app.FragmentTransaction;

import com.example.smartpt.PreferenceManager;
import com.example.smartpt.R;
import com.example.smartpt.SmartPT;
import com.example.smartpt.bluetooth.BluetoothActivity;
import com.example.smartpt.bluetooth.BluetoothSettingsFragment;

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
//        Intent intent = new Intent(this, BluetoothActivity.class);
//        startActivity(intent);

    }

    private void initiateTextView() {
        kgTv = findViewById(R.id.kg_tv);
        bmiTv = findViewById(R.id.bmi_tv);
        waterTv = findViewById(R.id.water_tv);
        muscleTv = findViewById(R.id.muscle_tv);
        fatTv = findViewById(R.id.fat_tv);

        SmartPT smartPT = SmartPT.getInstance();
        ScaleData scaleData;
        if(smartPT.getScaleData()!=null){
            scaleData = smartPT.getScaleData();
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
            waterTv.setText("수분량 : "+Float.toString(scaleData.water));
            muscleTv.setText("근육량 : "+Float.toString(scaleData.muscle));
            fatTv.setText("지방량 : "+Float.toString(scaleData.fat));
            connectToServer(scaleData);
        }
        else{
            finish();
        }
    }

    private void connectToServer(ScaleData scaleData) {

    }
}