package com.example.smartpt;

import androidx.appcompat.app.AppCompatActivity;

import android.content.ContentValues;
import android.content.Context;
import android.content.Intent;
import android.os.Bundle;
import android.util.Log;

import com.example.smartpt.bluetooth.BluetoothActivity;
import com.example.smartpt.network.NetworkTask;
import com.example.smartpt.network.Opcode;

public class updateActivity extends AppCompatActivity {

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);

        Intent gintent=getIntent();

        final Context appContext = this.getApplicationContext();
        int id = PreferenceManager.getID(appContext);
        int sex=gintent.getIntExtra("sex",1);
        int height=gintent.getIntExtra("height",1);
        int age=gintent.getIntExtra("age",1);
        int weight=gintent.getIntExtra("weight",1);


        /*values.put("sex",sex);
        values.put("height",height);
        values.put("age",age);

        NetworkTask networkTask = new NetworkTask(url2, values, appContext, Opcode.LoginRequest, "POST");
        networkTask.execute();
*/
        SmartPT smartPT = SmartPT.getInstance();
        smartPT.setUserInfo(height, sex, age);
        PreferenceManager.setHeight(appContext, height);
        PreferenceManager.setAge(appContext, age);
        PreferenceManager.setSex(appContext, sex);
        PreferenceManager.setWeight(appContext,weight);


        setContentView(R.layout.activity_update);
        Log.d("fortest1 : ",Integer.toString(height));
        Log.d("fortest2 : ",Integer.toString(age));
        Log.d("fortest3 : ",Integer.toString(sex));
        Log.d("fortest4 : ",Integer.toString(weight));
        Intent intent=new Intent(appContext.getApplicationContext(), MainActivity.class);
        startActivity(intent);
    }
}