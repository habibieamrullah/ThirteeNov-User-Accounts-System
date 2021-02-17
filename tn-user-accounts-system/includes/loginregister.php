<?php

include("config.php");

$tn_user_logedin = true;
$sql = "SELECT * FROM $tn_uas_tableformfields WHERE fieldlogreg = 1";
$result = mysqli_query($wpdb->dbh, $sql);
$rowcount = mysqli_num_rows($result);
if($rowcount > 0){
    while($row = mysqli_fetch_assoc($result)){
        $fieldnamedashed = tn_uas_sanitize($row["fieldname"]);
        if(!isset($_SESSION[$fieldnamedashed])){
            $tn_user_logedin = false;
            break;
        }
    }
}

if($tn_user_logedin){
    ?>
    <p>You are already loged in :D</p>
    <?php
}else{
    if(isset($_POST["tn-user-register"])){
    
        $sql = "SELECT * FROM $tn_uas_tableformfields";
        $result = mysqli_query($wpdb->dbh, $sql);
        $rowcount = mysqli_num_rows($result);
        $currentrow = 1;
        $columnstoinsert = "(";
        $datatoinsert = "(";
        
        while($row = mysqli_fetch_assoc($result)){
            $fieldnamedashed = tn_uas_sanitize($row["fieldname"]);
            if(isset($_POST[$fieldnamedashed])){
                $postcontent = $_POST[$fieldnamedashed];
                //echo $row["fieldname"] .  " Submited = " . $_POST[tn_uas_sanitize($row["fieldname"])];
                if(!mysqli_query($wpdb->dbh, "SELECT $fieldname FROM $tn_uas_useraccounts")){
                    mysqli_query($wpdb->dbh, "ALTER TABLE $tn_uas_useraccounts ADD $fieldnamedashed VARCHAR(500) NOT NULL");
                }
                $columnstoinsert .= $fieldnamedashed;
                $datatoinsert .= "'" . $postcontent . "'";
                if($currentrow < $rowcount){
                    $columnstoinsert .= ",";
                $datatoinsert .= ",";
                }
                $currentrow++;
            }
        }
        $columnstoinsert .= ")";
        $datatoinsert .= ")";
        $sql = "INSERT INTO $tn_uas_useraccounts " . $columnstoinsert . " VALUES " . $datatoinsert;
        //echo $sql;
        mysqli_query($wpdb->dbh, $sql);
        
        ?>
        <p>Registered!</p>
        <?php
        
    }else if(isset($_POST["tn-user-login"])){
        
        $sql = "SELECT * FROM $tn_uas_tableformfields WHERE fieldlogreg = 1";
        $result = mysqli_query($wpdb->dbh, $sql);
        $loginquery = "";
        $rowcount = mysqli_num_rows($result);
        $currentrow = 1;
        
        while($row = mysqli_fetch_assoc($result)){
            $fieldnamedashed = tn_uas_sanitize($row["fieldname"]);
            if(isset($_POST[$fieldnamedashed])){
                $postcontent = $_POST[$fieldnamedashed];
                $loginquery .= $fieldnamedashed . " = '" . $postcontent . "'";     
                if($currentrow < $rowcount){
                    $loginquery .= " AND ";
                }
                $currentrow++;
            }
        }
        
        $sql = "SELECT * FROM $tn_uas_useraccounts WHERE " . $loginquery;
        //echo $sql;
        
        if(mysqli_num_rows(mysqli_query($wpdb->dbh, $sql)) > 0){
            
            echo "<p>Login Success!</p>";
            
            $sql = "SELECT * FROM $tn_uas_tableformfields WHERE fieldlogreg = 1";
            $result = mysqli_query($wpdb->dbh, $sql);
            
            while($row = mysqli_fetch_assoc($result)){
                $fieldnamedashed = tn_uas_sanitize($row["fieldname"]);
                $_SESSION[$fieldnamedashed] = $_POST[$fieldnamedashed];
                
            }

            
        }else{
            echo "<p>Invalid login!</p>";
        }
        
        ?>
        <?php
    }else{
        ?>
        <div class="logregpage" id="loginpage">
            <h2>Login</h2>
            <form method="post">
                <?php
                $sql = "SELECT * FROM $tn_uas_tableformfields";
                $result = mysqli_query($wpdb->dbh, $sql);
                if($result){
                    if(mysqli_num_rows($result) > 0){
                        while($row = mysqli_fetch_assoc($result)){
                        if($row["fieldlogreg"] == 1){
                            ?>
                            <label><?php echo $row["fieldname"] ?></label>
                            <?php
                            switch($row["fieldtype"]){
                                case 0 :
                                    ?>
                                    <input type="text" name="<?php echo tn_uas_sanitize($row["fieldname"]) ?>">
                                    <?php
                                    break;
                                case 1 :
                                    ?>
                                    <input type="number" name="<?php echo tn_uas_sanitize($row["fieldname"]) ?>">
                                    <?php
                                    break;
                                case 2 :
                                    ?>
                                    <input type="email" name="<?php echo tn_uas_sanitize($row["fieldname"]) ?>">
                                    <?php
                                    break;
                                case 3 :
                                    ?>
                                    <input type="password" name="<?php echo tn_uas_sanitize($row["fieldname"]) ?>">
                                    <?php
                                    break;
                            }
                        }
                    }
                    }
                }
                ?>
                <input name="tn-user-login" type="submit" value="Login">
            </form>
            <p>Don't have account yet? Click <a onclick="showregister()">here</a> to register.</p>
        </div>
        
        <div class="logregpage" id="registerpage" style="display: none;">
            <h2>Register</h2>
            <form method="post">
                <?php
                $sql = "SELECT * FROM $tn_uas_tableformfields";
                $result = mysqli_query($wpdb->dbh, $sql);
                if($result){
                    if(mysqli_num_rows($result) > 0){
                        while($row = mysqli_fetch_assoc($result)){
                            ?>
                            <label><?php echo $row["fieldname"] ?></label>
                            <?php
                            switch($row["fieldtype"]){
                                case 0 :
                                    ?>
                                    <input type="text" name="<?php echo tn_uas_sanitize($row["fieldname"]) ?>">
                                    <?php
                                    break;
                                case 1 :
                                    ?>
                                    <input type="number" name="<?php echo tn_uas_sanitize($row["fieldname"]) ?>">
                                    <?php
                                    break;
                                case 2 :
                                    ?>
                                    <input type="email" name="<?php echo tn_uas_sanitize($row["fieldname"]) ?>">
                                    <?php
                                    break;
                                case 3 :
                                    ?>
                                    <input type="password" name="<?php echo tn_uas_sanitize($row["fieldname"]) ?>">
                                    <?php
                                    break;
                            }
                        }
                    }
                }
                ?>
                <input name="tn-user-register" type="submit" value="Register">
            </form>
            <p>Already registered? Click <a onclick="showlogin()">here</a> to login.</p>
        </div>
        
        <script>
            function showlogin(){
                jQuery(".logregpage").hide();
                jQuery("#loginpage").show();
            }
            
            function showregister(){
                jQuery(".logregpage").hide();
                jQuery("#registerpage").show();
            }
        </script>
        <?php
        
    }
}

?>