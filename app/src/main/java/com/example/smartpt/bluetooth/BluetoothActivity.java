package com.example.smartpt.bluetooth;

import androidx.appcompat.app.AppCompatActivity;
import androidx.fragment.app.FragmentManager;
import androidx.fragment.app.FragmentTransaction;

import android.bluetooth.BluetoothAdapter;
import android.bluetooth.BluetoothManager;
import android.content.Context;
import android.content.Intent;
import android.os.Bundle;
import android.os.Handler;
import android.os.Message;
import android.util.Log;
import android.view.View;
import android.widget.Button;
import android.widget.ImageView;
import android.widget.Toast;
import android.widget.TextView;

import com.example.smartpt.MiScale.MiScaleActivity;
import com.example.smartpt.PreferenceManager;
import com.example.smartpt.R;
import com.example.smartpt.SmartPT;

import timber.log.Timber;

public class BluetoothActivity extends AppCompatActivity {


    private Context context;
    private TextView nameTv, addTv, explainTv;

    private static final int ENABLE_BLUETOOTH_REQUEST = 102;
    private static final int REQUEST_ENABLE_BT = 0;
    private static final int BT_ON = 1;         //블투 켜진상태
    private static final int BT_OFF = 2;        //블투 꺼진상태
    private static final int BT_SEARCHING = 3;  //블투 찾는상태
    private static final int BT_PAIRING = 4;    //블투 페어링상태

    private SmartPT smartPT = SmartPT.getInstance();
    private int btState;
    private Button btn;

    private ImageView bltIv;

    //    private static Button bluetoothStatus;
    private static boolean firstAppStart = true;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_bluetooth);
        context = getApplicationContext();
        initializeLayout();
        initializeBluetooth();
    }

    private void initializeBluetooth() {
        BluetoothManager bluetoothManager = (BluetoothManager) getSystemService(BLUETOOTH_SERVICE);
        boolean hasBluetooth = bluetoothManager.getAdapter() != null;

        if (!hasBluetooth) {
            Log.d("bluetooth", "Bluetooth is not available");
        } else if (firstAppStart) {
            Log.d("bluetooth", "Bluetooth is available-first");
            invokeConnectToBluetoothDevice();
            firstAppStart = false;
        } else {
            Log.d("bluetooth", "Bluetooth is available");
        }

        final BluetoothAdapter bluetoothAdapter = bluetoothManager.getAdapter();
        if (bluetoothAdapter.isEnabled()) {
            btState = BT_ON;
            bltIv.setImageResource(R.drawable.ic_bt_on);
        }
//        else if(){
//
//        }
        else {
            btState = BT_OFF;
            bltIv.setImageResource(R.drawable.ic_bl_disabled);
        }
        if (btState == BT_OFF) {
//                    showToast("Turning on bluetooth");
                    bltIv.setImageResource(R.drawable.ic_bt_on);
                    btState = BT_ON;
                    Intent intent = new Intent(BluetoothAdapter.ACTION_REQUEST_ENABLE);
                    startActivityForResult(intent, REQUEST_ENABLE_BT);
        }


        bltIv.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                if (btState == BT_OFF) {
//                    showToast("Turning on bluetooth");
                    bltIv.setImageResource(R.drawable.ic_bt_on);
                    btState = BT_ON;
                    //Intent intent = new Intent(BluetoothAdapter.ACTION_REQUEST_ENABLE);
                    //startActivityForResult(intent, REQUEST_ENABLE_BT);
                }
                else if(btState == BT_ON){
                    bltIv.setImageResource(R.drawable.ic_bt_searching);
                    btState = BT_SEARCHING;
                    smartPT.setWeightChange(true);
                    Log.d("SmartPT", "바꿈");
                    invokeConnectToBluetoothDevice();

//                    Intent intent = new Intent(this.context, MiScaleActivity.class);
//                    intent.addFlags(Intent.FLAG_ACTIVITY_NEW_TASK);
//                    this.context.startActivity(intent);
                }
                else {
                   // bluetoothAdapter.disable();
                    btState = BT_ON;
//                    showToast("Turning bluetooth off");
                    bltIv.setImageResource(R.drawable.ic_bt_on);
                }
            }
        });
    }

    private void initializeLayout() {
        FragmentManager fm = getSupportFragmentManager();
        FragmentTransaction fragmentTransaction = fm.beginTransaction();
        fragmentTransaction.add(R.id.fragment, new BluetoothSettingsFragment());
        fragmentTransaction.commit();
        btn = findViewById(R.id.check_btn);
        btn.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                Intent intent = new Intent(context, MiScaleActivity.class);
                intent.addFlags(Intent.FLAG_ACTIVITY_NEW_TASK);
                context.startActivity(intent);
            }
        });


        bltIv = findViewById(R.id.blt_iv);
        nameTv = findViewById(R.id.device_name_tv);
        addTv = findViewById(R.id.device_add_tv);
        explainTv = findViewById(R.id.explain_tv);
        String name, add;
        name = PreferenceManager.getDeviceName(context);
        add = PreferenceManager.getDeviceAddress(context);

        if(name.equals("empty") || add.equals("empty")){
            nameTv.setText("등록된 기기가 없습니다.");
            addTv.setText("등록된 기기가 없습니다.");
            explainTv.setText("기기를 등록해 주세요");
        }
        else{
            nameTv.setText("등록된 기기 이름 : " + name);
            addTv.setText("등록된 기기 주소 : " + add);
            explainTv.setText("1. 블루투스 버튼을 클릭하여 기기와 연결합니다. \n" +
                    "2. 몸무게 측정후 블루투스를 다시 연결상태로 변경합니다. \n");
        }




        //        checkBt = findViewById(R.id.check_btn);
//        checkBt.setOnClickListener(new View.OnClickListener() {
//            @Override
//            public void onClick(View v) {
//                if(smartPT.getScaleData() == null){
//                    showToast("몸무게를 측정해주세요.");
//                }
//                else{
//                    Intent intent = new Intent(context, MiScaleActivity.class);
//                    intent.addFlags(Intent.FLAG_ACTIVITY_NEW_TASK);
//                    context.startActivity(intent);
//                }
//            }
//        });

    }

    private void showToast(String msg) {
        Toast.makeText(this, msg, Toast.LENGTH_SHORT).show();
    }

    private void invokeConnectToBluetoothDevice() {
//
//        if (smartPT.getSelectedScaleUserId() == -1) {
////            showNoSelectedUserDialog();
//            Log.d("SmartPT", "NO User");
//            return;
//        }


        smartPT.setDevice(PreferenceManager.getDeviceName(context), PreferenceManager.getDeviceAddress(context));
        Log.d("SmartPT", smartPT.getDeviceName()+smartPT.getDeviceAddress());
        String deviceName = smartPT.getDeviceName();
        String hwAddress = smartPT.getDeviceAddress();
        Log.d("SmartPT", "dd");

        if (!BluetoothAdapter.checkBluetoothAddress(hwAddress)) {
            Toast.makeText(getApplicationContext(), "bluetooth_no_device_set", Toast.LENGTH_SHORT).show();
            return;
        }

        BluetoothManager bluetoothManager = (BluetoothManager) getSystemService(BLUETOOTH_SERVICE);
        if (!bluetoothManager.getAdapter().isEnabled()) {
//            bltIv.setImageResource(R.drawable.ic_bl_disabled);
            bltIv.setImageResource(R.drawable.ic_bl_disabled);
            Intent enableBtIntent = new Intent(BluetoothAdapter.ACTION_REQUEST_ENABLE);
            startActivityForResult(enableBtIntent, ENABLE_BLUETOOTH_REQUEST);
            return;
        }

        Toast.makeText(getApplicationContext(), "블루투스 연결을 시도합니다: " + " " + deviceName, Toast.LENGTH_SHORT).show();

//        bltIv.setImageResource(R.drawable.ic_bt_searching);

        if (!smartPT.connectToBluetoothDevice(deviceName, hwAddress, callbackBtHandler)) {
            Toast.makeText(getApplicationContext(), deviceName + " " + "label_bt_device_no_support", Toast.LENGTH_SHORT).show();
        }
    }

    private final Handler callbackBtHandler = new Handler() {
        @Override
        public void handleMessage(Message msg) {

            BluetoothCommunication.BT_STATUS btStatus = BluetoothCommunication.BT_STATUS.values()[msg.what];

            switch (btStatus) {
                case RETRIEVE_SCALE_DATA:
                    SmartPT smartPT = SmartPT.getInstance();
//
//                    if (prefs.getBoolean("mergeWithLastMeasurement", true)) {
//                        if (!openScale.isScaleMeasurementListEmpty()) {
//                            ScaleMeasurement lastMeasurement = openScale.getLastScaleMeasurement();
//                            scaleBtData.merge(lastMeasurement);
//                        }
//                    }

//                    openScale.addScaleMeasurement(scaleBtData, true);
                    break;
                case INIT_PROCESS:
//                    setBluetoothStatusIcon(R.drawable.ic_bluetooth_connection_success);
                    //
                    // Toast.makeText(getApplicationContext(), "info_bluetooth_init", Toast.LENGTH_SHORT).show();
                    Toast.makeText(getApplicationContext(), "블루투스를 시작합니다.", Toast.LENGTH_SHORT).show();
                    Timber.d("Bluetooth initializing");
                    break;
                case CONNECTION_LOST:
//                    setBluetoothStatusIcon(R.drawable.ic_bluetooth_connection_lost);
                    //Toast.makeText(getApplicationContext(), "info_bluetooth_connection_lost", Toast.LENGTH_SHORT).show();
                    Toast.makeText(getApplicationContext(), "블루투스 연결이 종료되었습니다.", Toast.LENGTH_SHORT).show();
                    Timber.d("Bluetooth connection lost");
                    break;
                case NO_DEVICE_FOUND:
//                    setBluetoothStatusIcon(R.drawable.ic_bluetooth_connection_lost);
                   // Toast.makeText(getApplicationContext(), "info_bluetooth_no_device", Toast.LENGTH_SHORT).show();
                    Toast.makeText(getApplicationContext(), "연결된 장치가 없습니다.", Toast.LENGTH_SHORT).show();
                    Timber.e("No Bluetooth device found");
                    break;
                case CONNECTION_RETRYING:
//                    setBluetoothStatusIcon(R.drawable.ic_bluetooth_searching);
                    Toast.makeText(getApplicationContext(), "info_bluetooth_no_device_retrying", Toast.LENGTH_SHORT).show();
                    Timber.e("No Bluetooth device found retrying");
                    break;
                case CONNECTION_ESTABLISHED:
                    bltIv.setImageResource(R.drawable.ic_bt_connected);
                    // Toast.makeText(getApplicationContext(), "info_bluetooth_connection_successful", Toast.LENGTH_SHORT).show();
                    Toast.makeText(getApplicationContext(), "블루투스 연결이 완료되었습니다.", Toast.LENGTH_SHORT).show();
                    Timber.d("Bluetooth connection successful established");
                    break;
                case CONNECTION_DISCONNECT:
//                    setBluetoothStatusIcon(R.drawable.ic_bluetooth_connection_lost);
                    //Toast.makeText(getApplicationContext(), "info_bluetooth_connection_disconnected", Toast.LENGTH_SHORT).show();
                    Toast.makeText(getApplicationContext(), "블루투스 연결이 종료되었습니다.", Toast.LENGTH_SHORT).show();
                    Timber.d("Bluetooth connection successful disconnected");
                    break;
                case UNEXPECTED_ERROR:
//                    setBluetoothStatusIcon(R.drawable.ic_bluetooth_connection_lost);
                    //Toast.makeText(getApplicationContext(), "info_bluetooth_connection_error" + ": " + msg.obj, Toast.LENGTH_SHORT).show();
                    Toast.makeText(getApplicationContext(), "블루투스 연결에 오류가 있습니다." + ": " + msg.obj, Toast.LENGTH_SHORT).show();
                    Timber.e("Bluetooth unexpected error: %s", msg.obj);
                    break;
                case SCALE_MESSAGE:
                    try {
                        String toastMessage = String.format(getResources().getString(msg.arg1), msg.obj);
                        Toast.makeText(getApplicationContext(), toastMessage, Toast.LENGTH_LONG).show();
                        Timber.d("Bluetooth scale message: " + toastMessage);
                    } catch (Exception ex) {
                        Timber.e("Bluetooth scale message error: " + ex);
                    }
                    break;
            }
        }
    };

    @Override
    public void onActivityResult(int requestCode, int resultCode, Intent data) {
        super.onActivityResult(requestCode, resultCode, data);

        if (requestCode == ENABLE_BLUETOOTH_REQUEST) {
            if (resultCode == RESULT_OK) {
                invokeConnectToBluetoothDevice();
                //Toast.makeText(this, "Bluetooth " + "_is_enable", Toast.LENGTH_SHORT).show();
            } else {
                //Toast.makeText(this, "Bluetooth " + "_is_not_enable", Toast.LENGTH_SHORT).show();
            }
            return;
        }

        if (resultCode != RESULT_OK || data == null) {
            return;
        }
    }




}