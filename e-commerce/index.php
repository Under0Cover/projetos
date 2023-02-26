<?php

use DB\Sql;

require_once("vendor/autoload.php");

$app = new \Slim\Slim();

$app->config('debug', true);

$app->get('/', function() {
    
	echo "OK, viu";
	$sql = new Sql();

	$results = $sql->select("SELECT * FROM tb_users");

	echo json_encode($results);

});

$app->run();

 ?>