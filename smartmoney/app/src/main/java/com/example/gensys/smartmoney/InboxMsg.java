package com.example.gensys.smartmoney;


import android.content.ContentResolver;
import android.content.Context;
import android.database.Cursor;
import android.net.Uri;
import android.util.Log;

import com.example.gensys.smartmoney.threads.globalAccess;

import java.util.ArrayList;
import java.util.List;


/**
 * Created by User on 2/1/2017.
 */

public class InboxMsg {

    private static  String address;
    private static String limit;
    private static globalAccess go = new globalAccess();



    public static void initClass(String add){

        address = add;

    }


    public  static Cursor getByIdentification(Context context){



        ContentResolver contentResolver =  context.getContentResolver();
        Cursor smsInboxCursor = contentResolver.query(
                Uri.parse("content://sms/inbox"),null
                ,"address is not null and address in('SmartPadala','SMARTMoney')", null,"date desc");



        return smsInboxCursor;


    }

    public  static List<String> getInbox(Context context){



        ContentResolver contentResolver =  context.getContentResolver();
        Cursor smsInboxCursor = contentResolver.query(
                Uri.parse("content://sms/inbox"),null
                , "address is not null) group by (address", null, null);




        int indexBody = smsInboxCursor.getColumnIndex("body");
        int indexAddress = smsInboxCursor.getColumnIndex("address");




        List<String> msg_arr = new ArrayList<String>();


        while (smsInboxCursor.moveToNext()){

            String smsInbox =  smsInboxCursor.getString(indexAddress);

            msg_arr.add(smsInbox);

        }


        return msg_arr;


    }



}
