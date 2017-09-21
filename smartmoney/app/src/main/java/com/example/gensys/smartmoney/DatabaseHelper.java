package com.example.gensys.smartmoney;

import android.content.ContentValues;
import android.content.Context;
import android.database.Cursor;
import android.database.sqlite.SQLiteDatabase;
import android.database.sqlite.SQLiteOpenHelper;

import java.util.ArrayList;
import java.util.List;

/**
 * Created by GENsys on 02/08/2017.
 */

public class DatabaseHelper extends SQLiteOpenHelper {

    public static final String TABLE_NAME = "setting";
    private static final String ID = "id";
    private static final String IP = "ip";
    private static final String PATH = "path";
    private static final String PROF = "prof";
    private static final String LIMIT = "recordlimit";
    private static final String FILTER = "address";
    private static final String DEF = "def";




    public DatabaseHelper(Context context) {
        super(context, TABLE_NAME,null,1);
    }

    @Override
    public void onCreate(SQLiteDatabase db) {

        String createString = "Create table if not exists " + TABLE_NAME + "( "+ ID +" integer primary key autoincrement," +
                                                                    IP +" text, " +
                                                                    PATH +" text," +
                                                                    LIMIT +" text," +
                                                                    FILTER +" text, " +
                                                                    PROF + " text, " +
                                                                    DEF + " integer default 1)" ;

        db.execSQL(createString);



    }

    @Override
    public void onUpgrade(SQLiteDatabase db, int oldVersion, int newVersion) {

        db.execSQL("DROP IF TABLE EXISTS " + TABLE_NAME);
        onCreate(db);

    }

    public boolean addData(String ip,String path,String limit,String filter,String prof){



        SQLiteDatabase db = this.getWritableDatabase();
        ContentValues contentValues = new ContentValues();
        contentValues.put(IP,ip);
        contentValues.put(PATH,path);
        contentValues.put(LIMIT,limit);
        contentValues.put(PROF,prof);
        contentValues.put(FILTER,filter);


        db.rawQuery("update "+ TABLE_NAME + " set def = 0 ",null );


        long result = db.insert(TABLE_NAME,null,contentValues);

        if(result == -1)
            return false;
        else
            return true;

    }

    public Cursor getAllData(){

        SQLiteDatabase db = this.getWritableDatabase();
        Cursor cr = db.rawQuery("select * from " + TABLE_NAME + " order by def asc",null);
        return cr;
    }

    public List< SpinnerObject> getAllLabels(){
        List < SpinnerObject > labels = new ArrayList< SpinnerObject >();
        // Select All Query
        String selectQuery = "SELECT  * FROM " + TABLE_NAME + " order by def desc";

        SQLiteDatabase db = this.getReadableDatabase();
        Cursor cursor = db.rawQuery(selectQuery, null);

        // looping through all rows and adding to list
        if ( cursor.moveToFirst () ) {
            do {
                labels.add ( new SpinnerObject ( cursor.getInt(cursor.getColumnIndex("id")) , cursor.getString(cursor.getColumnIndex("prof")) ) );
            } while (cursor.moveToNext());
        }

        // closing connection
        cursor.close();
        db.close();

        // returning labels
        return labels;
    }
}
