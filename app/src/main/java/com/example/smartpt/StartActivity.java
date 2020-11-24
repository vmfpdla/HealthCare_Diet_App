package com.example.smartpt;

import androidx.appcompat.app.AppCompatActivity;

import android.content.ContentValues;
import android.content.Context;
import android.content.Intent;
import android.os.Bundle;
import android.util.Log;
import android.widget.Toast;

import com.example.smartpt.network.NetworkTask;
import com.example.smartpt.network.Opcode;

public class StartActivity extends AppCompatActivity {
    private Context mContext;
    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);

        mContext = getApplicationContext();
        final ContentValues values = new ContentValues();
        final Context appContext = this.getApplicationContext();
        final String url2 = "https://smartpt.ml/userhere.php";
        int id  = PreferenceManager.getID(mContext);
        SmartPT smartPT = SmartPT.getInstance();
            boolean isFirst = PreferenceManager.getIsFirst(appContext);
            if (isFirst == false) {
                Log.d("SmartPT", "기존유저");
                //Toast.makeText(appContext, "old", Toast.LENGTH_SHORT).show();
                values.put("code",id);
                values.put("isNew",1);
                NetworkTask networkTask = new NetworkTask(url2, values, appContext, Opcode.RegisterRequest, "POST");
                networkTask.execute();


            } else{
            Log.d("SmartPT", "뉴비");
            //중복확인
            id = (int) (Math.random() * 1000000000);
            PreferenceManager.setID(mContext, id);
            values.put("code",id);
            values.put("isNew",0);
            NetworkTask networkTask = new NetworkTask(url2, values, appContext, Opcode.RegisterRequest, "POST");
            networkTask.execute();

            // Toast.makeText(appContext, "new", Toast.LENGTH_SHORT).show();
            }



    }
}