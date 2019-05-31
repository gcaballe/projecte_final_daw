/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package cs.guillemcaballe.appManteniment.classes;

import cs.guillemcaballe.appManteniment.gui.FormConnexio;
import cs.guillemcaballe.appManteniment.gui.FormLogin;
import cs.guillemcaballe.appManteniment.gui.FormManteniment;
import cs.guillemcaballe.appManteniment.utils.Md5;
import java.io.UnsupportedEncodingException;
import java.security.NoSuchAlgorithmException;
import java.sql.Connection;
import java.sql.DriverManager;
import java.sql.PreparedStatement;
import java.sql.ResultSet;
import java.sql.SQLException;

/**
 *
 * @author ierman1
 */
public class Controlador {
    
    private static Connection connexio;
    private static Usuari usuariConnectat;

    public static void setUsuariConnectat(Usuari usuariActiu)   {
        Controlador.usuariConnectat = usuariActiu;
    }

    public static Usuari getUsuariConnectat() {
        return usuariConnectat;
    }
    
    public static Connection getConnexio() {
        return connexio;
    }
    
    public static void main(String[] args) {
        FormConnexio fc = new FormConnexio("127.0.0.1:3306", "projecte_daw", "root", "");
    }
    
    public static void obrirConnexio(String url, String bdd, String usuari, String contrasenya, String driver) throws SQLException, ClassNotFoundException {
            switch (driver) {
            
            case "MySql":
                Class.forName("com.mysql.jdbc.Driver");
                connexio = DriverManager.getConnection("jdbc:mysql://" + url + "/" + bdd + "?user=" + usuari + "&password=" + contrasenya);
                break;
            case "Oracle":
                Class.forName("oracle.jdbc.driver.OracleDriver");
                connexio = DriverManager.getConnection("jdbc:oracle:thin:@" + url + ":" + bdd, usuari, contrasenya);
                break;
            default :
                throw new RuntimeException("Driver no vàlid");
        }
        connexio.setAutoCommit(false);
    }
    
    public static void obrirLogin() {
        FormLogin fl = new FormLogin();
    }
    
    public static void validarLogin(String usuari, String contrasenya) throws SQLException, UnsupportedEncodingException, NoSuchAlgorithmException, Exception   {
        PreparedStatement stLogin = Controlador.connexio.prepareStatement("SELECT * FROM user WHERE username = ? AND password = ?");
        stLogin.setString(1, usuari);
        stLogin.setString(2, Md5.getMD5(contrasenya));
        ResultSet resultat = stLogin.executeQuery();
        resultat.next();
        
        if (resultat.getRow() == 0) {
            throw new Exception("Usuari o contrasenya incorrectes.");
        }
        
        Controlador.setUsuariConnectat(new Usuari(resultat.getInt("id"), resultat.getString("username"), resultat.getString("password"), resultat.getString("email"), resultat.getInt("role")));
        
        if (!Controlador.usuariConnectat.esAdmin()) {
            throw new Exception("Aquest usuari no té el rol d'administrador.");
        }
        
        resultat.close();
        stLogin.close();
    }
    
    public static void obrirManteniment()   {
        FormManteniment fm = new FormManteniment();
    }
    
}
