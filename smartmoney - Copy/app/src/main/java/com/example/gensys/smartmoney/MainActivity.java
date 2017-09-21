package com.example.gensys.smartmoney;

import android.Manifest;

import android.content.ComponentName;
import android.content.Context;
import android.content.Intent;

import android.content.pm.PackageManager;
import android.database.Cursor;
import android.net.ConnectivityManager;
import android.net.NetworkInfo;
import android.net.Uri;
import android.net.wifi.WifiInfo;
import android.net.wifi.WifiManager;
import android.os.Build;

import android.os.Process;

import android.speech.tts.TextToSpeech;
import android.support.annotation.RequiresApi;
import android.support.v7.app.AppCompatActivity;
import android.os.Bundle;

import android.telephony.SmsManager;
import android.text.format.Formatter;
import android.util.Log;
import android.view.Menu;
import android.view.MenuItem;
import android.view.View;

import android.widget.Button;
import android.widget.EditText;
import android.widget.Switch;
import android.widget.Toast;


import com.example.gensys.smartmoney.service.SendService;
import com.example.gensys.smartmoney.service.TestService;
import com.example.gensys.smartmoney.threads.SmsListener;
import com.example.gensys.smartmoney.threads.SmsServiceMonitor;
import com.example.gensys.smartmoney.threads.globalAccess;
import com.google.android.gms.appindexing.Action;
import com.google.android.gms.appindexing.AppIndex;
import com.google.android.gms.appindexing.Thing;
import com.google.android.gms.common.api.GoogleApiClient;

import org.w3c.dom.Text;

import java.util.ArrayList;
import java.util.HashMap;
import java.util.Locale;


public class MainActivity extends AppCompatActivity   {

    int limit = 0;
    String addressSelect = "";
    private String computerName;

    String valIp;
    String valAddress;
    String valLimit;

    globalAccess GO = new globalAccess();
    Switch sw;

    private TextToSpeech tts;
    private static final int PERMS_REQ_CODE = 123;



    Button Button1;
    /**
     * ATTENTION: This was auto-generated to implement the App Indexing API.
     * See https://g.co/AppIndexing/AndroidStudio for more information.
     */
    private GoogleApiClient client;

    private Intent recieveIntent;
    private Intent sendIntent;

    @RequiresApi(api = Build.VERSION_CODES.M)
    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_main);

        if (!hasPermission()) {

            requestPerm();
        }




        // ATTENTION: This was auto-generated to implement the App Indexing API.
        // See https://g.co/AppIndexing/AndroidStudio for more information.
        client = new GoogleApiClient.Builder(this).addApi(AppIndex.API).build();

        setTitle("MERGE SMS");

        sw = (Switch) findViewById(R.id.switch1);

        /*
        View backgroundimage = findViewById(R.id.activity_main);
        Drawable background = backgroundimage.getBackground();
        background.setAlpha(80);
*/
        tts = new TextToSpeech(this, new TextToSpeech.OnInitListener() {
            @Override
            public void onInit(int status) {
                if (status == TextToSpeech.SUCCESS) {
                    int result = tts.setLanguage(Locale.US);
                    if (result == TextToSpeech.LANG_MISSING_DATA || result == TextToSpeech.LANG_NOT_SUPPORTED) {
                        Log.e("TTS", "This Language is not supported");
                    }


                } else {
                    Log.e("TTS", "Initilization Failed!");
                }
            }
        });



        setInit();
        GO.setIp(valIp);
        GO.setLimit(valLimit);
        GO.setAddress(valAddress);


        recieveIntent = new Intent(this,SmsServiceMonitor.class);
        sendIntent = new Intent(this,SendService.class);



    }



    private void setInit(){
        valAddress = ((EditText) findViewById(R.id.address)).getText().toString();

        valIp = ((EditText) findViewById(R.id.ipseries)).getText().toString();
        valLimit = ((EditText) findViewById(R.id.limitrow)).getText().toString();

        Log.i("LIMIT",valLimit);
    }

    @Override
    public boolean onCreateOptionsMenu(Menu menu) {
        // Inflate the menu; this adds items to the action bar if it is present.
        getMenuInflater().inflate(R.menu.main_menu, menu);//Menu Resource, Menu
        return true;
    }


    private void requestPerm() {


        String[] permissions = new String[]{Manifest.permission.INTERNET, Manifest.permission.ACCESS_WIFI_STATE,
                Manifest.permission.ACCESS_NETWORK_STATE,
                Manifest.permission.RECEIVE_SMS,
                Manifest.permission.SEND_SMS,
                Manifest.permission.READ_SMS,
                Manifest.permission.READ_SYNC_STATS,
                Manifest.permission.READ_PHONE_STATE};

        if (Build.VERSION.SDK_INT >= Build.VERSION_CODES.M) {

            requestPermissions(permissions, PERMS_REQ_CODE);
        }

    }

    private boolean hasPermission() {

        int res = 0;


        String[] permissions = new String[]{Manifest.permission.INTERNET, Manifest.permission.ACCESS_WIFI_STATE,
                Manifest.permission.ACCESS_NETWORK_STATE,
                Manifest.permission.SEND_SMS,
                Manifest.permission.RECEIVE_SMS,
                Manifest.permission.READ_SMS,
                Manifest.permission.READ_SYNC_STATS,
                Manifest.permission.READ_PHONE_STATE};

        for (String perms : permissions) {

            res = checkCallingOrSelfPermission(perms);

            if (!(res == PackageManager.PERMISSION_GRANTED)) {
                return false;
            }

        }

        return true;
    }




    /**
     * ATTENTION: This was auto-generated to implement the App Indexing API.
     * See https://g.co/AppIndexing/AndroidStudio for more information.
     */
    public Action getIndexApiAction() {
        Thing object = new Thing.Builder()
                .setName("Main Page") // TODO: Define a title for the content shown.
                // TODO: Make sure this auto-generated URL is correct.
                .setUrl(Uri.parse("http://[ENTER-YOUR-URL-HERE]"))
                .build();
        return new Action.Builder(Action.TYPE_VIEW)
                .setObject(object)
                .setActionStatus(Action.STATUS_TYPE_COMPLETED)
                .build();
    }

    @Override
    public void onStart() {
        super.onStart();



        // ATTENTION: This was auto-generated to implement the App Indexing API.
        // See https://g.co/AppIndexing/AndroidStudio for more information.
        client.connect();
        AppIndex.AppIndexApi.start(client, getIndexApiAction());
    }

    @Override
    public void onStop() {
        super.onStop();

        // ATTENTION: This was auto-generated to implement the App Indexing API.
        // See https://g.co/AppIndexing/AndroidStudio for more information.
        AppIndex.AppIndexApi.end(client, getIndexApiAction());
        client.disconnect();
    }




    public void activate(View view) {


        setInit();
        GO.setIp(valIp);
        GO.setLimit(valLimit);
        GO.setAddress(valAddress);




        //sendIntent = new Intent(this,SendService.class);




            if(!sw.isChecked()) {


              stopService(sendIntent);
             // stopService(recieveIntent);
                return;
            }

        speak("Auto Sync activated, ip address is " + GO.getIp().toString());
        Toast.makeText(getBaseContext(),"Auto Sync activated",Toast.LENGTH_SHORT).show();




       // startService(recieveIntent);


        startService(sendIntent);




        // Add extras to the bundle

        // Start the service

     //  startService(sendIntent);



    }
    private void speak(String text){
        if (Build.VERSION.SDK_INT >= Build.VERSION_CODES.LOLLIPOP) {
            tts.speak(text, TextToSpeech.QUEUE_FLUSH, null, null);
        }else{
            tts.speak(text, TextToSpeech.QUEUE_FLUSH, null);
        }
    }




    public void syncManual(View view) {



        if(SmsServiceMonitor.isRunning || SendService.isRunning){

           //stopService(recieveIntent);
           stopService(sendIntent);
        }



        setInit();
        GO.setIp(valIp);
        GO.setLimit(valLimit);
        GO.setAddress(valAddress);

      InboxMsg inMsg = new InboxMsg();




        inMsg.initClass(GO.getIp());

        Cursor cr = inMsg.getByIdentification(this);


      //  Log.i("tags",valIp+">>"+valLimit+">>>" + valAddress + " count: " + String.valueOf(cr.getCount()));
        int body = cr.getColumnIndex("body");
        int address = cr.getColumnIndex("address");
        int date = cr.getColumnIndex("date");
        
        ArrayList<HashMap<String,String>> arrhs = new ArrayList<HashMap<String,String>>();

       int x =0;
       int lim = Integer.valueOf(GO.getLimit());
        while(cr.moveToNext()) {

            if(x >= lim)
                break;

            HashMap<String, String> hsmap = new HashMap<>();


            hsmap.put("body", cr.getString(body));
            hsmap.put("address", cr.getString(address));
            hsmap.put("date", cr.getString(date));

            arrhs.add(hsmap);
            //Log.i("msg",String.valueOf(x));
            x++;
        }

        HttpOperationPg rg = new HttpOperationPg(this,arrhs);

        rg.execute();



    }

    public void test3(MenuItem item) {


    }

}
