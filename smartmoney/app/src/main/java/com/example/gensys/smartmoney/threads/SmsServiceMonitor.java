package com.example.gensys.smartmoney.threads;


import android.app.Notification;
import android.app.NotificationManager;

import android.app.PendingIntent;
import android.app.Service;

import android.content.Intent;
import android.content.IntentFilter;

import android.content.res.Resources;
import android.os.IBinder;

import android.support.v4.app.NotificationCompat;


import com.example.gensys.smartmoney.MainActivity;
import com.example.gensys.smartmoney.R;

import static android.provider.Telephony.Sms.Intents.WAP_PUSH_RECEIVED_ACTION;
import static android.provider.Telephony.Sms.Intents.getMessagesFromIntent;

/**
 * Created by GENsys on 14/02/2017.
 */

public class SmsServiceMonitor extends Service {

    public static Service activity;

    private static final String SMS_RECEIVE_ACTION = "";

    public static boolean isRunning = false;

    private String address;



    @Override
    public IBinder onBind(Intent intent) {



        return null;
    }

    @Override
    public void onCreate() {
        super.onCreate();




        activity = this;
        isRunning = true;
        SmsListener mSmsReceiver = new SmsListener();


        IntentFilter filter = new IntentFilter();




        filter.setPriority(IntentFilter.SYSTEM_HIGH_PRIORITY);
        filter.addAction(SMS_RECEIVE_ACTION); // SMS
        filter.addAction(WAP_PUSH_RECEIVED_ACTION); // MMS


        this.registerReceiver(mSmsReceiver, filter);





        NotificationCompat.Builder nb = new NotificationCompat.Builder(getBaseContext());
        nb.setSmallIcon(R.drawable.starticon);
        nb.setContentTitle("MERGESMS");

        nb.setContentText("I'll take care of everything - Bevin");


        NotificationManager notificationManager = (NotificationManager) getSystemService(getBaseContext().NOTIFICATION_SERVICE);


        notificationManager.notify(2,nb.build());


    }

    @Override
    public int onStartCommand(Intent intent, int flags, int startId) {
        //return super.onStartCommand(intent, flags, startId);

        intent = new Intent(this, MainActivity.class);
        intent.setFlags(Intent.FLAG_ACTIVITY_CLEAR_TOP | Intent.FLAG_ACTIVITY_SINGLE_TOP);
        intent.setAction(Long.toString(System.currentTimeMillis()));
        PendingIntent pendingIntent = PendingIntent.getActivity(this,5, intent,0);


        Notification noti = new Notification.Builder(getApplicationContext())
                .setContentTitle("Receiving Activated")
                .setContentText("New messages will auto sync")
                .setSmallIcon(R.drawable.starticon)
                .setContentIntent(pendingIntent)
                .build();

        startForeground(333, noti);


        return Service.START_STICKY;

    }

    @Override
    public void onDestroy() {
        super.onDestroy();

        isRunning = false;
    }
}
