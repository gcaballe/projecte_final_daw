package cs.guillemcaballe.appManteniment.utils;

import java.nio.ByteBuffer;
import java.security.SecureRandom;
import java.util.Random;

public class UniqId {
    /***
     *  Copy of uniqid in php http://php.net/manual/fr/function.uniqid.php
     * @param prefix
     * @param more_entropy
     * @return
     */
    public static String uniqid(String prefix, boolean more_entropy)    {
        long time = System.currentTimeMillis();
        String uniqid = String.format("%fd%05f", Math.floor(time),(time-Math.floor(time))*1000000);
        uniqid = uniqid.substring(0, 13);
        //String uniqid = "";
        if(!more_entropy)   {
            uniqid = String.format("%s%08x%05x", prefix, time/1000, time);
        }   else    {
            SecureRandom sec = new SecureRandom();
            byte[] sbuf = sec.generateSeed(8);
            ByteBuffer bb = ByteBuffer.wrap(sbuf);

            uniqid = String.format("%s%08x%05x", prefix, time/1000, time);
            uniqid += "." + String.format("%.8s", ""+bb.getLong()*-1);
        }

        return uniqid ;
    }
    
    public static int getRandomNumberInRange(int min, int max) {

            if (min >= max) {
                    throw new IllegalArgumentException("max must be greater than min");
            }

            Random r = new Random();
            return r.nextInt((max - min) + 1) + min;
    }
}
