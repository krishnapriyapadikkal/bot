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

$query = "";
try{
       $pdo->beginTransaction();
  
	foreach($pdo->query('SELECT search from askme order by id limit 1') as $row) {
        	$query = $row['search'];
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

/*
print_r($json);
*/

$len=count($json->webPages->value);

echo $len;

for($x=0;$x<$len+1;$x++){

	echo "<b>Result ".($x+1)."</b>";
	echo "<br>URL: ";
	echo $json->webPages->value[$x]->url;
	echo "<br>VisibleURL: ";
	echo $json->webPages->value[$x]->displayUrl;
	echo "<br>Title: ";
	echo $json->webPages->value[$x]->name;
	echo "<br>Content: ";
	echo $json->webPages->value[$x]->snippet;
	echo "<br><br>";

   }
/*
$pdo->beginTransaction();

$stmt = $pdo->prepare("DELETE FROM askme ORDER BY id LIMIT 1");
        $stmt->execute();
        $pdo->commit();
*/
?>
