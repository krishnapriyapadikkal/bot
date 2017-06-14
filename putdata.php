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

function _isCurl()
   {
        return function_exists('curl_version');
   }

while(true){

$i=0;

while($i!=3){
        try{
       $pdo->beginTransaction();

        foreach($pdo->query('SELECT chat_id,url,title,snippet,status from result where status = 0 order by id limit 1') as $row) {
                $id=$row['chat_id'];
		$rurl=$row['url'];
		$rtitle=$row['title'];
		$rsnippet=$row['snippet'];
		$rstatus=$row['status'];
        }
       	
	echo "mid=".$id;
       $pdo->commit();
   }

catch (Exception $e){
        $pdo->rollback();
        throw $e;
   }

	echo "status=".$rstatus."\n";
	echo "url=".$rurl."\n";

if($rstatus==0)
    {
   
if (_iscurl()){
        $url = "https://api.telegram.org/bot391062433:AAE7lq0n8rIHBPKgqYiuzKELeRlmlBfcYd8/sendMessage?chat_id=".$id."&text=".urlencode($rtitle)."    ::".urlencode($rsnippet)."  .  . ".urlencode($rurl);
     
		
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $output = curl_exec($ch);
        curl_close($ch);

       
}

try {
       $pdo->beginTransaction();
       $stmt=$pdo->prepare("UPDATE result SET status=1 WHERE title = :title LIMIT 1");
       $stmt->bindValue(":title",$rtitle);
       $stmt->execute();
    
	$pdo->commit();
    }
catch (Exception $e){
       $pdo->rollback();
       throw $e;
    }
	$rstatus=1;
$i++;
}

}

}

?>

