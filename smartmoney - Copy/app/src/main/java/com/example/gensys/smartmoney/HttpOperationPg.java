package com.example.gensys.smartmoney;

import android.app.Activity;
import android.content.Context;
import android.media.MediaPlayer;
import android.os.AsyncTask;
import android.util.Log;
import android.widget.Button;
import android.widget.EditText;
import android.widget.ProgressBar;
import android.widget.TextView;

import com.example.gensys.smartmoney.threads.globalAccess;

import org.w3c.dom.Text;

import java.lang.ref.WeakReference;
import java.util.ArrayList;
import java.util.HashMap;

/**
 * Created by GENsys on 13/02/2017.
 */



public class HttpOperationPg extends AsyncTask {


    Context cnt;
    WeakReference<Activity> mWeakActivity;

    ArrayList<HashMap<String,String>> hsmap;

    private static MediaPlayer mp;
    private static MediaPlayer mp2;

    String _address;
    ProgressBar  pg;
    TextView txtProgress;
    Button btnExec;
    EditText txtprog;

    public HttpOperationPg(Activity ctx, ArrayList<HashMap<String, String>> hsmap) {



        this.mWeakActivity = new WeakReference<Activity>(ctx);
        this.hsmap = hsmap;

        pg = (ProgressBar) mWeakActivity.get().findViewById(R.id.progressBar);
        btnExec = (Button) mWeakActivity.get().findViewById(R.id.btnManual);
        txtProgress = (TextView) mWeakActivity.get().findViewById(R.id.txtProgress);
        mp= MediaPlayer.create(mWeakActivity.get(), R.raw.ironman);
        mp2= MediaPlayer.create(mWeakActivity.get(), R.raw.complete);
        txtprog = (EditText) mWeakActivity.get().findViewById(R.id.txtProg);

    }

    @Override
    protected void onPreExecute() {
        //super.onPreExecute()

        txtprog.setText("");
        btnExec.setEnabled(false);
        btnExec.setClickable(false);

       if(mp.isPlaying()){


           mp.pause();

       }

        mp.start();
    }

    @Override
    protected Object doInBackground(Object[] params) {



        RegisterUserClass ruc = new RegisterUserClass();


        globalAccess GO = new globalAccess();
    int total = hsmap.size();
    int count = 1;
    for(HashMap<String,String> x: hsmap)
    {
        String result = ruc.sendPostRequest("http://"+GO.getIp()+"/smartmoney/android/insert.php", x);



        //     Log.i("hsmap",x.toString());
        String str = x.get("body").toString();
        publishProgress((Double.valueOf(count) / total) * 100,str);
        count++;

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
        //super.onProgressUpdate(values);

       // Log.i("perc", String.valueOf((int) values[0]));
        Double dv = new Double((Double) values[0]);
        pg.setProgress(dv.intValue());
        txtProgress.setText("Transfer Progress " + String.valueOf(dv.intValue()) + "%");
        String str = String.valueOf(values[1]);

        txtprog.append("\r\n"+str);

    }

    @Override
    protected void onPostExecute(Object o) {
        //super.onPostExecute(o);

        btnExec.setEnabled(true);
        btnExec.setClickable(true);

        txtProgress.setText("Transfer Complete!");
        mp.stop();
        mp2.start();

    }
}