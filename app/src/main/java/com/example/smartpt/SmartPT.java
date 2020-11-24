package com.example.smartpt;

import android.content.Context;
import android.os.Handler;

import com.example.smartpt.MiBand.BandData;
import com.example.smartpt.MiScale.ScaleData;
import com.example.smartpt.bluetooth.BluetoothCommunication;
import com.example.smartpt.bluetooth.BluetoothFactory;

import timber.log.Timber;

public class SmartPT {
    public static boolean DEBUG_MODE = false;
    public static int MALE = 0;
    public static int FEMALE = 1;
    public static int NEW = 0;
    public static int NOT_NEW = 1;


//    public static final String DATABASE_NAME = "smartpt.db";

    private static SmartPT instance;
    //scaleData에 미스케일 정보 들어있음
    private ScaleData scaleData;
    //bandData에 미밴드 정보 들어있음
    private BandData bandData;
    private String deviceName;
    private String deviceAddress;
    private int userHeight;
    private int userSex;
    private int userAge;
    private int userId;
    private boolean isNew;
    private boolean weightChange;
    private BluetoothCommunication btDeviceDriver;

    private Context context;

    private SmartPT(Context context) {
        this.context = context;
        btDeviceDriver = null;
        deviceAddress = "address : Null";
        deviceName = "name : Null";
//        userId = PreferenceManager.getID(context);
        userId = -1;
        userHeight = -1;
        userAge = -1;
        userSex = -1;
        scaleData = null;
        bandData = null;
        isNew = true;
        weightChange = true;

    }

    public void setWeightChange(boolean b){
        weightChange = b;
    }
    public boolean getWeightChange(){
        return weightChange;
    }
    public void setDevice(String name, String address){
        deviceName = name;
        deviceAddress = address;
    }
    public int getUserId(){
        return userId;
    }
    public void setUserInfo(int height, int sex, int age){
        userHeight = height;
        userSex = sex;
        userAge = age;
    }
    public int getUserHeight(){
        return userHeight;
    }
    public int getUserSex(){
        return userSex;
    }
    public int getUserAge(){
        return userAge;
    }
    public void setUserId(int id){
        userId = id;
    }
    public void setScaleData(ScaleData data){
        scaleData = data;
    }
    public ScaleData getScaleData(){
        if(scaleData==null) return null;
        else return scaleData;
    }
    public void setBandData(BandData data) { bandData = data; }
    public BandData getBandData() {
        if(bandData==null) return null;
        else return bandData;
    }
    public String getDeviceName(){
        return deviceName;
    }
    public String getDeviceAddress(){
        return deviceAddress;
    }
    public static void createInstance(Context context) {
        if (instance != null) {
            return;
        }
        instance = new SmartPT(context);
    }
    public static SmartPT getInstance() {
        if (instance == null) {
            throw new RuntimeException("No OpenScale instance created");
        }
        return instance;
    }

    public boolean connectToBluetoothDevice(String deviceName, String hwAddress, Handler callbackBtHandler) {
        Timber.d("Trying to connect to bluetooth device [%s] (%s)", hwAddress, deviceName);

        disconnectFromBluetoothDevice();

        btDeviceDriver = BluetoothFactory.createDeviceDriver(context, deviceName);
        if (btDeviceDriver == null) {
            return false;
        }

        btDeviceDriver.registerCallbackHandler(callbackBtHandler);
        btDeviceDriver.connect(hwAddress);

        return true;
    }

    public boolean disconnectFromBluetoothDevice() {
        if (btDeviceDriver == null) {
            return false;
        }

        Timber.d("Disconnecting from bluetooth device");
        btDeviceDriver.disconnect();
        btDeviceDriver = null;

        return true;
    }
}
