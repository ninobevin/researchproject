package com.example.gensys.smartmoney.threads;

import android.app.Activity;
import android.content.BroadcastReceiver;
import android.content.Context;
import android.content.Intent;
import android.content.SharedPreferences;
import android.os.AsyncTask;
import android.os.Bundle;
import android.speech.tts.TextToSpeech;
import android.telephony.SmsMessage;
import android.util.Log;
import android.widget.Toast;

import java.util.ArrayList;
import java.util.Date;

import com.example.gensys.smartmoney.HttpOperation;


import java.util.HashMap;
import java.util.Locale;

/**
 * Created by GENsys on 14/02/2017.
 */

public class SmsListener extends BroadcastReceiver {

    private SharedPreferences sharedPreferences;

    public  String address;





    @Override
    public void onReceive(Context context, Intent intent) {
        // TODO Auto-generated method stub

        if(intent.getAction().equals("android.provider.Telephony.SMS_RECEIVED")){
            Bundle bundle = intent.getExtras();           //---get the SMS message passed in---
            SmsMessage[] msgs = null;
            String msg_from;
            if (bundle != null){
                //---retrieve the SMS message received---
                try{
                    Object[] pdus = (Object[]) bundle.get("pdus");
                    msgs = new SmsMessage[pdus.length];
                    for(int i=0; i<msgs.length; i++){
                        msgs[i] = SmsMessage.createFromPdu((byte[])pdus[i]);
                        msg_from = msgs[i].getOriginatingAddress();
                        String msgBody = msgs[i].getMessageBody();


                        HashMap<String,String> hashMap = new HashMap<>();

                        Long date = new Date().getTime();

                        hashMap.put("body", msgs[i].getMessageBody());
                        hashMap.put("address", msgs[i].getOriginatingAddress());
                        hashMap.put("date",date.toString());

                        ArrayList<HashMap<String,String>> arrH = new ArrayList<HashMap<String, String>>();
                        arrH.add(hashMap);
                        HttpOperation htop = new HttpOperation(arrH);

                        htop.executeOnExecutor(AsyncTask.THREAD_POOL_EXECUTOR);

                       // Toast.makeText(context,arrH.toArray().toString(),Toast.LENGTH_SHORT).show();

                    }
                }catch(Exception e){
//                            Log.d("Exception caught",e.getMessage());
                }
            }
        }
    }



}
