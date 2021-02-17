<?php
function tn_uas_sanitize($text){
    return str_replace("-", "", sanitize_title_with_dashes($text));
}
?>