<?php
include("config.php");
$adminurl = admin_url() . "admin.php?page=tn-uas-formsettings";
?>

<div class="wrap">
    <h1>Login and Register Form Management</h1>
    <p>Here you can manage what information do you require your users to login or register.</p>
    
    <div class="admin_white_box">
        <h2>List of Login and Registration Fields</h2>
        <?php
        
        //Delete field
        if(isset($_GET["deletefield"])){
            $fieldid = esc_sql($_GET["deletefield"]);
            mysqli_query($wpdb->dbh, "DELETE FROM $tn_uas_tableformfields WHERE id = $fieldid");
        }
        
        //Insert new field
        if(isset($_POST["fieldname"])){
            $newfield = esc_sql($_POST["fieldname"]);
            $newfieldtype = esc_sql($_POST["fieldtype"]);
            $usedforlogin = esc_sql($_POST["requiredforlogin"]);
            $mustbeunique = esc_sql($_POST["mustbeunique"]);
            
            //input data
            mysqli_query($wpdb->dbh, "INSERT INTO $tn_uas_tableformfields (fieldname, fieldtype, fieldlogreg, mustbeunique) VALUES ('$newfield', $newfieldtype, $usedforlogin, $mustbeunique)");
        }
        
        //Check if result available
        $sql = "SELECT * FROM $tn_uas_tableformfields ORDER BY id ASC";
        $result = mysqli_query($wpdb->dbh, $sql);
        if(mysqli_num_rows($result) > 0){
            while($row = mysqli_fetch_assoc($result)){
                
                $type = "";
                switch($row["fieldtype"]){
                    case 0 :
                        $type = "Text";
                        break;
                    case 1 :
                        $type = "Number";
                        break;
                    case 2 :
                        $type = "Email";
                        break;
                    case 3 :
                        $type = "Password";
                        break;
                }
                
                $requiredforlogin = "No";
                if($row["fieldlogreg"] == 1)
                    $requiredforlogin = "Yes";
                
                $uniquefield = "No";
                if($row["mustbeunique"] == 1)
                    $uniquefield = "Yes";
                
                echo "<ul>";
                echo "<li><b>" . $row['fieldname'] . "</b> | Type = " . $type . ". Required for Login = " . $requiredforlogin . ". Must be Unique = " . $uniquefield . ". | [ <a href='" . $adminurl . "&deletefield=" .$row["id"]. "'>delete</a> ]</li>";
                echo "</ul>";
            }
        }else{
            echo "<p><i>No field has been added.</i></p>";
        }
        ?>
    </div>
    
    <div class="admin_white_box">
        <h3>Add new field</h3>
        <form method="post">
            <label>Field Name</label>
            <input name="fieldname">
            <label>Field Type</label>
            <select name="fieldtype">
                <option value=0>Text</option>
                    <option value=1>Number</option>
                    <option value=2>Email</option>
                    <option value=3>Password</option>
            </select>
            <label>Required for Login?</label>
            <select name="requiredforlogin">
                <option value=0>No</option>
                <option value=1>Yes</option>
            </select>
            <label>Must be unique between users?</label>
            <select name="mustbeunique">
                <option value=0>No</option>
                <option value=1>Yes</option>
            </select>
            <input type="submit" value="Add">
        </form>
    </div>
</div>