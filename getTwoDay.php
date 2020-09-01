<?php


if (isset($_POST["flag"])){
    $db = new PDO("mysql:host=127.0.0.1;dbname=meteorological", "root", "root");
    $db->exec("SET CHARACTER SET utf8");

    if ($_POST["flag"] == 0){
        $sth = $db->prepare("select * from twoDay where city = :city");
        $sth->bindParam("city", $_POST["city"], PDO::PARAM_STR,50);  
        $sth->execute();
        
        $twoDay = $sth->fetch();
        print_r(json_encode($twoDay));
    }else{
        $sth = $db->prepare("select * from twoDay where city = :city");
        $sth->bindParam("city", $_POST["city"], PDO::PARAM_STR,50);  
        $sth->execute();
    
        $twoDay = $sth->fetch();
        print_r(json_encode($twoDay));
    }

    $db = null;


}



?>