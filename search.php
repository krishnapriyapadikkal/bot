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


while (true) {

$query = "";
try{
       $pdo->beginTransaction();
  
	foreach($pdo->query('SELECT search,chat_id from askme where status=0 order by id limit 1') as $row) {
        	$query = $row['search'];
		$chat_id=$row['chat_id'];
   	}
	//$link = mysqli_connect("localhost", "kk", "kpp", "bot");
	//$sql = "SELECT search FROM askme order by id limit 1";

	//$result = mysqli_query($link,$sql);
	//if ($result !== false) {
    	//	$value = mysqli_fetch_field($result);
	//}
	
        $pdo->commit();
   }

catch (Exception $e){
	$pdo->rollback();
        throw $e;
   }
        

while($query!="" || $query!=NULL){
//$query = $value->search;

echo "query".$query;

$url ="https://api.cognitive.microsoft.com/bing/v5.0/search?q=".urlencode($query)."&mkt=en-in";

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_HTTPHEADER, array('Ocp-Apim-Subscription-Key: e47ff5b6315c4d309f2473bf65b2aaef'));      
	$body = curl_exec($ch);
        curl_close($ch);


$json = json_decode($body,true);

//print_r($json['webPages']['value']);

$len=count($json['webPages']['value']);

echo $len;

for($x=0;$x<3;$x++){
try{
	
	echo "<b>Result ".($x+1)."</b>";
	echo "<br>URL: ";
	echo $json['webPages']['value'][$x]['url'];
	echo "<br>VisibleURL: ";
	echo $json['webPages']['value'][$x]['displayUrl'];
	$displayUrl=$json['webPages']['value'][$x]['displayUrl'];
	echo "<br>Title: ";
	echo $json['webPages']['value'][$x]['name'];
	$name=$json['webPages']['value'][$x]['name'];
	echo "<br>Content: ";
	echo $json['webPages']['value'][$x]['snippet'];
	$snippet=$json['webPages']['value'][$x]['snippet'];

	echo "<br><br>";
	$pdo->beginTransaction();
	$stmt=$pdo->prepare("INSERT INTO result (chat_id,url,title,snippet,sortorder) VALUES (?,?,?,?,?)");
	$stmt->execute([$chat_id,$displayUrl,$name,$snippet,$x]);
	$pdo->commit();
	}
	catch(exception $e)
	{	$pdo->rollback();
		throw $e;
	}
   }
$status=1;
try {
       $pdo->beginTransaction();
     $stmt=$pdo->prepare("UPDATE askme SET status=1 WHERE search = :search LIMIT 1");
        $stmt->bindValue(":search",$query);
	$stmt->execute();   
	$pdo->commit();
           }
        catch (Exception $e){
           $pdo->rollback();
           throw $e;
         }
echo "query".$query."status".$status;
$query=NULL;
}
}
?>
