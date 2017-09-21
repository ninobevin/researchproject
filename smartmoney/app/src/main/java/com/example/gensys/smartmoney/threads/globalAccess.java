package com.example.gensys.smartmoney.threads;

/**
 * Created by GENsys on 14/02/2017.
 */

public class globalAccess {


    public static  String ip;


    public static  String address;
    public static  String limit;
    public static  String path;

    public static String getIp() {
        return ip;
    }

    public static void setIp(String ip) {
        globalAccess.ip = ip;
    }

    public static void setPath(String path) {
        globalAccess.path = path;
    }

    public static String getPath() { return path; }

    public static String getAddress() {
        return address;
    }

    public static void setAddress(String address) {
        globalAccess.address = address;
    }

    public static String getLimit() {
        return limit;
    }

    public static void setLimit(String limit) {
        globalAccess.limit = limit;
    }
}
