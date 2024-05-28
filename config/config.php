<?php
try{
    ///host
    if(!defined('HOSTNAME')) define('HOSTNAME', 'localhost');
    
    ///dbname
    if(!defined('DBNAME')) define('DBNAME','homeland');

    ///user
    if(!defined('USER')) define('USER', 'root');

    ///password
    if(!defined('PASS')) define('PASS','');

    $conn = new PDO("mysql:host=".HOSTNAME.";dbname=".DBNAME.";",USER,PASS);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    /*if($conn == true){
        echo "Connected";
    }else{
        echo "Not Connected";
    }*/
}catch(PDOException $e){
    die("ERROR: Could not connect.  " . $e->getMessage());
}
?>
