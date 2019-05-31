/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package cs.guillemcaballe.appManteniment.classes;

import java.sql.Date;
import java.sql.PreparedStatement;
import java.sql.SQLException;

/**
 *
 * @author guillem
 */
public class Activity {
    private Integer id;
    private String name;
    private Integer product_id;
    private String produt_name;
    private String description;
    private Date timestamp;
    private int count_rating;
    private float avg_rating;

    public Activity(Integer id, String name, Integer product_id, String produt_name, String description, int count_rating, float avg_rating) {
        this.id = id;
        this.name = name;
        this.product_id = product_id;
        this.produt_name = produt_name;
        this.description = description;
        this.count_rating = count_rating;
        this.avg_rating = avg_rating;
    }

    @Override
    public String toString() {
        return "Activity{" + "id=" + id + ", product_id=" + product_id + ", produt_name=" + produt_name + ", description=" + description + ", timestamp=" + timestamp + '}';
    }

    public int getCount_rating() {
        return count_rating;
    }

    public void setCount_rating(int count_rating) {
        this.count_rating = count_rating;
    }

    public float getAvg_rating() {
        return avg_rating;
    }

    public void setAvg_rating(float avg_rating) {
        this.avg_rating = avg_rating;
    }

    public String getName() {
        return name;
    }

    public void setName(String name) {
        this.name = name;
    }
    
    public Integer getId() {
        return id;
    }

    public void setId(Integer id) {
        this.id = id;
    }

    public Integer getProduct_id() {
        return product_id;
    }

    public void setProduct_id(Integer product_id) {
        this.product_id = product_id;
    }

    public String getProdut_name() {
        return produt_name;
    }

    public void setProdut_name(String produt_name) {
        this.produt_name = produt_name;
    }

    public String getDescription() {
        return description;
    }

    public void setDescription(String description) {
        this.description = description;
    }

    public Date getTimestamp() {
        return timestamp;
    }

    public void setTimestamp(Date timestamp) {
        this.timestamp = timestamp;
    }

    public int delete() throws SQLException {
        
        PreparedStatement stDelete;
        if(this.getId() != null){
             stDelete = Controlador.getConnexio().prepareStatement("DELETE FROM activity WHERE id = ?");
            stDelete.setInt(1, id);
        }else{
            stDelete = Controlador.getConnexio().prepareStatement("DELETE FROM activity WHERE name = ?");
            stDelete.setString(1, name);
        }
        
        int res = stDelete.executeUpdate();
        
        /**reviews **/
        
        stDelete.close();
        return res;
        
    }
    
    
}
