package com.example.gensys.smartmoney.threads;

import android.app.Activity;
import android.content.Context;
import android.os.AsyncTask;
import android.util.Log;
import android.widget.ProgressBar;
import android.widget.Toast;

import com.example.gensys.smartmoney.R;

/**
 * Created by GENsys on 14/02/2017.
 */

public class newThread extends AsyncTask {





    @Override
    protected Object doInBackground(Object[] params) {


        while(true){


            Log.i("trid",">>>>");


        }


    }

    @Override
    protected void onProgressUpdate(Object[] values) {
        //super.onProgressUpdate(values);

       // Toast.makeText(ctx,"sdfasdfas",Toast.LENGTH_SHORT).show();


       // pg.setProgress(((int)values[0]));


    }
}
