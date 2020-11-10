package com.example.smartpt.network;

import android.content.ContentValues;
import android.content.Context;
import android.content.Intent;
import android.os.AsyncTask;
import android.os.Build;
import android.os.Handler;
import android.widget.ImageView;
import android.widget.TextView;
import android.widget.Toast;

import androidx.annotation.RequiresApi;
import androidx.appcompat.app.AppCompatActivity;


import com.example.smartpt.MainActivity;
import com.example.smartpt.R;

import com.example.smartpt.post;


import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import java.util.ArrayList;
import java.util.Base64;

import static android.content.Intent.FLAG_ACTIVITY_NEW_TASK;
import static android.content.Intent.makeMainActivity;

public class NetworkTask extends AsyncTask<Void, Void, String> {
    private String url;
    private ContentValues values;
    private Context context;
    private String result;
    private Opcode opcode;
    private String type;


    public NetworkTask(String url, ContentValues values, Context context, Opcode opcode, String type) {

        this.url = url;
        this.values = values;
        this.context = context;
        this.opcode = opcode;
        this.type = type;
    }


    @Override
    protected String doInBackground(Void... params) {

        String result; // 요청 결과를 저장할 변수.
        RequestHttpConnection requestHttpURLConnection = new RequestHttpConnection();
        result = requestHttpURLConnection.request(url, values, type); // 해당 URL로 부터 결과물을 얻어온다.

        return result;
    }

    @RequiresApi(api = Build.VERSION_CODES.O)
    @Override
    protected void onPostExecute(String s) {
        super.onPostExecute(s);
        result = s;
        Handler handler = new Handler(context.getMainLooper());
        //doInBackground()로 부터 리턴된 값이 onPostExecute()의 매개변수로 넘어오므로 s를 출력한다.
        switch ( opcode ) {
            case LoginRequest:
                handler.post(new Runnable() {
                    public void run() {
                        if (result.contains("success")) {
                            Intent intent = new Intent(context, MainActivity.class);
                            intent.addFlags(FLAG_ACTIVITY_NEW_TASK);
                            Toast.makeText(context, result, Toast.LENGTH_SHORT).show();
                            context.startActivity(intent);
                        } else {
                            Toast.makeText(context, "login failed!", Toast.LENGTH_SHORT).show();
                        }
                    }
                });
                break;
            case RegisterRequest:
                handler.post(new Runnable() {
                    public void run() {
                        Intent intent = new Intent(context, post.class);
                        intent.addFlags(FLAG_ACTIVITY_NEW_TASK);
                        if (!result.contains("error message : ")) {
                            Toast.makeText(context, "register success!", Toast.LENGTH_SHORT).show();
                            context.startActivity(intent);
                        } else {
                            Toast.makeText(context, "register failed!", Toast.LENGTH_SHORT).show();
                        }
                    }
                });
                break;


        }
    }
}
