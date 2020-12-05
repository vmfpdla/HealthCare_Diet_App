/* Copyright (C) 2014  olie.xdev <olie.xdev@googlemail.com>
*
*    This program is free software: you can redistribute it and/or modify
*    it under the terms of the GNU General Public License as published by
*    the Free Software Foundation, either version 3 of the License, or
*    (at your option) any later version.
*
*    This program is distributed in the hope that it will be useful,
*    but WITHOUT ANY WARRANTY; without even the implied warranty of
*    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
*    GNU General Public License for more details.
*
*    You should have received a copy of the GNU General Public License
*    along with this program.  If not, see <http://www.gnu.org/licenses/>
*/

package com.example.smartpt.bluetooth;

import android.content.Context;
import android.content.Intent;
import android.content.SharedPreferences;
import android.preference.PreferenceManager;
import android.util.Log;

import androidx.core.content.ContextCompat;

import com.example.smartpt.MiScale.MiScaleActivity;
import com.example.smartpt.MiScale.ScaleData;
import com.example.smartpt.SmartPT;
import com.example.smartpt.bluetooth.lib.MiScaleLib;

import java.text.ParseException;
import java.text.SimpleDateFormat;
import java.util.Arrays;
import java.util.Calendar;
import java.util.Date;
import java.util.Random;
import java.util.UUID;

import timber.log.Timber;

public class BluetoothMiScale2 extends BluetoothCommunication {
    private final UUID WEIGHT_MEASUREMENT_HISTORY_CHARACTERISTIC = UUID.fromString("00002a2f-0000-3512-2118-0009af100700");

    private final UUID WEIGHT_CUSTOM_SERVICE = UUID.fromString("00001530-0000-3512-2118-0009af100700");
    private final UUID WEIGHT_CUSTOM_CONFIG = UUID.fromString("00001542-0000-3512-2118-0009af100700");

    public BluetoothMiScale2(Context context) {
        super(context);
    }

    @Override
    public String driverName() {
        return "Xiaomi Mi Scale v2";
    }

    @Override
    public void onBluetoothNotify(UUID characteristic, byte[] value) {
        final byte[] data = value;

        if (data != null && data.length > 0) {
            Timber.d("DataChange hex data: %s", byteInHex(data));

            // Stop command from mi scale received
            if (data[0] == 0x03) {
                Timber.d("Scale stop byte received");
                // send stop command to mi scale
                writeBytes(BluetoothGattUuid.SERVICE_BODY_COMPOSITION, WEIGHT_MEASUREMENT_HISTORY_CHARACTERISTIC, new byte[]{0x03});
                // acknowledge that you received the last history data
                int uniqueNumber = getUniqueNumber();

                byte[] userIdentifier = new byte[]{(byte)0x04, (byte)0xFF, (byte)0xFF, (byte) ((uniqueNumber & 0xFF00) >> 8), (byte) ((uniqueNumber & 0xFF) >> 0)};
                writeBytes(BluetoothGattUuid.SERVICE_BODY_COMPOSITION, WEIGHT_MEASUREMENT_HISTORY_CHARACTERISTIC, userIdentifier);

                resumeMachineState();
            }

            if (data.length == 26) {
                final byte[] firstWeight = Arrays.copyOfRange(data, 0, 10);
                final byte[] secondWeight = Arrays.copyOfRange(data, 10, 20);
                parseBytes(firstWeight);
                parseBytes(secondWeight);
            }

            if (data.length == 13) {
                parseBytes(data);
            }

        }
    }


    @Override
    protected boolean onNextStep(int stepNr) {
        switch (stepNr) {
            case 0:
                // set scale units
//                final ScaleUser selectedUser = OpenScale.getInstance().getSelectedScaleUser();
//                byte[] setUnitCmd = new byte[]{(byte)0x06, (byte)0x04, (byte)0x00, (byte) selectedUser.getScaleUnit().toInt()};
//                writeBytes(WEIGHT_CUSTOM_SERVICE, WEIGHT_CUSTOM_CONFIG, setUnitCmd);
                break;
            case 1:
                // set current time
                Calendar currentDateTime = Calendar.getInstance();
                int year = currentDateTime.get(Calendar.YEAR);
                byte month = (byte)(currentDateTime.get(Calendar.MONTH)+1);
                byte day = (byte)currentDateTime.get(Calendar.DAY_OF_MONTH);
                byte hour = (byte)currentDateTime.get(Calendar.HOUR_OF_DAY);
                byte min = (byte)currentDateTime.get(Calendar.MINUTE);
                byte sec = (byte)currentDateTime.get(Calendar.SECOND);

                byte[] dateTimeByte = {(byte)(year), (byte)(year >> 8), month, day, hour, min, sec, 0x03, 0x00, 0x00};

                writeBytes(BluetoothGattUuid.SERVICE_BODY_COMPOSITION, BluetoothGattUuid.CHARACTERISTIC_CURRENT_TIME, dateTimeByte);
                break;
            case 2:
                // set notification on for weight measurement history
                setNotificationOn(BluetoothGattUuid.SERVICE_BODY_COMPOSITION, WEIGHT_MEASUREMENT_HISTORY_CHARACTERISTIC);
                break;
            case 3:
                // configure scale to get only last measurements
                int uniqueNumber = getUniqueNumber();

                byte[] userIdentifier = new byte[]{(byte)0x01, (byte)0xFF, (byte)0xFF, (byte) ((uniqueNumber & 0xFF00) >> 8), (byte) ((uniqueNumber & 0xFF) >> 0)};
                writeBytes(BluetoothGattUuid.SERVICE_BODY_COMPOSITION, WEIGHT_MEASUREMENT_HISTORY_CHARACTERISTIC, userIdentifier);
                break;
            case 4:
                // invoke receiving history data
                writeBytes(BluetoothGattUuid.SERVICE_BODY_COMPOSITION, WEIGHT_MEASUREMENT_HISTORY_CHARACTERISTIC, new byte[]{0x02});
                stopMachineState();
                break;
            default:
                return false;
        }

        return true;
    }

    private void parseBytes(byte[] data) {
        try {
            final byte ctrlByte0 = data[0];
            final byte ctrlByte1 = data[1];

            final boolean isWeightRemoved = isBitSet(ctrlByte1, 7);
            final boolean isDateInvalid = isBitSet(ctrlByte1, 6);
            final boolean isStabilized = isBitSet(ctrlByte1, 5);
            final boolean isLBSUnit = isBitSet(ctrlByte0, 0);
            final boolean isCattyUnit = isBitSet(ctrlByte1, 6);
            final boolean isImpedance = isBitSet(ctrlByte1, 1);

            Log.d("SmartPT", "-1");
            if (isStabilized && !isWeightRemoved && !isDateInvalid) {

                Log.d("SmartPT", "0");
                ScaleData scaleBtData = new ScaleData();

                final int year = ((data[3] & 0xFF) << 8) | (data[2] & 0xFF);
                final int month = (int) data[4];
                final int day = (int) data[5];
                final int hours = (int) data[6];
                final int min = (int) data[7];
                final int sec = (int) data[8];

                float weight;
                float impedance = 0.0f;

                if (isLBSUnit || isCattyUnit) {
                    weight = (float) (((data[12] & 0xFF) << 8) | (data[11] & 0xFF)) / 100.0f;
                } else {
                    weight = (float) (((data[12] & 0xFF) << 8) | (data[11] & 0xFF)) / 200.0f;
                }

                if (isImpedance) {
                    impedance = ((data[10] & 0xFF) << 8) | (data[9] & 0xFF);
                    Timber.d("impedance value is " + impedance);
                }

                String date_string = year + "/" + month + "/" + day + "/" + hours + "/" + min;
                Date date_time = new SimpleDateFormat("yyyy/MM/dd/HH/mm").parse(date_string);

                // Is the year plausible? Check if the year is in the range of 20 years...
                if (validateDate(date_time, 20)) {
                    SmartPT smartPT = SmartPT.getInstance();

                    scaleBtData.weight = weight;
                    int sex;
                    if(smartPT.getUserSex() == SmartPT.MALE){
                        sex = 1;
                    }else{
                        sex = 0;
                    }

                    if (impedance != 0.0f) {
                        MiScaleLib miScaleLib = new MiScaleLib(sex, smartPT.getUserAge(), smartPT.getUserHeight());

                        float heightM = (float)(smartPT.getUserHeight())/100;
                        float x;
                        x = weight/(heightM*heightM);
                        x = Math.round(x*100);
                        scaleBtData.bmi = x/100;
                        x = miScaleLib.getBodyFat(weight, impedance);
                        x = Math.round(x*100);
                        scaleBtData.fat = x/100;
                        x = miScaleLib.getWater(weight, impedance);
                        x = Math.round(x*100);
                        scaleBtData.water = x/100;
                        x = (100.0f / 100) * miScaleLib.getMuscle(weight, impedance); // convert muscle in kg to percent
                        x = Math.round(x*100);
                        scaleBtData.muscle = x/100;
//                        scaleBtData.bone = (miScaleLib.getBoneMass(weight, impedance));
//                        scaleBtData.visceralFat = (miScaleLib.getVisceralFat(weight));
                        smartPT.setScaleData(scaleBtData);

//
                        Log.d("SmartPT", "1");
                        if(smartPT.getWeightChange()){
                            Intent intent = new Intent(this.context, MiScaleActivity.class);
                            intent.addFlags(Intent.FLAG_ACTIVITY_NEW_TASK);
                            this.context.startActivity(intent);
                            Log.d("SmartPT", "2");
                            smartPT.setWeightChange(false);
                        }
                    } else {
                        Timber.d("Impedance value is zero");
                    }

//                    addScaleMeasurement(scaleBtData);
                } else {
                    Timber.e("Invalid Mi scale weight year %d", year);
                }
            }
        } catch (ParseException e) {
            setBluetoothStatus(BT_STATUS.UNEXPECTED_ERROR, "Error while decoding bluetooth date string (" + e.getMessage() + ")");
        }
    }

    private boolean validateDate(Date weightDate, int range) {

        Calendar currentDatePos = Calendar.getInstance();
        currentDatePos.add(Calendar.YEAR, range);

        Calendar currentDateNeg = Calendar.getInstance();
        currentDateNeg.add(Calendar.YEAR, -range);

        if (weightDate.before(currentDatePos.getTime()) && weightDate.after(currentDateNeg.getTime())) {
            return true;
        }

        return false;
    }

    private int getUniqueNumber() {
        int uniqueNumber;

        SharedPreferences prefs = PreferenceManager.getDefaultSharedPreferences(context);

        uniqueNumber = prefs.getInt("uniqueNumber", 0x00);

        if (uniqueNumber == 0x00) {
            Random r = new Random();
            uniqueNumber = r.nextInt(65535 - 100 + 1) + 100;

            prefs.edit().putInt("uniqueNumber", uniqueNumber).apply();
        }

        int userId = 1;

        return uniqueNumber + userId;
    }
}
