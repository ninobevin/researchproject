package com.example.gensys.smartmoney;

import android.app.Activity;
import android.content.Context;
import android.os.AsyncTask;
import android.telephony.SmsManager;
import android.util.Log;

import com.example.gensys.smartmoney.threads.globalAccess;

import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import java.lang.ref.WeakReference;
import java.util.ArrayList;
import java.util.HashMap;

/**
 * Created by GENsys on 13/02/2017.
 */

public class GetMsgForward extends AsyncTask {


    Context cnt;
    WeakReference<Activity> mWeakActivity;

    ArrayList<HashMap<String,String>> hsmap;

    String _address;

    SmsManager smsManager = SmsManager.getDefault();

    public GetMsgForward() {







    }

    @Override
    protected Object doInBackground(Object[] params) {



        RegisterUserClass ruc = new RegisterUserClass();


        globalAccess GO = new globalAccess();


        while(true){
            String result = ruc.getData("http://"+GO.getIp()+"/mergeandroid/getmsgs.php");



            try {

                StringBuffer strBuff = new StringBuffer();

                strBuff.append(result);

                //JSONObject JO = new JSONObject(result);

                JSONArray jObj = new JSONArray(result);
              //  JSONArray Jrr = JO.getJSONArray(0);



                for(int i =0;i < jObj.length();i++) {

                    JSONObject jobj2 =new JSONObject(jObj.get(i).toString());

                    String longMessage = jobj2.get("body").toString();
                    String contact = jobj2.get("recipient").toString();


                    ArrayList<String> parts = smsManager.divideMessage(longMessage);
                    smsManager.sendMultipartTextMessage(contact, null, parts, null, null);

                    Log.i("SENT",jobj2.get("body").toString());

                }


            } catch (JSONException e) {
                Log.i("errorjson",e.toString());
            }




            try {
                Thread.sleep(1000);
            } catch (InterruptedException e) {
                e.printStackTrace();
            }
        }






    }

    @Override
    protected void onProgressUpdate(Object[] values) {
        super.onProgressUpdate(values);

    }

    @Override
    protected void onPostExecute(Object o) {
        //super.onPostExecute(o);

        Log.i("mysl","inserted");
    }
}