<?php
    include("config.php");
    if(!get_option("tn_uas_loginregisterpage")){
        add_option("tn_uas_loginregisterpage", "");
    }
    if(!get_option("tn_uas_dashboardpage")){
        add_option("tn_uas_dashboardpage", "");
    }
?>

<div class="wrap">
    <h1>User Accounts Management General Settings</h1>
    <p>Configure how the plugin should work.</p>
    
    <div class="admin_white_box">
        <h2>URL Configurations</h2>
        <?php
        if(isset($_POST["tn_uas_loginregisterpage"])){
            update_option("tn_uas_loginregisterpage", esc_sql($_POST["tn_uas_loginregisterpage"]));
            update_option("tn_uas_dashboardpage", esc_sql($_POST["tn_uas_dashboardpage"]));
            echo "<p>Options has been updated...</p>";
        }
        ?>
        <form method="post">
            <label>User Login and Registration Page</label>
            <input name="tn_uas_loginregisterpage" value="<?php echo get_option("tn_uas_loginregisterpage") ?>">
            
            <label>User Dashboard Page</label>
            <input name="tn_uas_dashboardpage" value="<?php echo get_option("tn_uas_dashboardpage") ?>">
            
            <input type="submit" value="Save">
        </form>
    </div>
    
</div>