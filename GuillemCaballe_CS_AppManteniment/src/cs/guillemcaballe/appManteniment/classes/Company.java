/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package cs.guillemcaballe.appManteniment.classes;

import cs.guillemcaballe.appManteniment.utils.Md5;
import cs.guillemcaballe.appManteniment.classes.Controlador;
import java.sql.Date;
import java.sql.PreparedStatement;
import java.sql.ResultSet;
import java.sql.SQLException;
import java.util.ArrayList;
import java.util.Calendar;
import java.util.Objects;

/**
 *
 * @author programacio5
 */
public class Company {
    private Integer id;
    private String name;
    private String cif;
    private Usuari user;
    private String address;

    public Company(Integer id, String name, String cif, Usuari user, String address) {
        setId(id);
        setName(name);
        setCif(cif);
        setUser(user);
        setAddress(address);
    }

    public Integer getId() {
        return id;
    }

    public void setId(Integer id) {
        this.id = id;
    }

    public String getName() {
        return name;
    }

    public void setName(String name) {
        this.name = name;
    }

    public String getCif() {
        return cif;
    }

    public void setCif(String cif) {
        this.cif = cif;
    }

    public Usuari getUsuari() {
        return user;
    }

    public void setUser(Usuari user) {
        this.user = user;
    }

    public String getAddress() {
        return address;
    }

    public void setAddress(String address) {
        this.address = address;
    }

    
    @Override
    public int hashCode() {
        int hash = 3;
        hash = 11 * hash + Objects.hashCode(this.id);
        hash = 11 * hash + Objects.hashCode(this.name);
        hash = 11 * hash + Objects.hashCode(this.cif);
        hash = 11 * hash + Objects.hashCode(this.user);
        hash = 11 * hash + Objects.hashCode(this.address);
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
        
        final Company other = (Company) obj;
        if (!Objects.equals(this.id, other.id) && !Objects.equals(this.name, other.name) && !Objects.equals(this.cif, other.cif) && !Objects.equals(this.user, other.user) && !Objects.equals(this.address, other.address)) {
            return false;
        }
        
        return true;
    }

    @Override
    public String toString() {
        return "Company{" + "id=" + id + ", name=" + name + ", cif=" + cif + ", user=" + user.toString() + ", address=" + address + '}';
    }
    
    public int insert() throws SQLException, RuntimeException    {
        /*if (this.estaRepetit())    {
            throw new RuntimeException("Els camps name i cif no poden estar repetits.");
        }*/
        PreparedStatement stInsert = Controlador.getConnexio().prepareStatement("INSERT INTO company (id, name, cif, user, address) VALUES(?, ?, ?, ?, ?)");
        stInsert.setInt(1, id);
        stInsert.setString(2, name);
        stInsert.setString(3, cif);
        stInsert.setInt(4, user.getId());
        stInsert.setString(5, address);
        
        int res = stInsert.executeUpdate();
        stInsert.close();
        return res;
    }
    
    public int update() throws SQLException    {
        PreparedStatement stUpdate = Controlador.getConnexio().prepareStatement("UPDATE company SET name = ?, cif = ?, user = ?, address = ? WHERE id = ?");
        stUpdate.setString(1, name);
        stUpdate.setString(2, cif);
        stUpdate.setInt(3, user.getId());
        stUpdate.setString(4, address);
        stUpdate.setInt(5, id);
        
        int res = stUpdate.executeUpdate();
        stUpdate.close();
        return res;
    }
    
    public int delete() throws SQLException    {
        /*
        if (this.esAdmin() && this.esUltimAdmin())  {
            throw new RuntimeException("No pots esborrar aquest usuari, l'aplicació ha de tindre al menys un usuari administrador.");
        }
        */
        
               
        
        PreparedStatement stDelete = Controlador.getConnexio().prepareStatement("DELETE FROM company WHERE id = ?");
        stDelete.setInt(1, id);
        
        int res = stDelete.executeUpdate();
        
        //deleto user
        Usuari u = this.getUsuari();
        u.delete();
        
        stDelete.close();
        return res;
    }
    
    public boolean teActivities() throws SQLException    {
        PreparedStatement stGrups = Controlador.getConnexio().prepareStatement("SELECT 1 FROM activity a WHERE a.product IN (SELECT p.id FROM product p WHERE p.company = ?)");
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
    
    public static ArrayList<Company> obtenirCompanies() throws SQLException {
        ArrayList<Company> llista = new ArrayList();
        
        PreparedStatement stCompanies = Controlador.getConnexio().prepareStatement("SELECT * FROM company");
        ResultSet resultat = stCompanies.executeQuery();
        
        while (resultat.next()) {
            int id = resultat.getInt("id");
            String name = resultat.getString("name");
            String cif = resultat.getString("cif");
            int user_id = resultat.getInt("user");
            Usuari u = Usuari.get(user_id);
            String address = resultat.getString("address");
            llista.add(new Company(id, name, cif, u, address));
        }
        
        resultat.close();
        stCompanies.close();
        return llista;
    }
    
    public ArrayList obtenirActivities() throws SQLException   {
        ArrayList activities = new ArrayList();
        
        PreparedStatement stActivities = Controlador.getConnexio().prepareStatement(
            "SELECT a.id, a.name, a.product, a.description, count(r.rating) as 'count', avg(IFNULL(r.rating,0)) as 'ratio' "
            + "FROM activity a left JOIN review r on (a.id = r.activity) "
            + "WHERE a.product IN (SELECT id FROM product WHERE company = ? ) "
            + "GROUP BY a.name");
        stActivities.setInt(1, id);
        ResultSet resultat = stActivities.executeQuery();
        Activity a;
        while(resultat.next())  {
            
            //activities.add(resultat.getString("name") + ". " + resultat.getString("count") + " reviews. Avg rating: " + resultat.getString("ratio"));
            a = new Activity(
                resultat.getInt("id"),
                resultat.getString("name"),
                resultat.getInt("product"),
                null,//prod name
                resultat.getString("description"),
                resultat.getInt("count"),
                resultat.getFloat("ratio")
            );
            
            activities.add(a);
        }
        
        resultat.close();
        stActivities.close();
        return activities;
    }
    
    public int afegirActivity(Activity act) throws SQLException {
        /*if (this.obtenirRols().contains(rol))   {
            throw new RuntimeException("L'usuari ja té aquest rol.");
        }*/
        PreparedStatement stAfegir = Controlador.getConnexio().prepareStatement("INSERT INTO activity (name, product, description, status) VALUES (?, (SELECT id FROM product WHERE name = ?), ?, 'open')");
        stAfegir.setString(1, act.getName());
        stAfegir.setString(2, act.getProdut_name());
        stAfegir.setString(3, act.getDescription());
        
        int res = stAfegir.executeUpdate();
        stAfegir.close();
        return res;
    }
 
    /*
    public static ArrayList<Company> obtenirUsuarisMenysActiu(Company excepcio) throws SQLException {
        ArrayList<Company> llista = new ArrayList();
        
        PreparedStatement stUsuaris = Controlador.getConnexio().prepareStatement("SELECT * FROM user WHERE id != ?");
        stUsuaris.setString(1, excepcio.id);
        ResultSet resultat = stUsuaris.executeQuery();
        
        while (resultat.next()) {
            llista.add(new Company(resultat.getString("id"), resultat.getString("username"), resultat.getString("usuari"), resultat.getString("password"), resultat.getString("mail"), resultat.getString("nom"), resultat.getString("cognom1"), resultat.getString("cognom2")));
        }
        
        resultat.close();
        stUsuaris.close();
        return llista;
    }*/
    
    /*
    public boolean estaRepetit() throws SQLException    {
        ArrayList<Company> usuaris = Company.obtenirUsuarisMenysActiu(this);
        
        for (int i = 0; i < usuaris.size(); i++)    {
            if (usuaris.get(i).equals(this))    {
                return true;
            }
        }
        
        return false;
    }*/
    
    public int eliminarActivities() throws SQLException   {
        PreparedStatement stEliminar = Controlador.getConnexio().prepareStatement("DELETE FROM activity WHERE product IN (SELECT id FROM product WHERE company  = ?)");
        stEliminar.setInt(1, this.id);
        
        int res = stEliminar.executeUpdate();
        stEliminar.close();
        return res;
    }
    
    public int eliminarActivity(String activity_name) throws SQLException  {
        PreparedStatement stEliminar = Controlador.getConnexio().prepareStatement("DELETE FROM activity WHERE product IN (SELECT id FROM product WHERE company  = ?) AND name = ?");
        stEliminar.setInt(1, this.id);
        stEliminar.setString(2, activity_name);
        
        int res = stEliminar.executeUpdate();
        stEliminar.close();
        return res;
    }

    public int deleteProducts() throws SQLException {
        
        PreparedStatement stEliminar = Controlador.getConnexio().prepareStatement("DELETE FROM product WHERE company = ?");
        stEliminar.setInt(1, this.getId());
        
        int res = stEliminar.executeUpdate();
        stEliminar.close();
        return res;
        
    }
}
