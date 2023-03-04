<?php

session_start();

require_once("vendor/autoload.php");

use Hcode\Page;
use Hcode\PageAdmin;
use Hcode\Model\User;
use Slim\Slim;

$app = new Slim();

$app->config('debug', true);

$app->get('/', function() {
    
	$page = new Page();
	$page->setTpl("index");

});

$app->get('/admin', function() {
    User::verifyLogin();

	$page = new PageAdmin();
	$page->setTpl("index");

});

$app->get('/admin/login', function(){
	
	$page = new PageAdmin([
		"header"=>false,
		"footer"=>false
	]);
	$page->setTpl("login");

});

$app->post('/admin/login', function(){
	User::login($_POST["login"], $_POST["password"]);

	header("Location: /admin");
	exit;
});

$app->get('/admin/logout', function(){
	User::logout();

	header("Location: /admin/login");
	exit;
});

$app->get("/admin/users", function(){
	User::verifyLogin();

	$users = User::listAll();

	$page = new PageAdmin();
	$page->setTpl("users", array(
		"users"	=>	$users
	));
});

$app->get("/admin/users/create", function(){
	User::verifyLogin();

	$page = new PageAdmin();
	$page->setTpl("users-create");
});

$app->get("/admin/user/:iduser/delete", function($iduser){
	User::verifyLogin();

});

$app->get("/admin/users/:iduser", function($iduser){
	User::verifyLogin();

	$page = new PageAdmin();
	$page->setTpl("users-update");
});

$app->post("/admin/user/create", function(){
	User::verifyLogin();

});

$app->post("/admin/user/:iduser", function($iduser){
	User::verifyLogin();

});

$app->run();

 ?>