<?php

include("functions.php");

global $wpdb;
global $wp_session;

$tn_uas_tableprefix = $wpdb->prefix . "tn_uas_";
$tn_uas_tableformfields = $tn_uas_tableprefix . "formfields";
$tn_uas_useraccounts = $tn_uas_tableprefix . "useraccounts";

//Preparing form fields table
mysqli_query($wpdb->dbh, "CREATE TABLE IF NOT EXISTS $tn_uas_tableformfields (
id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY
)");

if(!mysqli_query($wpdb->dbh, "SELECT fieldname FROM $tn_uas_tableformfields")){
    mysqli_query($wpdb->dbh, "ALTER TABLE $tn_uas_tableformfields ADD fieldname VARCHAR(500) NOT NULL");
}
if(!mysqli_query($wpdb->dbh, "SELECT fieldtype FROM $tn_uas_tableformfields")){
    mysqli_query($wpdb->dbh, "ALTER TABLE $tn_uas_tableformfields ADD fieldtype INT(6) NOT NULL");
}
if(!mysqli_query($wpdb->dbh, "SELECT mustbeunique FROM $tn_uas_tableformfields")){
    mysqli_query($wpdb->dbh, "ALTER TABLE $tn_uas_tableformfields ADD mustbeunique INT(6) NOT NULL");
}
if(!mysqli_query($wpdb->dbh, "SELECT fieldlogreg FROM $tn_uas_tableformfields")){
    mysqli_query($wpdb->dbh, "ALTER TABLE $tn_uas_tableformfields ADD fieldlogreg INT(6) NOT NULL");
}

//Preparing user accounts table
mysqli_query($wpdb->dbh, "CREATE TABLE IF NOT EXISTS $tn_uas_useraccounts (
id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY
)");

?>
<script>
    console.log("Nice! ThirteeNov plugin is loaded :D");
</script>