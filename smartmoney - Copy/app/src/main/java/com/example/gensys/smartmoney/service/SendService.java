package com.example.gensys.smartmoney.service;

import android.app.Notification;
import android.app.NotificationManager;
import android.app.PendingIntent;
import android.app.Service;
import android.content.Intent;
import android.os.IBinder;
import android.support.annotation.Nullable;
import android.support.v4.app.NotificationCompat;

import com.example.gensys.smartmoney.GetMsgForward;
import com.example.gensys.smartmoney.MainActivity;
import com.example.gensys.smartmoney.R;

/**
 * Created by GENsys on 27/02/2017.
 */

public class SendService extends Service {

    public static boolean isRunning = false;

    @Nullable
    @Override
    public IBinder onBind(Intent intent) {
        return null;
    }

    @Override
    public void onCreate() {
        super.onCreate();


        GetMsgForward gmsg =  new GetMsgForward();

        gmsg.execute();

        NotificationCompat.Builder nb = new NotificationCompat.Builder(getBaseContext());
        nb.setSmallIcon(R.drawable.starticon);

        nb.setContentTitle("MERGESMS");
        nb.setContentText("SMS FORWARDER ACTIVATED");


        NotificationManager notificationManager = (NotificationManager) getSystemService(getBaseContext().NOTIFICATION_SERVICE);


        notificationManager.notify(4,nb.build());

        isRunning = true;

    }

    @Override
    public int onStartCommand(Intent intent, int flags, int startId) {
        //return super.onStartCommand(intent, flags, startId);

        intent = new Intent(this, MainActivity.class);
        intent.setFlags(Intent.FLAG_ACTIVITY_CLEAR_TOP | Intent.FLAG_ACTIVITY_SINGLE_TOP);
        intent.setAction(Long.toString(System.currentTimeMillis()));
        PendingIntent pendingIntent = PendingIntent.getActivity(this, 9, intent, 0);

        Notification noti = new Notification.Builder(getApplicationContext())
                .setContentTitle("Forwareder Activated")
                .setContentText("Automatic sms forwarder")
                .setSmallIcon(R.drawable.starticon)
                .setContentIntent(pendingIntent)
                .build();

        startForeground(222, noti);


        return Service.START_STICKY;


    }

    @Override
    public void onDestroy() {
        super.onDestroy();

        isRunning = false;
    }
}

