/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package cs.guillemcaballe.appManteniment.classes;

import cs.guillemcaballe.appManteniment.utils.Md5;
import cs.guillemcaballe.appManteniment.classes.Controlador;
import java.sql.PreparedStatement;
import java.sql.ResultSet;
import java.sql.SQLException;
import java.util.ArrayList;
import java.util.Objects;

/**
 *
 * @author programacio5
 */
public class Usuari {
    private Integer id;
    private String username;
    private String password;
    private String correu;
    private Integer rol;

    public Usuari(Integer id, String username, String password, String correu, Integer rol) {
        setId(id);
        setUsername(username);
        setPassword(password);
        setCorreu(correu);
        setRol(rol);
    }

    public Integer getId() {
        return id;
    }

    public void setId(Integer id) {
        this.id = id;
    }

    public String getUsername() {
        return username;
    }

    public void setUsername(String username) {
        this.username = username;
    }

    public String getPassword() {
        return password;
    }

    public void setPassword(String password) {
        this.password = password;
    }

    public String getCorreu() {
        return correu;
    }

    public void setCorreu(String correu) {
        this.correu = correu;
    }

    public Integer getRol() {
        return rol;
    }

    public void setRol(Integer rol) {
        this.rol = rol;
    }

    @Override
    public int hashCode() {
        int hash = 3;
        hash = 11 * hash + Objects.hashCode(this.id);
        hash = 11 * hash + Objects.hashCode(this.username);
        hash = 11 * hash + Objects.hashCode(this.password);
        hash = 11 * hash + Objects.hashCode(this.correu);
        hash = 11 * hash + Objects.hashCode(this.rol);
        return hash;
    }

    @Override
    public boolean equals(Object obj) {
        if (this == obj) {
            return true;
        }
        if (obj == null) {
            return false;
        }
        if (getClass() != obj.getClass()) {
            return false;
        }
        
        final Usuari other = (Usuari) obj;
        if (!Objects.equals(this.id, other.id) && !Objects.equals(this.username, other.username) && !Objects.equals(this.password, other.password) && !Objects.equals(this.correu, other.correu) && !Objects.equals(this.rol, other.rol)) {
            return false;
        }
        
        return true;
    }

    @Override
    public String toString() {
        return "Usuari{" + "id=" + id + ", username=" + username + ", password=" + password + ", correu=" + correu + ", rol=" + rol + '}';
    }
    
    
    public static Usuari get(Integer id) throws SQLException {
        Usuari u;
        PreparedStatement stGrups = Controlador.getConnexio().prepareStatement("SELECT * FROM user WHERE id = ?");
        stGrups.setInt(1, id);
        ResultSet resultat = stGrups.executeQuery();
        resultat.first();
        u = new Usuari(
            resultat.getInt("id"),
            resultat.getString("username"),
            resultat.getString("password"),
            resultat.getString("email"),
            resultat.getInt("role")
        );
        return u;
    }
    
    
    public int insert() throws SQLException, RuntimeException    {
        /*
        if (this.estaRepetit())    {
            throw new RuntimeException("Els camps Username i correu no poden estar repetits.");
        }
        */
        PreparedStatement stInsert = Controlador.getConnexio().prepareStatement("INSERT INTO user (id, username, password, email, role, activated) VALUES(?, ?, ?, ?, ?, 1)");
        stInsert.setInt(1, id);
        stInsert.setString(2, username);
        stInsert.setString(3, password);
        stInsert.setString(4, correu);
        stInsert.setInt(5, rol);
        
        int res = stInsert.executeUpdate();
        stInsert.close();
        return res;
    }
    
    public int update() throws SQLException    {
        PreparedStatement stUpdate = Controlador.getConnexio().prepareStatement("UPDATE user SET username = ?, password = ?, email = ?, role = ? WHERE id = ?");
        stUpdate.setString(1, username);
        stUpdate.setString(2, password);
        stUpdate.setString(3, correu);
        stUpdate.setInt(4, rol);
        stUpdate.setInt(5, id);
        
        int res = stUpdate.executeUpdate();
        stUpdate.close();
        return res;
    }
    
    public int canviarPassword(String novaPassword, String repetirPassword, String passwordActual) throws SQLException {
        if (novaPassword.equals("") || repetirPassword.equals("") || passwordActual.equals(""))    {
            throw new RuntimeException("El tres camps són obligatoris.");
        }
        if (!Md5.getMD5(passwordActual).equals(password)) {
            throw new RuntimeException("Has d'introduir la teva password actual correctament.");
        }
        if (!novaPassword.equals(repetirPassword))  {
            throw new RuntimeException("El camp de password i el de repetir password han de ser iguals.");
        }
        if (novaPassword.equals(passwordActual))   {
            throw new RuntimeException("La nova password no pot ser igual a l'anterior.");
        }
        
        PreparedStatement stUpdate = Controlador.getConnexio().prepareStatement("UPDATE user SET password = ? WHERE id = ?");
        stUpdate.setString(1, Md5.getMD5(novaPassword));
        stUpdate.setInt(2, id);
        
        int res = stUpdate.executeUpdate();
        stUpdate.close();
        return res;
    }
    
    public int canviarPassword(String novaPassword) throws SQLException   {
        if (novaPassword.equals(""))    {
            throw new RuntimeException("La password és obligatoria.");
        }
        if (novaPassword.equals("admin"))    {
            throw new RuntimeException("La password no pot ser admin.");
        }
        
        PreparedStatement stUpdate = Controlador.getConnexio().prepareStatement("UPDATE user SET password = ? WHERE id = ?");
        stUpdate.setString(1, Md5.getMD5(novaPassword));
        stUpdate.setInt(2, id);
        
        int res = stUpdate.executeUpdate();
        stUpdate.close();
        return res;
    }
    
    public int delete() throws SQLException    {
        if (this.esAdmin() && this.esUltimAdmin())  {
            throw new RuntimeException("No pots esborrar aquest usuari, l'aplicació ha de tindre al menys un usuari administrador.");
        }
        
        PreparedStatement stDelete = Controlador.getConnexio().prepareStatement("DELETE FROM user WHERE id = ?");
        stDelete.setInt(1, id);
        
        int res = stDelete.executeUpdate();
        stDelete.close();
        return res;
    }
    
    /*
    public int afegirRol(String rol) throws SQLException {
        if (this.obtenirRols().contains(rol))   {
            throw new RuntimeException("L'usuari ja té aquest rol.");
        }
        PreparedStatement stAfegir = Controlador.getConnexio().prepareStatement("INSERT INTO tbl_rols_usuaris VALUES (?, (SELECT codi_rol FROM tbl_rols WHERE nom = ?))");
        stAfegir.setString(1, this.id);
        stAfegir.setString(2, rol);
        
        int res = stAfegir.executeUpdate();
        stAfegir.close();
        return res;
    }*/
    
    public int eliminarRols() throws SQLException   {
        PreparedStatement stEliminar = Controlador.getConnexio().prepareStatement("DELETE FROM tbl_rols_usuaris WHERE id = ?");
        stEliminar.setInt(1, this.id);
        
        int res = stEliminar.executeUpdate();
        stEliminar.close();
        return res;
    }
    
    public int eliminarRol(String rol) throws SQLException  {
        PreparedStatement stEliminar = Controlador.getConnexio().prepareStatement("DELETE FROM tbl_rols_usuaris WHERE id = ? AND codi_rol = (SELECT codi_rol FROM tbl_rols WHERE nom = ?)");
        stEliminar.setInt(1, this.id);
        stEliminar.setString(2, rol);
        
        int res = stEliminar.executeUpdate();
        stEliminar.close();
        return res;
    }
    
    public boolean esCompany() throws SQLException    {
        if (getRol().equals(1)) {
            return true;
        }
        return false;
    }
    
    public boolean esClient() throws SQLException    {
        if (getRol().equals(2)) {
            return true;
        }
        return false;
    }
    
    public boolean esAdmin() throws SQLException    {
        if (getRol().equals(0)) {
            return true;
        }
        return false;
    }
    
    public boolean esUltimAdmin() throws SQLException {
        PreparedStatement stAdmins = Controlador.getConnexio().prepareStatement("SELECT count(u.id) as 'numAdmins' FROM user u WHERE u.role = 0");
        ResultSet resultat = stAdmins.executeQuery();
        resultat.first();
        
        if (resultat.getInt("numAdmins") == 1)  {
            return true;
        }
        return false;
    }
    
    public boolean teActivities() throws SQLException    {
        PreparedStatement stGrups = Controlador.getConnexio().prepareStatement("SELECT 1 FROM activity a WHERE a.product IN (SELECT p.id FROM product p WHERE p.company = (SELECT c.id FROM company c WHERE c.user = ?)");
        stGrups.setInt(1, this.id);
        ResultSet resultat = stGrups.executeQuery();
        resultat.next();
        
        if (resultat.getRow() == 0) {
            return false;
        }
        return true;
    }
    
    public boolean teAlumnes() throws SQLException    {
        return false;
        /*
        PreparedStatement stAlumnes = Controlador.getConnexio().prepareStatement("SELECT 1 FROM tbl_alumnes WHERE codi_pare = ?");
        stAlumnes.setString(1, this.id);
        ResultSet resultat = stAlumnes.executeQuery();
        resultat.next();
        
        if (resultat.getRow() == 0) {
            return false;
        }
        return true;*/
    }
    
    /*
    public ArrayList obtenirRol() throws SQLException   {
        ArrayList rols = new ArrayList();
        PreparedStatement stRols = Controlador.getConnexio().prepareStatement("SELECT r.nom FROM tbl_rols_usuaris ru JOIN tbl_rols r ON (ru.codi_rol = r.codi_rol) WHERE ru.id = ?");
        stRols.setString(1, id);
        ResultSet resultat = stRols.executeQuery();
        
        while(resultat.next())  {
            rols.add(resultat.getString("nom"));
        }
        
        resultat.close();
        stRols.close();
        return rols;
    }*/
    
    /*
    public static ArrayList<Usuari> obtenirCompanies() throws SQLException {
        ArrayList<Usuari> llista = new ArrayList();
        
        PreparedStatement stUsuaris = Controlador.getConnexio().prepareStatement("SELECT * FROM user");
        ResultSet resultat = stUsuaris.executeQuery();
        
        while (resultat.next()) {
            llista.add(new Usuari(resultat.getString("id"), resultat.getString("username"), resultat.getString("usuari"), resultat.getString("password"), resultat.getString("mail"), resultat.getString("nom"), resultat.getString("cognom1"), resultat.getString("cognom2")));
        }
        
        resultat.close();
        stUsuaris.close();
        return llista;
    }
    
    public static ArrayList<Usuari> obtenirUsuarisMenysActiu(Usuari excepcio) throws SQLException {
        ArrayList<Usuari> llista = new ArrayList();
        
        PreparedStatement stUsuaris = Controlador.getConnexio().prepareStatement("SELECT * FROM user WHERE id != ?");
        stUsuaris.setString(1, excepcio.id);
        ResultSet resultat = stUsuaris.executeQuery();
        
        while (resultat.next()) {
            llista.add(new Usuari(resultat.getString("id"), resultat.getString("username"), resultat.getString("usuari"), resultat.getString("password"), resultat.getString("mail"), resultat.getString("nom"), resultat.getString("cognom1"), resultat.getString("cognom2")));
        }
        
        resultat.close();
        stUsuaris.close();
        return llista;
    }
    
    public boolean estaRepetit() throws SQLException    {
        ArrayList<Usuari> usuaris = Usuari.obtenirUsuarisMenysActiu(this);
        
        for (int i = 0; i < usuaris.size(); i++)    {
            if (usuaris.get(i).equals(this))    {
                return true;
            }
        }
        
        return false;
    }*/
    
}
