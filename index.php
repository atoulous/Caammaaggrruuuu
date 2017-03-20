<?php
session_start();
global $base_url;
$base_url = '/'.basename(__DIR__).'/';
include_once('config/db_install.php');

foreach (glob("controllers/*.php") as $controller)
	include_once $controller;

$url = explode('/', $_SERVER[REQUEST_URI]);
if (method_exists($url[2], $url[3]))
	call_user_func(array($url[2], $url[3]));
else if (class_exists($url[2]) && !$url[3] && method_exists($url[2], 'index'))
		call_user_func(array($url[2], "index"));
else if (!$url[2] || $url[2] == "index.php")
	Home::index();
else
{
	header("HTTP/1.0 404 Not Found");
	require('views/404_view.php');
	exit;
}
