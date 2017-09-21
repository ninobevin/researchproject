package com.example.gensys.smartmoney;

/**
 * Created by GENsys on 02/08/2017.
 */

public class SpinnerObject {

    private  int id;
    private String value;


    public SpinnerObject ( int databaseId , String databaseValue ) {
        this.id = databaseId;
        this.value = databaseValue;
    }

    public int getId () {
        return id;
    }

    public String getValue () {
        return value;
    }

    @Override
    public String toString () {
        return value;
    }

}