/* Copyright (C) 2018 Erik Johansson <erik@ejohansson.se>
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

import java.util.Locale;

public class BluetoothFactory {

    public static BluetoothCommunication createDeviceDriver(Context context, String deviceName) {
        final String name = deviceName.toLowerCase(Locale.US);

        if (name.equals("MI_SCALE".toLowerCase(Locale.US)) || name.equals("MI SCALE2".toLowerCase(Locale.US))) {
            return new BluetoothMiScale(context);
        }
        if (name.equals("MIBCS".toLowerCase(Locale.US)) || name.equals("MIBFS".toLowerCase(Locale.US))) {
            return new BluetoothMiScale2(context);
        }

        return null;
    }
}
