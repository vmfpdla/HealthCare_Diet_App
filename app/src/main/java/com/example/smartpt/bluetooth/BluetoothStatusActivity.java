package com.example.smartpt.bluetooth;

import androidx.appcompat.app.AppCompatActivity;

import android.os.Bundle;

import com.example.smartpt.R;

public class BluetoothStatusActivity extends AppCompatActivity {

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_bluetooth_status);
        //bt는 켜져있음. --> 페어링을 해야됨
    }
}