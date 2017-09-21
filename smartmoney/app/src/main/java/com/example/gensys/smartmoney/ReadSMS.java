package com.example.gensys.smartmoney;

import android.content.ContentResolver;
import android.content.Context;
import android.database.Cursor;
import android.net.Uri;
import android.support.annotation.RequiresPermission;

/**
 * Created by GENsys on 13/02/2017.
 */

public class ReadSMS {


    Context ctx;

    public void ReadSMS(Context cntx){

        ctx = cntx;
    }

    public Cursor getSms(){

        Cursor cursor = ctx.getContentResolver().query(Uri.parse("content://sms/inbox"), null, null, null, null);

        return cursor;

        /*
        if (cursor.moveToFirst()) { // must check the result to prevent exception
            do {
                String msgData = "";
                for(int idx=0;idx<cursor.getColumnCount();idx++)
                {
                    msgData += " " + cursor.getColumnName(idx) + ":" + cursor.getString(idx);
                }
                // use msgData
            } while (cursor.moveToNext());
        } else {
            // empty box, no SMS
        }

        */
    }
}
