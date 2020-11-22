package com.example.smartpt;

import android.content.Context;
import android.content.SharedPreferences;

import androidx.core.content.ContextCompat;

public class PreferenceManager {
    public static final String PREFERENCES_NAME = "preference";
    private static final int USER_ID = -1;
    private static final boolean IS_FIRST = true;
    private static final String DEVICE_NAME = "empty";
    private static final String DEVICE_ADDRESS = "empty";

    private static SharedPreferences getPreferences(Context context){
        return context.getSharedPreferences(PREFERENCES_NAME, Context.MODE_PRIVATE);
    }

    public static void setDeviceAddress(Context context, String address){
        SharedPreferences prefs = getPreferences(context);
        SharedPreferences.Editor editor = prefs.edit();
        editor.putString("DeviceAddress", address);
        editor.commit();
    }
    public static void setDeviceName(Context context, String name){
        SharedPreferences prefs = getPreferences(context);
        SharedPreferences.Editor editor = prefs.edit();
        editor.putString("DeviceName", name);
        editor.commit();
    }
    public static void setID(Context context, int value){
        SharedPreferences prefs = getPreferences(context);
        SharedPreferences.Editor editor = prefs.edit();
        editor.putInt("ID", value);
        editor.commit();
    }
    public static void setIsFirst(Context context, boolean value) {
        SharedPreferences prefs = getPreferences(context);
        SharedPreferences.Editor editor = prefs.edit();
        editor.putBoolean("First", value);
        editor.commit();
    }
    public static String getDeviceName(Context context){
        SharedPreferences prefs = getPreferences(context);
        String value = prefs.getString("DeviceName", DEVICE_NAME);
        return value;
    }
    public static String getDeviceAddress(Context context){
        SharedPreferences prefs = getPreferences(context);
        String value = prefs.getString("DeviceAddress", DEVICE_ADDRESS);
        return value;
    }
    public static int getID(Context context) {
        SharedPreferences prefs = getPreferences(context);
        int value = prefs.getInt("ID", USER_ID);
        return value;
    }
    public static boolean getIsFirst(Context context) {
        SharedPreferences prefs = getPreferences(context);
        boolean value = prefs.getBoolean("First", IS_FIRST);
        return value;
    }
    //키값 삭제
    public static void removeKey(Context context, String key) {
        SharedPreferences prefs = getPreferences(context);
        SharedPreferences.Editor edit = prefs.edit();
        edit.remove(key);
        edit.commit();
    }
    //모든 데이터 삭제
    public static void clear(Context context) {
        SharedPreferences prefs = getPreferences(context);
        SharedPreferences.Editor edit = prefs.edit();
        edit.clear();
        edit.commit();
    }
}
