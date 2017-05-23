<?php


try {
    $conn = new PDO("mysql:host=localhost;dbname=bot", 'kpp', 'krishnapriya');
  
    }
catch(PDOException $e)
    {
    echo  "error:" . $e->getMessage();
	exit();
    }

 


?>
