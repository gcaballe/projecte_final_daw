package cs.guillemcaballe.appManteniment.gui;

import cs.guillemcaballe.appManteniment.classes.Activity;
import cs.guillemcaballe.appManteniment.classes.Company;
import cs.guillemcaballe.appManteniment.classes.Usuari;
import cs.guillemcaballe.appManteniment.classes.Controlador;
import java.awt.event.ActionEvent;
import java.awt.event.ActionListener;
import java.awt.event.WindowAdapter;
import java.awt.event.WindowEvent;
import java.sql.PreparedStatement;
import java.sql.ResultSet;
import java.sql.SQLException;
import java.util.ArrayList;
import java.util.logging.Level;
import java.util.logging.Logger;
import javax.swing.DefaultListModel;
import javax.swing.JOptionPane;
import javax.swing.event.ListSelectionEvent;
import javax.swing.event.ListSelectionListener;

/**
 *
 * @author ierman1
 */
public class FormManteniment extends javax.swing.JFrame {

    private Usuari usuariActiu;
    private Company companyActiva;
    private FormCrearCompany fcu;
    //private FormCanviarContrasenyaAdmin fcc;
    private FormAfegirActivity faa;
    private FormModificarCompany fmc;
    private static boolean canvis = false;
    private static ArrayList<Usuari> usuaris;
    private static ArrayList<Company> companies;
    private static ArrayList<Activity> activities;
    
    /**
     * Creates new form FormManteniment
     */
    public FormManteniment() {
        initComponents();
        configuracio();
        prepararEvents();
    }
    
    private void configuracio()  {
        this.setVisible(true);
        
        fcu = new FormCrearCompany();
        //fcc = new FormCanviarContrasenyaAdmin();
        faa = new FormAfegirActivity();
        fmc = new FormModificarCompany();
        
        // Obtenim els usuaris:
        try {
            companies = Company.obtenirCompanies();
        } catch (SQLException ex) {
            JOptionPane.showMessageDialog(this, ex.getMessage(), "Error", JOptionPane.ERROR_MESSAGE);
            try {
                Controlador.getConnexio().close();
            } catch (SQLException ex1) {
                JOptionPane.showMessageDialog(FormManteniment.this, ex.getMessage(), "Error", JOptionPane.ERROR_MESSAGE);
            }
            System.exit(1);
        }
        // Generem la llista de les companies:
        generarLlistaCompanies();
    }
    
    private void prepararEvents()   {
        this.addWindowListener(new WindowAdapter() {
            @Override
            public void windowClosing(WindowEvent e) {
                if (canvis) {
                    switch (JOptionPane.showConfirmDialog(FormManteniment.this, "Hi han canvis pendents, vols desar-los?", "Confirmar canvis", JOptionPane.YES_NO_CANCEL_OPTION))   {
                        case 0 :
                            try {
                                Controlador.getConnexio().commit();
                                Controlador.getConnexio().close();
                            } catch (SQLException ex) {
                                JOptionPane.showMessageDialog(FormManteniment.this, ex.getMessage(), "Error", JOptionPane.ERROR_MESSAGE);
                            }
                            System.exit(1);
                            break;
                        case 1 :
                            try {
                                Controlador.getConnexio().rollback();
                                Controlador.getConnexio().close();
                            } catch (SQLException ex) {
                                JOptionPane.showMessageDialog(FormManteniment.this, ex.getMessage(), "Error", JOptionPane.ERROR_MESSAGE);
                            }
                            System.exit(1);
                            break;
                        default :
                            break;
                    }
                }   else    {
                    try {
                        Controlador.getConnexio().commit();
                        Controlador.getConnexio().close();
                    } catch (SQLException ex) {
                        JOptionPane.showMessageDialog(FormManteniment.this, ex.getMessage(), "Error", JOptionPane.ERROR_MESSAGE);
                    }
                    System.exit(1);
                }
            }
        });
        btnSortir.addActionListener(new ActionListener() {
            @Override
            public void actionPerformed(ActionEvent e) {
                if (canvis) {
                    switch (JOptionPane.showConfirmDialog(FormManteniment.this, "Hi han canvis pendents, vols desar-los?", "Confirmar canvis", JOptionPane.YES_NO_CANCEL_OPTION))   {
                        case 0 :
                            try {
                                Controlador.getConnexio().commit();
                            } catch (SQLException ex) {
                                JOptionPane.showMessageDialog(FormManteniment.this, ex.getMessage(), "Error", JOptionPane.ERROR_MESSAGE);
                            }
                            canvis = false;
                            FormManteniment.this.setVisible(false);
                            Controlador.obrirLogin();
                            break;
                        case 1 :
                            try {
                                Controlador.getConnexio().rollback();
                            } catch (SQLException ex) {
                                JOptionPane.showMessageDialog(FormManteniment.this, ex.getMessage(), "Error", JOptionPane.ERROR_MESSAGE);
                            }
                            canvis = false;
                            FormManteniment.this.setVisible(false);
                            Controlador.obrirLogin();
                            break;
                        default :
                            break;
                    }
                }   else    {
                    try {
                        Controlador.getConnexio().commit();
                    } catch (SQLException ex) {
                        JOptionPane.showMessageDialog(FormManteniment.this, ex.getMessage(), "Error", JOptionPane.ERROR_MESSAGE);
                    }
                    canvis = false;
                    FormManteniment.this.setVisible(false);
                    Controlador.obrirLogin();
                }
            }
        });
        btnCommit.addActionListener(new ActionListener() {
            @Override
            public void actionPerformed(ActionEvent e) {
                if (canvis) {
                    try {
                        Controlador.getConnexio().commit();
                        canvis = false;
                        JOptionPane.showMessageDialog(FormManteniment.this, "Canvis desats correctament", "Canvis realitzats", JOptionPane.INFORMATION_MESSAGE);
                    } catch (SQLException ex) {
                        JOptionPane.showMessageDialog(FormManteniment.this, ex.getMessage(), "Error", JOptionPane.ERROR_MESSAGE);
                    }
                }   else    {
                    JOptionPane.showMessageDialog(FormManteniment.this, "No hi han canvis a desar", "Error", JOptionPane.ERROR_MESSAGE);
                }
            }
        });
        btnRollback.addActionListener(new ActionListener() {
            @Override
            public void actionPerformed(ActionEvent e) {
                if (canvis) {
                    try {
                        Controlador.getConnexio().rollback();
                        canvis = false;
                        companies = Company.obtenirCompanies();
                        netejarCamps();
                        generarLlistaCompanies();
                        JOptionPane.showMessageDialog(FormManteniment.this, "Canvis desfets correctament", "Canvis desfets", JOptionPane.INFORMATION_MESSAGE);
                    } catch (SQLException ex) {
                        JOptionPane.showMessageDialog(FormManteniment.this, ex.getMessage(), "Error", JOptionPane.ERROR_MESSAGE);
                    }
                }   else    {
                    JOptionPane.showMessageDialog(FormManteniment.this, "No hi han canvis que desfer", "Error", JOptionPane.ERROR_MESSAGE);
                }
            }
        });
        llistaCompanies.addListSelectionListener(new ListSelectionListener() {
            @Override
            public void valueChanged(ListSelectionEvent e) {
                if (llistaCompanies.getSelectedIndex() == -1)  {
                    netejarCamps();
                    return;
                }
                if (!e.getValueIsAdjusting()) {
                    try {
                        mostrarCompany(llistaCompanies.getSelectedValue().toString());
                    } catch (SQLException ex) {
                        JOptionPane.showMessageDialog(FormManteniment.this, ex.getMessage(), "Error", JOptionPane.ERROR_MESSAGE);
                        try {
                            Controlador.getConnexio().close();
                        } catch (SQLException ex1) {
                            JOptionPane.showMessageDialog(FormManteniment.this, ex.getMessage(), "Error", JOptionPane.ERROR_MESSAGE);
                        }
                        System.exit(1);
                    }
                }
            }
        });
        btnAfegirCompany.addActionListener(new ActionListener() {
            @Override
            public void actionPerformed(ActionEvent e) {
                fcu.setVisible(true);
                fcu.addWindowListener(new WindowAdapter() {
                    @Override
                    public void windowDeactivated(WindowEvent e) {
                        generarLlistaCompanies();
                    }
                });
            }
        });
        btnEliminarCompany.addActionListener(new ActionListener() {
            @Override
            public void actionPerformed(ActionEvent e) {
                if (llistaCompanies.getSelectedValue() == null)   {
                    JOptionPane.showMessageDialog(FormManteniment.this, "Has de seleccionar una company.", "Error", JOptionPane.ERROR_MESSAGE);
                    return;
                }
                /*if (usuariActiu.equals(Controlador.getUsuariConnectat()))  {
                    JOptionPane.showMessageDialog(FormManteniment.this, "No et pots esborrar a tu mateix.", "Error", JOptionPane.ERROR_MESSAGE);
                    return;
                }*/
                try {
                    /*if (companyActiva.teActivities() && usuariActiu.teAlumnes())  {
                        JOptionPane.showMessageDialog(FormManteniment.this, "La company té activities associades, no es pot eliminar.", "Error", JOptionPane.ERROR_MESSAGE);
                        return;
                    }*/
                    if (companyActiva.teActivities())  {
                        if (JOptionPane.showConfirmDialog(FormManteniment.this, "Estas segur que vols eliminar la company " + companyActiva.getName(), "Confirmar eliminació", JOptionPane.YES_NO_OPTION) == 0)   {
                            try {
                                companyActiva.eliminarActivities();
                                companyActiva.deleteProducts();
                                companyActiva.delete();
                            } catch (SQLException | RuntimeException ex) {
                                JOptionPane.showMessageDialog(FormManteniment.this, ex.getMessage(), "Error", JOptionPane.ERROR_MESSAGE);
                                return;
                            }
                            netejarCamps();
                            FormManteniment.removeCompany(companyActiva);
                            llistaCompanies.setSelectedIndex(-1);
                            usuariActiu = null;
                            canvis = true;
                            generarLlistaCompanies();
                        }
                    }
                    /*if (usuariActiu.esTutor() && usuariActiu.teGrups()) {
                        JOptionPane.showMessageDialog(FormManteniment.this, "L'usuari té grups associats, no es pot eliminar.", "Error", JOptionPane.ERROR_MESSAGE);
                        return;
                    }*/
                } catch (SQLException ex) {
                    JOptionPane.showMessageDialog(FormManteniment.this, ex.getMessage(), "Error", JOptionPane.ERROR_MESSAGE);
                    return;
                }
            }
        });
        btnModificarCompany.addActionListener(new ActionListener() {
            @Override
            public void actionPerformed(ActionEvent e) {
                if (companyActiva == null)    {
                    JOptionPane.showMessageDialog(FormManteniment.this, "Has de seleccionar una company.", "Error", JOptionPane.ERROR_MESSAGE);
                    return;
                }
                fmc.setCompany(companyActiva);
                fmc.setVisible(true);
                fmc.addWindowListener(new WindowAdapter() {
                    @Override
                    public void windowDeactivated(WindowEvent e) {
                        generarLlistaCompanies();
                    }
                });
            }
        });
        /*btnCanviarContrasenya.addActionListener(new ActionListener() {
            @Override
            public void actionPerformed(ActionEvent e) {
                fcc.setUsuari(usuariActiu);
                fcc.setVisible(true);
            }
        });*/
        btnAfegirActivity.addActionListener(new ActionListener() {
            @Override
            public void actionPerformed(ActionEvent e) {
                if (llistaCompanies.getSelectedValue() == null)   {
                    JOptionPane.showMessageDialog(FormManteniment.this, "Has de seleccionar una company.", "Error", JOptionPane.ERROR_MESSAGE);
                    return;
                }
                faa.setCompany(companyActiva);
                faa.setVisible(true);
                faa.addWindowListener(new WindowAdapter() {
                    @Override
                    public void windowDeactivated(WindowEvent e) {
                        mostrarActivities();
                    }
                });
            }
        });
        btnEliminarActivity.addActionListener(new ActionListener() {
            @Override
            public void actionPerformed(ActionEvent e) {
                if (llistaCompanies.getSelectedValue() == null)   {
                    JOptionPane.showMessageDialog(FormManteniment.this, "Has de seleccionar una company.", "Error", JOptionPane.ERROR_MESSAGE);
                    return;
                }
                if (llistaActivities.getSelectedValue() == null)  {
                    JOptionPane.showMessageDialog(FormManteniment.this, "Has de seleccionar una activity.", "Error", JOptionPane.ERROR_MESSAGE);
                    return;
                }
                /*if (llistaActivities.getSelectedValue().equals("Administrador") && usuariActiu.equals(Controlador.getUsuariConnectat()))  {
                    JOptionPane.showMessageDialog(FormManteniment.this, "No pots esborrar el rol administrador de l'usuari connectat.", "Error", JOptionPane.ERROR_MESSAGE);
                    return;
                }*/
                try {/*
                    if (llistaActivities.getSelectedValue().equals("Tutor") && usuariActiu.teGrups()) {
                        JOptionPane.showMessageDialog(FormManteniment.this, "La company te grups associats, no es pot eliminar el rol de tutor.", "Error", JOptionPane.ERROR_MESSAGE);
                        return;
                    }*/
                    if (llistaActivities.getSelectedValue().equals("Familiar") && usuariActiu.teAlumnes()) {
                        JOptionPane.showMessageDialog(FormManteniment.this, "L'activity te reviews associades, no es pot eliminar.", "Error", JOptionPane.ERROR_MESSAGE);
                        return;
                    }
                } catch (SQLException ex) {
                    JOptionPane.showMessageDialog(FormManteniment.this, ex.getMessage(), "Error", JOptionPane.ERROR_MESSAGE);
                }
                Activity a = activities.get(llistaActivities.getSelectedIndex());
                System.out.println(a.toString());
                if (JOptionPane.showConfirmDialog(FormManteniment.this, "Estas segur que vols eliminar l'activity " + a.getName() + " de la company " + companyActiva.getName(), "Confirmar eliminació", JOptionPane.YES_NO_OPTION) == 0)   {
                    try {
                        a.delete();
                        activities = companyActiva.obtenirActivities();
                        System.out.println(activities.size());
                        activities.remove(a);
                        System.out.println(activities.size());
                        mostrarActivities();
                        canvis = true;
                    } catch (SQLException ex) {
                        JOptionPane.showMessageDialog(FormManteniment.this, ex.getMessage(), "Error", JOptionPane.ERROR_MESSAGE);
                    }
                }
            }
        });
    }
    
    private void mostrarCompany(String company_name) throws SQLException    {
        if (company_name == null) {
            return;
        }
        PreparedStatement stCompany = Controlador.getConnexio().prepareStatement("SELECT * FROM company WHERE name = ?", ResultSet.TYPE_SCROLL_INSENSITIVE, ResultSet.CONCUR_UPDATABLE);
        stCompany.setString(1, company_name);
        ResultSet resultat = stCompany.executeQuery();
        resultat.first();
        
        Usuari u = Usuari.get(resultat.getInt("user"));
        
        this.companyActiva = new Company(resultat.getInt("id"), resultat.getString("name"), resultat.getString("cif"), u, resultat.getString("address"));

        
        // Assignem els camps de l'usuari als camps informatius
        lblCompanySel.setText(companyActiva.getId() + " - " + companyActiva.getName());
        lblCifInfo.setText(companyActiva.getCif());
        lblUsernameInfo.setText(companyActiva.getUsuari().getUsername());
        lblAddressInfo.setText((companyActiva.getAddress() == null ? "???" : companyActiva.getAddress()));
        lblNameInfo.setText(companyActiva.getName());
        lblCorreuInfo.setText(companyActiva.getUsuari().getCorreu());
        
        resultat.close();
        stCompany.close();
        
        activities = companyActiva.obtenirActivities();
        mostrarActivities();
    }
    
    private void mostrarActivities()  {
        DefaultListModel model = new DefaultListModel();
        String text;
        for (int i = 0; i < activities.size(); i++)   {
            text = activities.get(i).getName() + ". " + activities.get(i).getCount_rating() + " reviews. Avg rating: " + activities.get(i).getAvg_rating();
            model.addElement(text);
        }
        
        llistaActivities.setModel(model);
    }
    
    private void netejarCamps() {
        lblCompanySel.setText("Cap company seleccionada");
        lblCifInfo.setText("---");
        lblUsernameInfo.setText("---");
        lblAddressInfo.setText("---");
        lblNameInfo.setText("---");
        lblCorreuInfo.setText("---");
        
        llistaActivities.setModel(new DefaultListModel());
        activities.removeAll(activities);
    }

    private void generarLlistaCompanies()  {
        DefaultListModel model = new DefaultListModel();
        
        for (int i = 0; i < companies.size(); i++) {
            model.addElement(companies.get(i).getName());
        }
        
        llistaCompanies.setModel(model);
    }
    
    public static void addActivity(Activity activity)   {
        activities.add(activity);
    }
    
    public static boolean removeActivity(String activity) {
        return activities.remove(activity);
    }
    
    public static void addCompany(Company company)  {
        companies.add(company);
    }
    
    public static boolean removeCompany(Company company)  {
        return companies.remove(company);
    }
    
    public static void hiHanCanvis()    {
        canvis = true;
    }
    
    /**
     * This method is called from within the constructor to initialize the form.
     * WARNING: Do NOT modify this code. The content of this method is always
     * regenerated by the Form Editor.
     */
    @SuppressWarnings("unchecked")
    // <editor-fold defaultstate="collapsed" desc="Generated Code">//GEN-BEGIN:initComponents
    private void initComponents() {

        jPanel1 = new javax.swing.JPanel();
        jLabel1 = new javax.swing.JLabel();
        btnSortir = new javax.swing.JButton();
        btnRollback = new javax.swing.JButton();
        btnCommit = new javax.swing.JButton();
        jSeparator1 = new javax.swing.JSeparator();
        jPanel2 = new javax.swing.JPanel();
        jScrollPane1 = new javax.swing.JScrollPane();
        llistaCompanies = new javax.swing.JList<>();
        btnAfegirCompany = new javax.swing.JButton();
        btnEliminarCompany = new javax.swing.JButton();
        jPanel3 = new javax.swing.JPanel();
        lblCompanySel = new javax.swing.JLabel();
        jLabel3 = new javax.swing.JLabel();
        jLabel4 = new javax.swing.JLabel();
        jLabel5 = new javax.swing.JLabel();
        jLabel6 = new javax.swing.JLabel();
        jLabel7 = new javax.swing.JLabel();
        btnModificarCompany = new javax.swing.JButton();
        jLabel8 = new javax.swing.JLabel();
        jScrollPane2 = new javax.swing.JScrollPane();
        llistaActivities = new javax.swing.JList<>();
        btnEliminarActivity = new javax.swing.JButton();
        btnAfegirActivity = new javax.swing.JButton();
        lblCifInfo = new javax.swing.JLabel();
        lblNameInfo = new javax.swing.JLabel();
        lblUsernameInfo = new javax.swing.JLabel();
        lblAddressInfo = new javax.swing.JLabel();
        lblCorreuInfo = new javax.swing.JLabel();

        setDefaultCloseOperation(javax.swing.WindowConstants.DO_NOTHING_ON_CLOSE);
        setTitle("Manteniment");

        jLabel1.setFont(new java.awt.Font("Tahoma", 1, 24)); // NOI18N
        jLabel1.setHorizontalAlignment(javax.swing.SwingConstants.CENTER);
        jLabel1.setText("Manteniment de companies");

        btnSortir.setFont(new java.awt.Font("Tahoma", 1, 14)); // NOI18N
        btnSortir.setText("Tornar al login");

        btnRollback.setFont(new java.awt.Font("Tahoma", 1, 14)); // NOI18N
        btnRollback.setText("Rollback");

        btnCommit.setFont(new java.awt.Font("Tahoma", 1, 14)); // NOI18N
        btnCommit.setText("Commit");

        javax.swing.GroupLayout jPanel1Layout = new javax.swing.GroupLayout(jPanel1);
        jPanel1.setLayout(jPanel1Layout);
        jPanel1Layout.setHorizontalGroup(
            jPanel1Layout.createParallelGroup(javax.swing.GroupLayout.Alignment.LEADING)
            .addGroup(jPanel1Layout.createSequentialGroup()
                .addComponent(jLabel1, javax.swing.GroupLayout.DEFAULT_SIZE, javax.swing.GroupLayout.DEFAULT_SIZE, Short.MAX_VALUE)
                .addPreferredGap(javax.swing.LayoutStyle.ComponentPlacement.RELATED)
                .addComponent(btnCommit, javax.swing.GroupLayout.PREFERRED_SIZE, 100, javax.swing.GroupLayout.PREFERRED_SIZE)
                .addPreferredGap(javax.swing.LayoutStyle.ComponentPlacement.RELATED)
                .addComponent(btnRollback, javax.swing.GroupLayout.PREFERRED_SIZE, 100, javax.swing.GroupLayout.PREFERRED_SIZE)
                .addGap(18, 18, 18)
                .addComponent(btnSortir)
                .addContainerGap())
        );
        jPanel1Layout.setVerticalGroup(
            jPanel1Layout.createParallelGroup(javax.swing.GroupLayout.Alignment.LEADING)
            .addGroup(jPanel1Layout.createSequentialGroup()
                .addGroup(jPanel1Layout.createParallelGroup(javax.swing.GroupLayout.Alignment.TRAILING, false)
                    .addComponent(jLabel1, javax.swing.GroupLayout.PREFERRED_SIZE, 50, javax.swing.GroupLayout.PREFERRED_SIZE)
                    .addGroup(javax.swing.GroupLayout.Alignment.LEADING, jPanel1Layout.createSequentialGroup()
                        .addContainerGap()
                        .addGroup(jPanel1Layout.createParallelGroup(javax.swing.GroupLayout.Alignment.TRAILING)
                            .addComponent(btnRollback, javax.swing.GroupLayout.DEFAULT_SIZE, javax.swing.GroupLayout.DEFAULT_SIZE, Short.MAX_VALUE)
                            .addComponent(btnSortir, javax.swing.GroupLayout.DEFAULT_SIZE, javax.swing.GroupLayout.DEFAULT_SIZE, Short.MAX_VALUE)
                            .addComponent(btnCommit, javax.swing.GroupLayout.Alignment.LEADING, javax.swing.GroupLayout.DEFAULT_SIZE, javax.swing.GroupLayout.DEFAULT_SIZE, Short.MAX_VALUE))
                        .addGap(8, 8, 8)))
                .addGap(0, 0, Short.MAX_VALUE))
        );

        llistaCompanies.setFont(new java.awt.Font("Tahoma", 0, 14)); // NOI18N
        llistaCompanies.setSelectionMode(javax.swing.ListSelectionModel.SINGLE_SELECTION);
        jScrollPane1.setViewportView(llistaCompanies);

        btnAfegirCompany.setFont(new java.awt.Font("Tahoma", 1, 14)); // NOI18N
        btnAfegirCompany.setText("Afegir company");

        btnEliminarCompany.setFont(new java.awt.Font("Tahoma", 1, 14)); // NOI18N
        btnEliminarCompany.setText("Eliminar company");
        btnEliminarCompany.addActionListener(new java.awt.event.ActionListener() {
            public void actionPerformed(java.awt.event.ActionEvent evt) {
                btnEliminarCompanyActionPerformed(evt);
            }
        });

        javax.swing.GroupLayout jPanel2Layout = new javax.swing.GroupLayout(jPanel2);
        jPanel2.setLayout(jPanel2Layout);
        jPanel2Layout.setHorizontalGroup(
            jPanel2Layout.createParallelGroup(javax.swing.GroupLayout.Alignment.LEADING)
            .addGroup(jPanel2Layout.createSequentialGroup()
                .addContainerGap()
                .addGroup(jPanel2Layout.createParallelGroup(javax.swing.GroupLayout.Alignment.LEADING)
                    .addComponent(btnAfegirCompany, javax.swing.GroupLayout.DEFAULT_SIZE, javax.swing.GroupLayout.DEFAULT_SIZE, Short.MAX_VALUE)
                    .addComponent(btnEliminarCompany, javax.swing.GroupLayout.DEFAULT_SIZE, 180, Short.MAX_VALUE)
                    .addComponent(jScrollPane1, javax.swing.GroupLayout.PREFERRED_SIZE, 0, Short.MAX_VALUE))
                .addContainerGap())
        );
        jPanel2Layout.setVerticalGroup(
            jPanel2Layout.createParallelGroup(javax.swing.GroupLayout.Alignment.LEADING)
            .addGroup(jPanel2Layout.createSequentialGroup()
                .addContainerGap()
                .addComponent(jScrollPane1, javax.swing.GroupLayout.PREFERRED_SIZE, 347, javax.swing.GroupLayout.PREFERRED_SIZE)
                .addPreferredGap(javax.swing.LayoutStyle.ComponentPlacement.RELATED, 83, Short.MAX_VALUE)
                .addComponent(btnEliminarCompany, javax.swing.GroupLayout.PREFERRED_SIZE, 35, javax.swing.GroupLayout.PREFERRED_SIZE)
                .addPreferredGap(javax.swing.LayoutStyle.ComponentPlacement.RELATED)
                .addComponent(btnAfegirCompany, javax.swing.GroupLayout.PREFERRED_SIZE, 35, javax.swing.GroupLayout.PREFERRED_SIZE)
                .addContainerGap())
        );

        lblCompanySel.setFont(new java.awt.Font("Tahoma", 1, 18)); // NOI18N
        lblCompanySel.setText("Cap company selecccionada");

        jLabel3.setFont(new java.awt.Font("Tahoma", 1, 14)); // NOI18N
        jLabel3.setText("Company name");

        jLabel4.setFont(new java.awt.Font("Tahoma", 1, 14)); // NOI18N
        jLabel4.setText("CIF");

        jLabel5.setFont(new java.awt.Font("Tahoma", 1, 14)); // NOI18N
        jLabel5.setText("Username");

        jLabel6.setFont(new java.awt.Font("Tahoma", 1, 14)); // NOI18N
        jLabel6.setText("Adreça");

        jLabel7.setFont(new java.awt.Font("Tahoma", 1, 14)); // NOI18N
        jLabel7.setText("Correu");

        btnModificarCompany.setFont(new java.awt.Font("Tahoma", 1, 14)); // NOI18N
        btnModificarCompany.setText("Modificar company");
        btnModificarCompany.addActionListener(new java.awt.event.ActionListener() {
            public void actionPerformed(java.awt.event.ActionEvent evt) {
                btnModificarCompanyActionPerformed(evt);
            }
        });

        jLabel8.setFont(new java.awt.Font("Tahoma", 1, 18)); // NOI18N
        jLabel8.setText("Activities");

        llistaActivities.setFont(new java.awt.Font("Tahoma", 0, 14)); // NOI18N
        llistaActivities.setSelectionMode(javax.swing.ListSelectionModel.SINGLE_SELECTION);
        jScrollPane2.setViewportView(llistaActivities);

        btnEliminarActivity.setFont(new java.awt.Font("Tahoma", 1, 14)); // NOI18N
        btnEliminarActivity.setText("Eliminar activity");
        btnEliminarActivity.addActionListener(new java.awt.event.ActionListener() {
            public void actionPerformed(java.awt.event.ActionEvent evt) {
                btnEliminarActivityActionPerformed(evt);
            }
        });

        btnAfegirActivity.setFont(new java.awt.Font("Tahoma", 1, 14)); // NOI18N
        btnAfegirActivity.setText("Afegir activity");

        lblCifInfo.setFont(new java.awt.Font("Tahoma", 0, 14)); // NOI18N
        lblCifInfo.setText("---");

        lblNameInfo.setFont(new java.awt.Font("Tahoma", 0, 14)); // NOI18N
        lblNameInfo.setText("---");

        lblUsernameInfo.setFont(new java.awt.Font("Tahoma", 0, 14)); // NOI18N
        lblUsernameInfo.setText("---");

        lblAddressInfo.setFont(new java.awt.Font("Tahoma", 0, 14)); // NOI18N
        lblAddressInfo.setText("---");

        lblCorreuInfo.setFont(new java.awt.Font("Tahoma", 0, 14)); // NOI18N
        lblCorreuInfo.setText("---");

        javax.swing.GroupLayout jPanel3Layout = new javax.swing.GroupLayout(jPanel3);
        jPanel3.setLayout(jPanel3Layout);
        jPanel3Layout.setHorizontalGroup(
            jPanel3Layout.createParallelGroup(javax.swing.GroupLayout.Alignment.LEADING)
            .addGroup(jPanel3Layout.createSequentialGroup()
                .addContainerGap()
                .addGroup(jPanel3Layout.createParallelGroup(javax.swing.GroupLayout.Alignment.LEADING)
                    .addComponent(lblCompanySel, javax.swing.GroupLayout.DEFAULT_SIZE, javax.swing.GroupLayout.DEFAULT_SIZE, Short.MAX_VALUE)
                    .addComponent(jScrollPane2)
                    .addGroup(jPanel3Layout.createSequentialGroup()
                        .addGroup(jPanel3Layout.createParallelGroup(javax.swing.GroupLayout.Alignment.LEADING)
                            .addGroup(jPanel3Layout.createParallelGroup(javax.swing.GroupLayout.Alignment.TRAILING, false)
                                .addComponent(jLabel8, javax.swing.GroupLayout.Alignment.LEADING, javax.swing.GroupLayout.DEFAULT_SIZE, javax.swing.GroupLayout.DEFAULT_SIZE, Short.MAX_VALUE)
                                .addComponent(jLabel3, javax.swing.GroupLayout.Alignment.LEADING, javax.swing.GroupLayout.DEFAULT_SIZE, javax.swing.GroupLayout.DEFAULT_SIZE, Short.MAX_VALUE)
                                .addComponent(jLabel4, javax.swing.GroupLayout.Alignment.LEADING, javax.swing.GroupLayout.DEFAULT_SIZE, javax.swing.GroupLayout.DEFAULT_SIZE, Short.MAX_VALUE)
                                .addComponent(jLabel5, javax.swing.GroupLayout.Alignment.LEADING, javax.swing.GroupLayout.DEFAULT_SIZE, javax.swing.GroupLayout.DEFAULT_SIZE, Short.MAX_VALUE)
                                .addComponent(jLabel7, javax.swing.GroupLayout.Alignment.LEADING, javax.swing.GroupLayout.DEFAULT_SIZE, javax.swing.GroupLayout.DEFAULT_SIZE, Short.MAX_VALUE))
                            .addComponent(jLabel6, javax.swing.GroupLayout.PREFERRED_SIZE, 160, javax.swing.GroupLayout.PREFERRED_SIZE))
                        .addPreferredGap(javax.swing.LayoutStyle.ComponentPlacement.RELATED)
                        .addGroup(jPanel3Layout.createParallelGroup(javax.swing.GroupLayout.Alignment.LEADING)
                            .addComponent(lblCifInfo, javax.swing.GroupLayout.DEFAULT_SIZE, javax.swing.GroupLayout.DEFAULT_SIZE, Short.MAX_VALUE)
                            .addComponent(lblNameInfo, javax.swing.GroupLayout.DEFAULT_SIZE, javax.swing.GroupLayout.DEFAULT_SIZE, Short.MAX_VALUE)
                            .addComponent(lblUsernameInfo, javax.swing.GroupLayout.DEFAULT_SIZE, javax.swing.GroupLayout.DEFAULT_SIZE, Short.MAX_VALUE)
                            .addComponent(lblAddressInfo, javax.swing.GroupLayout.DEFAULT_SIZE, javax.swing.GroupLayout.DEFAULT_SIZE, Short.MAX_VALUE)
                            .addComponent(lblCorreuInfo, javax.swing.GroupLayout.DEFAULT_SIZE, javax.swing.GroupLayout.DEFAULT_SIZE, Short.MAX_VALUE)))
                    .addGroup(jPanel3Layout.createSequentialGroup()
                        .addGroup(jPanel3Layout.createParallelGroup(javax.swing.GroupLayout.Alignment.LEADING)
                            .addGroup(jPanel3Layout.createSequentialGroup()
                                .addComponent(btnEliminarActivity, javax.swing.GroupLayout.PREFERRED_SIZE, 302, javax.swing.GroupLayout.PREFERRED_SIZE)
                                .addGap(18, 18, 18)
                                .addComponent(btnAfegirActivity, javax.swing.GroupLayout.PREFERRED_SIZE, 302, javax.swing.GroupLayout.PREFERRED_SIZE))
                            .addComponent(btnModificarCompany, javax.swing.GroupLayout.PREFERRED_SIZE, 200, javax.swing.GroupLayout.PREFERRED_SIZE))
                        .addGap(0, 0, Short.MAX_VALUE)))
                .addContainerGap())
        );
        jPanel3Layout.setVerticalGroup(
            jPanel3Layout.createParallelGroup(javax.swing.GroupLayout.Alignment.LEADING)
            .addGroup(jPanel3Layout.createSequentialGroup()
                .addContainerGap()
                .addComponent(lblCompanySel, javax.swing.GroupLayout.PREFERRED_SIZE, 30, javax.swing.GroupLayout.PREFERRED_SIZE)
                .addGap(18, 18, 18)
                .addGroup(jPanel3Layout.createParallelGroup(javax.swing.GroupLayout.Alignment.LEADING, false)
                    .addComponent(jLabel3, javax.swing.GroupLayout.DEFAULT_SIZE, 30, Short.MAX_VALUE)
                    .addComponent(lblNameInfo, javax.swing.GroupLayout.DEFAULT_SIZE, javax.swing.GroupLayout.DEFAULT_SIZE, Short.MAX_VALUE))
                .addGap(18, 18, 18)
                .addGroup(jPanel3Layout.createParallelGroup(javax.swing.GroupLayout.Alignment.LEADING, false)
                    .addComponent(lblCifInfo, javax.swing.GroupLayout.DEFAULT_SIZE, javax.swing.GroupLayout.DEFAULT_SIZE, Short.MAX_VALUE)
                    .addComponent(jLabel4, javax.swing.GroupLayout.DEFAULT_SIZE, 30, Short.MAX_VALUE))
                .addGap(18, 18, 18)
                .addGroup(jPanel3Layout.createParallelGroup(javax.swing.GroupLayout.Alignment.LEADING, false)
                    .addComponent(lblUsernameInfo, javax.swing.GroupLayout.DEFAULT_SIZE, javax.swing.GroupLayout.DEFAULT_SIZE, Short.MAX_VALUE)
                    .addComponent(jLabel5, javax.swing.GroupLayout.DEFAULT_SIZE, 30, Short.MAX_VALUE))
                .addGap(18, 18, 18)
                .addGroup(jPanel3Layout.createParallelGroup(javax.swing.GroupLayout.Alignment.LEADING, false)
                    .addComponent(lblAddressInfo, javax.swing.GroupLayout.DEFAULT_SIZE, javax.swing.GroupLayout.DEFAULT_SIZE, Short.MAX_VALUE)
                    .addComponent(jLabel6, javax.swing.GroupLayout.DEFAULT_SIZE, 30, Short.MAX_VALUE))
                .addGap(18, 18, 18)
                .addGroup(jPanel3Layout.createParallelGroup(javax.swing.GroupLayout.Alignment.LEADING, false)
                    .addComponent(jLabel7, javax.swing.GroupLayout.DEFAULT_SIZE, 30, Short.MAX_VALUE)
                    .addComponent(lblCorreuInfo, javax.swing.GroupLayout.DEFAULT_SIZE, javax.swing.GroupLayout.DEFAULT_SIZE, Short.MAX_VALUE))
                .addGap(42, 42, 42)
                .addComponent(btnModificarCompany, javax.swing.GroupLayout.PREFERRED_SIZE, 35, javax.swing.GroupLayout.PREFERRED_SIZE)
                .addPreferredGap(javax.swing.LayoutStyle.ComponentPlacement.RELATED)
                .addComponent(jLabel8, javax.swing.GroupLayout.PREFERRED_SIZE, 30, javax.swing.GroupLayout.PREFERRED_SIZE)
                .addPreferredGap(javax.swing.LayoutStyle.ComponentPlacement.RELATED)
                .addComponent(jScrollPane2, javax.swing.GroupLayout.PREFERRED_SIZE, 74, javax.swing.GroupLayout.PREFERRED_SIZE)
                .addPreferredGap(javax.swing.LayoutStyle.ComponentPlacement.RELATED, 8, Short.MAX_VALUE)
                .addGroup(jPanel3Layout.createParallelGroup(javax.swing.GroupLayout.Alignment.LEADING, false)
                    .addComponent(btnAfegirActivity, javax.swing.GroupLayout.DEFAULT_SIZE, javax.swing.GroupLayout.DEFAULT_SIZE, Short.MAX_VALUE)
                    .addComponent(btnEliminarActivity, javax.swing.GroupLayout.DEFAULT_SIZE, 35, Short.MAX_VALUE))
                .addContainerGap())
        );

        javax.swing.GroupLayout layout = new javax.swing.GroupLayout(getContentPane());
        getContentPane().setLayout(layout);
        layout.setHorizontalGroup(
            layout.createParallelGroup(javax.swing.GroupLayout.Alignment.LEADING)
            .addComponent(jPanel1, javax.swing.GroupLayout.DEFAULT_SIZE, javax.swing.GroupLayout.DEFAULT_SIZE, Short.MAX_VALUE)
            .addGroup(layout.createSequentialGroup()
                .addContainerGap()
                .addComponent(jSeparator1)
                .addContainerGap())
            .addGroup(layout.createSequentialGroup()
                .addComponent(jPanel2, javax.swing.GroupLayout.PREFERRED_SIZE, javax.swing.GroupLayout.DEFAULT_SIZE, javax.swing.GroupLayout.PREFERRED_SIZE)
                .addPreferredGap(javax.swing.LayoutStyle.ComponentPlacement.RELATED)
                .addComponent(jPanel3, javax.swing.GroupLayout.DEFAULT_SIZE, javax.swing.GroupLayout.DEFAULT_SIZE, Short.MAX_VALUE))
        );
        layout.setVerticalGroup(
            layout.createParallelGroup(javax.swing.GroupLayout.Alignment.LEADING)
            .addGroup(layout.createSequentialGroup()
                .addComponent(jPanel1, javax.swing.GroupLayout.PREFERRED_SIZE, javax.swing.GroupLayout.DEFAULT_SIZE, javax.swing.GroupLayout.PREFERRED_SIZE)
                .addPreferredGap(javax.swing.LayoutStyle.ComponentPlacement.RELATED)
                .addComponent(jSeparator1, javax.swing.GroupLayout.PREFERRED_SIZE, 10, javax.swing.GroupLayout.PREFERRED_SIZE)
                .addPreferredGap(javax.swing.LayoutStyle.ComponentPlacement.RELATED)
                .addGroup(layout.createParallelGroup(javax.swing.GroupLayout.Alignment.LEADING)
                    .addComponent(jPanel2, javax.swing.GroupLayout.DEFAULT_SIZE, javax.swing.GroupLayout.DEFAULT_SIZE, Short.MAX_VALUE)
                    .addComponent(jPanel3, javax.swing.GroupLayout.DEFAULT_SIZE, javax.swing.GroupLayout.DEFAULT_SIZE, Short.MAX_VALUE)))
        );

        pack();
        setLocationRelativeTo(null);
    }// </editor-fold>//GEN-END:initComponents

    private void btnModificarCompanyActionPerformed(java.awt.event.ActionEvent evt) {//GEN-FIRST:event_btnModificarCompanyActionPerformed
        // TODO add your handling code here:
    }//GEN-LAST:event_btnModificarCompanyActionPerformed

    private void btnEliminarCompanyActionPerformed(java.awt.event.ActionEvent evt) {//GEN-FIRST:event_btnEliminarCompanyActionPerformed
        // TODO add your handling code here:
    }//GEN-LAST:event_btnEliminarCompanyActionPerformed

    private void btnEliminarActivityActionPerformed(java.awt.event.ActionEvent evt) {//GEN-FIRST:event_btnEliminarActivityActionPerformed
        // TODO add your handling code here:
    }//GEN-LAST:event_btnEliminarActivityActionPerformed

    // Variables declaration - do not modify//GEN-BEGIN:variables
    private javax.swing.JButton btnAfegirActivity;
    private javax.swing.JButton btnAfegirCompany;
    private javax.swing.JButton btnCommit;
    private javax.swing.JButton btnEliminarActivity;
    private javax.swing.JButton btnEliminarCompany;
    private javax.swing.JButton btnModificarCompany;
    private javax.swing.JButton btnRollback;
    private javax.swing.JButton btnSortir;
    private javax.swing.JLabel jLabel1;
    private javax.swing.JLabel jLabel3;
    private javax.swing.JLabel jLabel4;
    private javax.swing.JLabel jLabel5;
    private javax.swing.JLabel jLabel6;
    private javax.swing.JLabel jLabel7;
    private javax.swing.JLabel jLabel8;
    private javax.swing.JPanel jPanel1;
    private javax.swing.JPanel jPanel2;
    private javax.swing.JPanel jPanel3;
    private javax.swing.JScrollPane jScrollPane1;
    private javax.swing.JScrollPane jScrollPane2;
    private javax.swing.JSeparator jSeparator1;
    private javax.swing.JLabel lblAddressInfo;
    private javax.swing.JLabel lblCifInfo;
    private javax.swing.JLabel lblCompanySel;
    private javax.swing.JLabel lblCorreuInfo;
    private javax.swing.JLabel lblNameInfo;
    private javax.swing.JLabel lblUsernameInfo;
    private javax.swing.JList<String> llistaActivities;
    private javax.swing.JList<String> llistaCompanies;
    // End of variables declaration//GEN-END:variables
}
