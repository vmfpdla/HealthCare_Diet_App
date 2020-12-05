package com.example.smartpt;

import androidx.appcompat.app.AppCompatActivity;

import android.content.ContentValues;
import android.content.Context;
import android.content.Intent;
import android.os.Bundle;
import android.util.Log;
import android.webkit.WebSettings;
import android.webkit.WebView;
import android.webkit.WebViewClient;
import android.widget.Toast;

import com.example.smartpt.MiBand.MiBandActivity;
import com.example.smartpt.MiScale.MiScaleActivity;
import com.example.smartpt.bluetooth.BluetoothActivity;
import com.example.smartpt.network.NetworkTask;
import com.example.smartpt.network.Opcode;

public class MainActivity extends AppCompatActivity {
    private WebView mWebView;
    private WebSettings mWebSettings;
    private Context mContext; // 요거는 웹뷰랑 액티비티 왔다갔다하려고 만든거

    int id;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_main);
        mContext = getApplicationContext();
        id   = PreferenceManager.getID(mContext);
        //PreferenceManager.setID(mContext, id);
        //Log.d("id", Integer.toString(com.example.smartpt.PreferenceManager.getID(mContext)));

        mWebView = (WebView) findViewById(R.id.wv);
        mContext = this.getApplicationContext();

        mWebView.setWebViewClient(new WebViewClient()); // 클릭시 새창 안뜨게
        mWebSettings = mWebView.getSettings(); //세부 세팅 등록
        mWebSettings.setJavaScriptEnabled(true); // 웹페이지 자바스클비트 허용 여부
        mWebSettings.setSupportMultipleWindows(false); // 새창 띄우기 허용 여부
        mWebSettings.setJavaScriptCanOpenWindowsAutomatically(false); // 자바스크립트 새창 띄우기(멀티뷰) 허용 여부
        mWebSettings.setLoadWithOverviewMode(true); // 메타태그 허용 여부
        mWebSettings.setUseWideViewPort(true); // 화면 사이즈 맞추기 허용 여부
        mWebSettings.setSupportZoom(false); // 화면 줌 허용 여부
        mWebSettings.setBuiltInZoomControls(false); // 화면 확대 축소 허용 여부
        mWebSettings.setLayoutAlgorithm(WebSettings.LayoutAlgorithm.SINGLE_COLUMN); // 컨텐츠 사이즈 맞추기
        mWebSettings.setCacheMode(WebSettings.LOAD_NO_CACHE); // 브라우저 캐시 허용 여부
        mWebSettings.setDomStorageEnabled(true); // 로컬저장소 허용 여부

        mWebView.loadUrl("https://smartpt.ml?code="+id); // 웹뷰에 표시할 웹사이트 주소, 웹뷰 시작
        mWebView.setWebViewClient(new WebViewClientClass());
    }

    private class WebViewClientClass extends WebViewClient{
        @Override
        public boolean shouldOverrideUrlLoading(WebView view, String url){

            if (url.startsWith("app://")){
                Intent intent=new Intent(mContext.getApplicationContext(),CameraActivity.class);
                int data =Integer.parseInt(url.substring(6));
                intent.putExtra("data",data);
                startActivity(intent);
                return true;
            }
            else if (url.startsWith("band://")){
                Intent intent=new Intent(mContext.getApplicationContext(), MiBandActivity.class);
                startActivity(intent);
                return true;
            }
            else if (url.startsWith("scale://")){
                Intent intent=new Intent(mContext.getApplicationContext(), BluetoothActivity.class);
                startActivity(intent);
                return true;
            }
            else if (url.startsWith("update://")){
                Intent intent=new Intent(mContext.getApplicationContext(), updateActivity.class);
                int sex=Integer.parseInt(url.substring(url.indexOf("s")+1,url.indexOf("&")));
                int height=Integer.parseInt(url.substring(url.indexOf("h")+1,url.indexOf("#")));
                int age=Integer.parseInt(url.substring(url.indexOf("q")+1,url.indexOf("!")));
                int kg=Integer.parseInt(url.substring(url.indexOf("k")+1,url.indexOf("^")));

                intent.putExtra("sex",sex);
                intent.putExtra("height",height);
                intent.putExtra("age",age);
                intent.putExtra("weight",kg);
                startActivity(intent);
                return true;
            }
            else{
                view.loadUrl(url);
                return true;
            }
        }

    }



}