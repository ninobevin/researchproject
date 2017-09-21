package com.example.gensys.smartmoney;

import android.app.Activity;
import android.content.Context;
import android.os.AsyncTask;
import android.util.Log;
import android.widget.ArrayAdapter;
import android.widget.Button;
import android.widget.Toast;

import com.example.gensys.smartmoney.threads.globalAccess;

import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import java.lang.ref.WeakReference;
import java.util.ArrayList;
import java.util.HashMap;
import java.util.List;
import java.util.Objects;

/**
 * Created by GENsys on 13/02/2017.
 */



public class HttpOperation extends AsyncTask {


    Context cnt;
    WeakReference<Activity> mWeakActivity;

    ArrayList<HashMap<String,String>> hsmap;

    String _address;

    public HttpOperation(ArrayList<HashMap<String, String>> hsmap) {

        this.hsmap = hsmap;
        //Log.i("toooost",hsmap.get(0).toString());

    }

    @Override
    protected Object doInBackground(Object[] params) {





            RegisterUserClass ruc = new RegisterUserClass();


            globalAccess GO = new globalAccess();



            for (HashMap<String, String> x : hsmap) {
                String result = ruc.sendPostRequest("http://" + GO.getIp() + "/" + GO.getPath()+"/insert.php", x);


                //Log.i("hsmap", "http://" + GO.getIp() + "/smartmoney/android/insert.php" + x.toString());


            }





        /*

       // Log.i("results",result);

        try {

            StringBuffer strBuff = new StringBuffer();

            strBuff.append(result);

            JSONObject JO = new JSONObject(result);

            JSONArray Jrr = null;

            Log.i("upon",JO.getString("name"));


        } catch (JSONException e) {
            e.printStackTrace();
        }

*/


        return null;
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