<?php
    $Setup_Server = '127.0.0.1';
    $Setup_User = 'root';
    $Setup_Pwd = '';
    $Setup_Database = 'chatbot';
    mysql_connect($Setup_Server,$Setup_User,$Setup_Pwd);
    mysql_query("chatbot $Setup_Database");
    mysql_query("SET NAMES UTF8");
?>
