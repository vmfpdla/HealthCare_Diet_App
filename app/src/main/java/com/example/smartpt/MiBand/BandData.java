package com.example.smartpt.MiBand;

import android.app.Application;

import androidx.annotation.NonNull;

import java.util.Arrays;

public class BandData extends Application {
    public float[] calories;
    public float[] distances;
    public int[] minutes;

    public BandData(){
        calories = new float[4];
        distances = new float[4];
        minutes = new int[4];
        for(int i=0;i<4;i++)
            calories[i] = distances[i] = minutes[i] = 0;
    }

    @NonNull
    @Override
    public String toString() {
        return "Calorie: "+ Arrays.toString(calories) +" Distance: "+ Arrays.toString(distances) +" Minutes: "+Arrays.toString(minutes);
    }

}
