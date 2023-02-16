<?php 
session_start();
require_once("vendor/autoload.php");
use \Hcode\Page;
use \Hcode\PageAdmin;
use \Hcode\Model\User;

$app = new \Slim\Slim();

$app->config('debug', true);

$app->get('/', function() {
    $page = new Page();

	$page->setTpl("index");
	

});
$app->get('/admin', function() {
    User::verifyLogin();
    $pageAdmin = new PageAdmin();

	$pageAdmin->setTpl("index");
	


});
$app->get('/admin/login', function() {
    $pageAdmin = new PageAdmin([
        "header"=>false,
        "footer"=>false
    ]);

	$pageAdmin->setTpl("login");

	

});
$app->post('/admin/login', function() {
   User::login($_POST['login'],$_POST['password']);
   header("location: ../admin");
   exit;

});

$app->get('/admin/logout',function ()
{
   User::logOut(); 
});

$app->run();

 ?>