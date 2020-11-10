package com.example.smartpt;


import androidx.appcompat.app.AppCompatActivity;

import android.content.ContentValues;
import android.content.Context;
import android.content.Intent;
import android.os.Bundle;
import android.view.View;
import android.widget.Button;
import android.widget.EditText;

import com.example.smartpt.network.NetworkTask;
import com.example.smartpt.network.Opcode;

public class post extends AppCompatActivity {

    private R r;
    @Override
    protected void onCreate(Bundle savedInstanceState) {

        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_post);

        final String url = "https://smartpt.ml/test.php";
        // AsyncTask를 통해 HttpURLConnection 수행.
        final ContentValues values = new ContentValues();
        Button login_button = (Button)findViewById(R.id.login);

        final Context appContext = this.getApplicationContext();
        login_button.setOnClickListener(
                new View.OnClickListener() {
                    @Override
                    public void onClick(View view) {
                        values.put("username", "123");
                        values.put("password", "456");
                        NetworkTask networkTask = new NetworkTask(url, values, appContext, Opcode.LoginRequest, "POST");
                        networkTask.execute();
                    }
                });


    }
}