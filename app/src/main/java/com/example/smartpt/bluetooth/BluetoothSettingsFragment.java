package com.example.smartpt.bluetooth;

import android.app.Activity;
import android.bluetooth.BluetoothDevice;
import android.bluetooth.le.ScanResult;
import android.content.Context;
import android.content.Intent;
import android.content.pm.PackageManager;
import android.graphics.Color;
import android.os.Bundle;
import android.os.Handler;
import android.os.Looper;
import android.text.SpannableStringBuilder;
import android.text.Spanned;
import android.text.style.ForegroundColorSpan;
import android.text.style.RelativeSizeSpan;
import android.util.Log;
import android.view.Gravity;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.ImageView;
import android.widget.LinearLayout;
import android.widget.ProgressBar;
import android.widget.TextView;
import android.widget.Toast;

import androidx.annotation.NonNull;
import androidx.annotation.Nullable;
import androidx.fragment.app.Fragment;
import androidx.fragment.app.FragmentManager;

import com.example.smartpt.PreferenceManager;
import com.example.smartpt.R;
import com.example.smartpt.SmartPT;
import com.welie.blessed.BluetoothCentral;
import com.welie.blessed.BluetoothCentralCallback;
import com.welie.blessed.BluetoothPeripheral;

import java.util.HashMap;
import java.util.Map;

import timber.log.Timber;

public class BluetoothSettingsFragment extends Fragment {
    public static final String PREFERENCE_KEY_BLUETOOTH_DEVICE_NAME = "btDeviceName";
    public static final String PREFERENCE_KEY_BLUETOOTH_HW_ADDRESS = "btHwAddress";

    private Map<String, BluetoothDevice> foundDevices = new HashMap<>();

    private LinearLayout deviceListView;
    private TextView txtSearching;
    private ProgressBar progressBar;
    private Handler progressHandler;
    private BluetoothCentral central;
    private Context mContext;

    @Nullable
    @Override
    public View onCreateView(@NonNull LayoutInflater inflater, @Nullable ViewGroup container, @Nullable Bundle savedInstanceState) {
        View root = inflater.inflate(R.layout.fragment_bluetooth_settings, container, false);
        setHasOptionsMenu(true);

        deviceListView = root.findViewById(R.id.deviceListView);
        txtSearching = root.findViewById(R.id.txtSearching);
        progressBar = root.findViewById(R.id.progressBar);

        return root;
    }

    @Override
    public void onPause() {
        stopBluetoothDiscovery();
        super.onPause();
    }

    @Override
    public void onResume() {
        if (PermissionHelper.requestBluetoothPermission(this)) {
            if (PermissionHelper.requestLocationServicePermission(this)) {
                startBluetoothDiscovery();
            }
        }
        super.onResume();
    }

    private static final String formatDeviceName(String name, String address) {
        if (name.isEmpty() || address.isEmpty()) {
            return "-";
        }
        return String.format("%s [%s]", name, address);
    }

    private static final String formatDeviceName(BluetoothDevice device) {
        return formatDeviceName(device.getName(), device.getAddress());
    }

    private final BluetoothCentralCallback bluetoothCentralCallback = new BluetoothCentralCallback() {
        @Override
        public void onDiscoveredPeripheral(BluetoothPeripheral peripheral, ScanResult scanResult) {
            onDeviceFound(scanResult);
        }
    };

    private void startBluetoothDiscovery() {
        deviceListView.removeAllViews();
        foundDevices.clear();

        central = new BluetoothCentral(mContext, bluetoothCentralCallback, new Handler(Looper.getMainLooper()));
        central.scanForPeripherals();

        txtSearching.setVisibility(View.VISIBLE);
        txtSearching.setText("블루투스 검색중");
        progressBar.setVisibility(View.VISIBLE);

        progressHandler = new Handler();

        // Don't let the BLE discovery run forever
        progressHandler.postDelayed(new Runnable() {
            @Override
            public void run() {
                stopBluetoothDiscovery();

                txtSearching.setText("블루투스 검색 완료");
                progressBar.setVisibility(View.GONE);

                BluetoothDeviceView notSupported = new BluetoothDeviceView(mContext);
                notSupported.setSummaryText("지원되는 기기가 없습니다.");
                notSupported.setEnabled(false);
                deviceListView.addView(notSupported);
            }
        }, 20 * 1000);
    }

    private void stopBluetoothDiscovery() {
        if (progressHandler != null) {
            progressHandler.removeCallbacksAndMessages(null);
            progressHandler = null;
        }

        if (central != null) {
            central.stopScan();
        }
    }

    private void onDeviceFound(final ScanResult bleScanResult) {
        BluetoothDevice device = bleScanResult.getDevice();

        if (device.getName() == null || foundDevices.containsKey(device.getAddress())) {
            return;
        }

        BluetoothDeviceView deviceView = new BluetoothDeviceView(mContext);
        deviceView.setDeviceName(formatDeviceName(bleScanResult.getDevice()));

        BluetoothCommunication btDevice = BluetoothFactory.createDeviceDriver(mContext, device.getName());
        if (btDevice != null) {
            Timber.d("Found supported device %s (driver: %s)",
                    formatDeviceName(device), btDevice.driverName());
            deviceView.setDeviceAddress(device.getAddress());
            deviceView.setSummaryText(btDevice.driverName());
            deviceView.setEnabled(true);
        }
        else {
            Timber.d("Found unsupported device %s",
                    formatDeviceName(device));
            deviceView.setSummaryText("지원되지 않는 기기");
            deviceView.setEnabled(false);

        }

        foundDevices.put(device.getAddress(), btDevice != null ? device : null);
        deviceListView.addView(deviceView);
    }

    private class BluetoothDeviceView extends LinearLayout implements View.OnClickListener {

        private TextView deviceName;
        private ImageView deviceIcon;
        private String deviceAddress;

        public BluetoothDeviceView(Context context) {
            super(context);

            LayoutParams layoutParams = new LayoutParams(
                    LayoutParams.MATCH_PARENT, LayoutParams.WRAP_CONTENT);

            layoutParams.setMargins(0, 20, 0, 20);
            setLayoutParams(layoutParams);

            deviceName = new TextView(context);
            deviceName.setLines(2);
            deviceIcon = new ImageView(context);;

            LayoutParams centerLayoutParams = new LayoutParams(
                    LayoutParams.WRAP_CONTENT, LayoutParams.MATCH_PARENT);
            layoutParams.gravity= Gravity.CENTER;

            deviceIcon.setLayoutParams(centerLayoutParams);
            deviceName.setLayoutParams(centerLayoutParams);

            deviceName.setOnClickListener(this);
            deviceIcon.setOnClickListener(this);
            setOnClickListener(this);

            addView(deviceIcon);
            addView(deviceName);
        }

        public void setDeviceAddress(String address) {
            deviceAddress = address;
        }

        public String getDeviceAddress() {
            return deviceAddress;
        }

        public void setDeviceName(String name) {
            deviceName.setText(name);
        }

        public void setSummaryText(String text) {
            SpannableStringBuilder stringBuilder = new SpannableStringBuilder(new String());

            stringBuilder.append(deviceName.getText());
            stringBuilder.append("\n");

            int deviceNameLength = deviceName.getText().length();

            stringBuilder.append(text);
            stringBuilder.setSpan(new ForegroundColorSpan(Color.GRAY), deviceNameLength, deviceNameLength + text.length()+1,
                    Spanned.SPAN_INCLUSIVE_INCLUSIVE);
            stringBuilder.setSpan(new RelativeSizeSpan(0.8f), deviceNameLength, deviceNameLength + text.length()+1,
                    Spanned.SPAN_INCLUSIVE_INCLUSIVE);

            deviceName.setText(stringBuilder);
        }

        @Override
        public void setOnClickListener(OnClickListener listener) {
            super.setOnClickListener(listener);
            deviceName.setOnClickListener(listener);
            deviceIcon.setOnClickListener(listener);
        }

        @Override
        public void setEnabled(boolean status) {
            super.setEnabled(status);
            deviceName.setEnabled(status);
            deviceIcon.setEnabled(status);
        }

        @Override
        public void onClick(View view) {
            BluetoothDevice device = foundDevices.get(getDeviceAddress());

            SmartPT.getInstance().setDevice(device.getName(), device.getAddress());
            Log.d("SmartPT", device.getName() + device.getAddress());
            PreferenceManager.setDeviceName(mContext, device.getName());
            PreferenceManager.setDeviceAddress(mContext, device.getAddress());
            SmartPT.getInstance().setUserId(1);
            Log.d("SmartPT" , "Saved Bluetooth device " + device.getName() + " with address " + device.getAddress());
            Timber.d("Saved Bluetooth device " + device.getName() + " with address " + device.getAddress());

            stopBluetoothDiscovery();
            getActivity().onBackPressed();
        }
    }

    @Override
    public void onActivityResult(int requestCode, int resultCode, Intent data) {
        if (requestCode == PermissionHelper.ENABLE_BLUETOOTH_REQUEST) {
            if (resultCode == Activity.RESULT_OK) {
                if (PermissionHelper.requestBluetoothPermission(this)) {
                    startBluetoothDiscovery();
                }
            }
        }

        super.onActivityResult(requestCode, resultCode, data);
    }

    @Override
    public void onAttach(@NonNull Context context) {
        super.onAttach(context);
        mContext = context;
    }
    @Override
    public void onRequestPermissionsResult(int requestCode, String permissions[], int[] grantResults) {
        switch (requestCode) {
            case PermissionHelper.PERMISSIONS_REQUEST_ACCESS_FINE_LOCATION: {
                if (grantResults.length > 0 && grantResults[0] == PackageManager.PERMISSION_GRANTED) {
                    if (PermissionHelper.requestLocationServicePermission(this)) {
                        startBluetoothDiscovery();
                    }
                } else {
                    Toast.makeText(mContext, "허가가 필요합니다.", Toast.LENGTH_SHORT).show();
                }
                break;
            }
        }
    }
}
