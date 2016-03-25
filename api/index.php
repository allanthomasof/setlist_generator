<?php
require 'vendor/autoload.php';
require 'database/ConnectionFactory.php';
require 'database/SetlistGeneratorService.php';
require 'database/notorm/NotORM.php';

$app = new \Slim\Slim();


//ADD A SINGLE MUSIC
$app->post('/addMusic/', function() use ( $app ) {
	$musicJson = $app->request()->getBody();
	$musicJson = json_decode($musicJson, true);

    if($musicJson) {
        $musicJson = SetlistGeneratorService::add($musicJson);
        echo $musicJson['name'];
    }
    else {
        $app->response->setStatus(400);
        echo "Malformat JSON";
    }
});


//RETURNS A FULL SETLIST
$app->get('/fullSetlist/', function() use ( $app ) {
    $setlist = SetlistGeneratorService::getFullSetlist();
    $app->response()->header('Content-Type', 'application/json');
    echo json_encode($setlist);
});


//RETURNS A INTERNATIONAL SETLIST SHUFFLE
$app->get('/internationalSetlist', function() use ( $app ) {
    $consulta = $conexao_pdo->prepare("SELECT * FROM setlist WHERE origin = 'international'");
	$consulta->execute();
	$result = $consulta;
	while($row = $result->fetch(PDO::FETCH_ASSOC)){
		$indexedOnly[] = $row;
	}
	shuffle($indexedOnly);
	echo json_encode($indexedOnly);
});


$app->run();
?>