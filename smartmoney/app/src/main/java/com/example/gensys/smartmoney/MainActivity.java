package com.example.gensys.smartmoney;

import android.Manifest;

import android.content.ComponentName;
import android.content.ContentValues;
import android.content.Context;
import android.content.Intent;

import android.content.pm.PackageManager;
import android.database.Cursor;
import android.database.sqlite.SQLiteDatabase;
import android.net.ConnectivityManager;
import android.net.NetworkInfo;
import android.net.Uri;
import android.net.wifi.WifiInfo;
import android.net.wifi.WifiManager;
import android.os.Build;

import android.os.Process;


import android.support.annotation.RequiresApi;
import android.support.v7.app.AppCompatActivity;
import android.os.Bundle;

import android.telephony.SmsManager;
import android.text.format.Formatter;
import android.util.Log;
import android.view.Menu;
import android.view.MenuItem;
import android.view.View;

import android.widget.AdapterView;
import android.widget.ArrayAdapter;
import android.widget.Button;
import android.widget.EditText;
import android.widget.Spinner;
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
import java.util.List;
import java.util.Locale;


public class MainActivity extends AppCompatActivity   {

    int limit = 0;
    String addressSelect = "";
    private String computerName;

    String valIp;
    String valAddress;
    String valLimit;
    String valPath;
    String valProf;
    Spinner spProf;

    EditText txtIp;
    EditText txtAddress;
    EditText txtLimit;
    EditText txtPath;
    EditText txtProf;

    Button btnManual;



    DatabaseHelper dbHelp;

    globalAccess GO = new globalAccess();
    Switch sw;
    Switch sw3;
    Switch sw4;


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
        sw3 = (Switch) findViewById(R.id.switch3);
        sw4 = (Switch) findViewById(R.id.switch5);

        btnManual = (Button) findViewById(R.id.btnManual);

        /*
        View backgroundimage = findViewById(R.id.activity_main);
        Drawable background = backgroundimage.getBackground();
        background.setAlpha(80);
*/




        setInit();


        spProf = (Spinner) findViewById(R.id.curProf);
        recieveIntent = new Intent(this,SmsServiceMonitor.class);
        sendIntent = new Intent(this,SendService.class);

        try {
            loadSpinnerDataHama();



        }catch (Exception ed){
            Log.i("logval",ed.toString());
        }

        spProf.setOnItemSelectedListener(new AdapterView.OnItemSelectedListener() {
            @Override
            public void onItemSelected(AdapterView<?> parentView, View selectedItemView, int position, long id) {


                int ids = ((SpinnerObject) spProf.getSelectedItem()).getId();

                ContentValues ct = new ContentValues();

                SQLiteDatabase updb = dbHelp.getWritableDatabase();
                updb.execSQL("update "+dbHelp.TABLE_NAME + " set def = 0");

                updb.execSQL("update "+dbHelp.TABLE_NAME + " set def = 1 where id=" + ids);

                Cursor cr = dbHelp.getReadableDatabase().rawQuery("select * from "+dbHelp.TABLE_NAME+" where def = 1 limit 1",null);

                cr.moveToFirst();

                txtPath.setText(cr.getString(cr.getColumnIndex("path")));
                txtLimit.setText(cr.getString(cr.getColumnIndex("recordlimit")));
                txtIp.setText(cr.getString(cr.getColumnIndex("ip")));
                txtAddress.setText(cr.getString(cr.getColumnIndex("address")));
                txtProf.setText(cr.getString(cr.getColumnIndex("prof")));

                toastMessage(cr.getString(cr.getColumnIndex("prof")) + " is selected");

                GO.setIp(cr.getString(cr.getColumnIndex("ip")));
                GO.setLimit(cr.getString(cr.getColumnIndex("recordlimit")));
                GO.setAddress(cr.getString(cr.getColumnIndex("address")));
                GO.setPath(cr.getString(cr.getColumnIndex("path")));

            }

            @Override
            public void onNothingSelected(AdapterView<?> parentView) {
                // your code here
            }

        });



    }




    private void setInit(){

        dbHelp = new DatabaseHelper(this);
        valAddress = ((EditText) findViewById(R.id.address)).getText().toString();

        valIp = ((EditText) findViewById(R.id.ipseries)).getText().toString();
        valLimit = ((EditText) findViewById(R.id.limitrow)).getText().toString();
        valPath = ((EditText) findViewById(R.id.path)).getText().toString();
        valProf = ((EditText) findViewById(R.id.prof)).getText().toString();

        txtAddress = (EditText) findViewById(R.id.address);

        txtIp = (EditText) findViewById(R.id.ipseries);
        txtLimit = (EditText) findViewById(R.id.limitrow);
        txtPath = (EditText) findViewById(R.id.path);
        txtProf = (EditText) findViewById(R.id.prof);
;


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







        //sendIntent = new Intent(this,SendService.class);




            if(!sw.isChecked()) {



              stopService(recieveIntent);
                return;
            }


        Toast.makeText(getBaseContext(),"Auto Sync activated",Toast.LENGTH_SHORT).show();




        startService(recieveIntent);






    }





    public void syncManual(View view) {



        if(SmsServiceMonitor.isRunning || SendService.isRunning){

           stopService(recieveIntent);
           stopService(sendIntent);
        }





      InboxMsg inMsg = new InboxMsg();




        toastMessage(GO.getIp());

        inMsg.initClass(GO.getIp());

        Cursor cr = inMsg.getByIdentification(this);




        Log.i("tags",valIp+">>"+valLimit+">>>" + valAddress + " count: " + String.valueOf(cr.getCount()));
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
            Log.i("msg",String.valueOf(x)+ " " + cr.getString(body));
            x++;
        }

        HttpOperationPg rg = new HttpOperationPg(this,arrhs);

        rg.execute();



    }

    public void test3(MenuItem item) {


    }

    public void saveSetting(View view) {


        if(sw4.isChecked()){

            return;
        }


        String ip = txtIp.getText().toString();
        String path = txtPath.getText().toString();
        String limit = txtLimit.getText().toString();
        String address = txtAddress.getText().toString();
        String prof = txtProf.getText().toString();




        boolean insertData = dbHelp.addData(ip,path,limit,address,prof);

        loadSpinnerDataHama();

        if(insertData)
            toastMessage("Settings has been added");
        else
            toastMessage("Error");


    }
    private void toastMessage(String str){
        Toast.makeText(this,str,Toast.LENGTH_LONG).show();
    }
    private void loadSpinnerDataHama() {
        // database handler

        // Spinner Drop down elements
        List <SpinnerObject> lables = dbHelp.getAllLabels();
        // Creating adapter for spinner
        ArrayAdapter<SpinnerObject> dataAdapter = new ArrayAdapter<SpinnerObject>(this,
                android.R.layout.simple_spinner_item, lables);
        // Drop down layout style - list view with radio button
        dataAdapter.setDropDownViewResource(android.R.layout.simple_spinner_dropdown_item);
        // attaching data adapter to spinner
        spProf.setAdapter(dataAdapter);

        Cursor cr = dbHelp.getReadableDatabase().rawQuery("select * from "+dbHelp.TABLE_NAME+" where def = 1 limit 1",null);

        cr.moveToFirst();

        txtPath.setText(cr.getString(cr.getColumnIndex("path")));
        txtLimit.setText(cr.getString(cr.getColumnIndex("recordlimit")));
        txtIp.setText(cr.getString(cr.getColumnIndex("ip")));
        txtAddress.setText(cr.getString(cr.getColumnIndex("address")));
        txtProf.setText(cr.getString(cr.getColumnIndex("prof")));

            Log.i(">>>>",">>>");




    }


    public void deleteProf(View view) {

        int ids = ((SpinnerObject) spProf.getSelectedItem()).getId();


        SQLiteDatabase db = dbHelp.getWritableDatabase();

        db.delete(dbHelp.TABLE_NAME,"id = " + ids,null);
        //loadSpinnerDataHama();

        toastMessage("Profile deleted");


    }

    public void appClose(View view) {


        stopService(new Intent(this, SendService.class));
        stopService(new Intent(this, SmsServiceMonitor.class));

        System.exit(0);
    }

    public void activate2(View view) {



        if(!sw3.isChecked()) {


            stopService(sendIntent);

            return;
        }


        Toast.makeText(getBaseContext(),"Auto Forward activated",Toast.LENGTH_SHORT).show();







        startService(sendIntent);


    }

    public void lockSetting(View view){





    }
}
