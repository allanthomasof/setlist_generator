<?php
header('Access-Control-Allow-Origin: *');

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

//DELETA UMA MUSICA A PARTIR DE UM ID
$app->delete('/deleteMusic/:id', function($id) use ( $app ) {
    if(SetlistGeneratorService::delete($id)) {
        echo "excluiu";
    } else {
        echo $id;
    }  
});

//RETORNA O SET LIST COMPLETO ORDENADO POR NOME DE MUSICA
$app->get('/fullSetlist/', function() use ( $app ) {
    $setlist = SetlistGeneratorService::getFullSetlist();
    $app->response()->header('Content-Type', 'application/json');
    echo json_encode($setlist);
});

//RETORNA O SET LIST COMPLETO ORDENADO POR NOME DE MUSICA
$app->get('/fullSetlistShuffle/', function() use ( $app ) {
    $setlist = SetlistGeneratorService::getFullSetlist();
    $app->response()->header('Content-Type', 'application/json');
    shuffle($setlist);
    echo json_encode($setlist);
});



$app->run();
?>