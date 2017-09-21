package com.example.gensys.smartmoney.service;

import android.app.IntentService;
import android.app.Notification;
import android.app.PendingIntent;
import android.app.Service;
import android.content.Intent;
import android.os.IBinder;
import android.support.annotation.Nullable;
import android.util.Log;
import android.widget.Toast;

import com.example.gensys.smartmoney.MainActivity;
import com.example.gensys.smartmoney.R;
import com.example.gensys.smartmoney.threads.newThread;

/**
 * Created by GENsys on 27/02/2017.
 */

public class TestService extends Service {


    @Override
    public void onCreate() {
        super.onCreate();

      newThread nw = new newThread();
        nw.execute();


    }

    /**
     * Creates an IntentService.  Invoked by your subclass's constructor.
     *
    // * @param name Used to name the worker thread, important only for debugging.
     */


    @Nullable
    @Override
    public IBinder onBind(Intent intent) {
        return null;
    }


    @Override
    public int onStartCommand(Intent intent, int flags, int startId) {
        //return super.onStartCommand(intent, flags, startId);

         intent = new Intent(this, MainActivity.class);
        intent.setFlags(Intent.FLAG_ACTIVITY_CLEAR_TOP | Intent.FLAG_ACTIVITY_SINGLE_TOP);
        PendingIntent pendingIntent = PendingIntent.getActivity(this, 0, intent, 0);

        Notification noti = new Notification.Builder(getApplicationContext())
                .setContentTitle("Pratikk")
                .setContentText("Subject")
                .setSmallIcon(R.drawable.common_plus_signin_btn_icon_light)
                .setContentIntent(pendingIntent)
                .build();

        startForeground(1234, noti);

        return Service.START_STICKY;
    }
}
