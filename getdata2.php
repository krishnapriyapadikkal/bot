<?php



try{
$pdo=new PDO('mysql:host=localhost;dbname=bot','kk','kpp');
}
catch(PDOException $e)
{
 echo 'Error:' . $e->getMessage();
exit();
}
error_reporting(E_ERROR | E_WARNING | E_PARSE);  

 function _isCurl(){
        return function_exists('curl_version');
    }

while (true) {
  

    if (_iscurl()){
        $url = "https://api.telegram.org/bot391062433:AAE7lq0n8rIHBPKgqYiuzKELeRlmlBfcYd8/getUpdates?offset=";
	$id=755706114;
	
	$offset=$url.$id;
	  
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $offset);                               
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $output = curl_exec($ch);
        curl_close($ch);
        
        $x = json_decode($output, true);
        $len=count($x["result"]);
	

	
	
	$chat_id=0;
	 for($i=0;$i<$len+1;$i++){

	$chat_id=$x["result"][$i]["message"]["chat"]["id"];
	/*if(array_key_exists(["result"][$i],$chat_id=$x["result"][$i]["message"]["chat"]["id"]))*/	
	echo $chat_id;
        $msg=$x["result"][$i]["message"]["text"];
/*	if(array_key_exists($i,$msg))	
*/	echo $msg;
    
        $id=$id+1;

       try {
       $pdo->beginTransaction();
       $stmt = $pdo->prepare("INSERT INTO askme (chat_id,search) VALUES (?,?)");
          $stmt->execute([$chat_id,$msg]);
           $pdo->commit();
            }
        catch (Exception $e){
           $pdo->rollback();
           throw $e;
           }               
        }
    }

    else{
        echo "CURL is disabled";
    }
error_reporting(E_ALL & ~E_NOTICE);
}
?>
