<?php

    require("config.php");

    if (isset($_POST["flag"])){

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