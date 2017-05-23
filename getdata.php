<?php
/*try {
    $pdo = new PDO("mysql:host=localhost;dbname=bot", 'kpp', 'krishnapriya');

    }
catch(PDOException $e)
    {
    echo  "error:" . $e->getMessage();
        exit();
    }
*/
 function _isCurl(){
        return function_exists('curl_version');
    }    
    if (_iscurl()){
        $url = "https://api.telegram.org/bot391062433:AAE7lq0n8rIHBPKgqYiuzKELeRlmlBfcYd8/getUpdates";    
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);                               
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $output = curl_exec($ch);
        curl_close($ch);
        
        $x = json_decode($output, true);
        $len=count($x["result"]);
        
        for($i=0;$i<$len;$i++){
        $chat_id=$x["result"][$i]["message"]["chat"]["id"];
        $msg=$x["result"][$i]["message"]["text"];
        
        echo ' ';
        echo $chat_id; 
        echo ' ';
        echo $msg;         

/*try {
    $pdo->beginTransaction();
$stmt = $pdo->prepare("INSERT INTO askme (chat_id,search) VALUES (?,?)");
 $stmt->execute([$chat_id,$msg]);
        $pdo->commit();
}*/
/*catch (Exception $e){
   
    $pdo->rollback();
    throw $e;
}*/


}
    else{
        echo "CURL is disabled";
    }


?>

