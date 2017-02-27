<?php
session_start();
global $base_url;
$base_url = '/'.basename(__DIR__).'/';
include_once('config/db_install.php');

foreach (glob("controllers/*.php") as $file)
	include_once $file;

$url = explode('/', $_SERVER[REQUEST_URI]);
if (!$url[2] || $url[2] == "index.php")
	$home->index();
else
{
	if (!class_exists($url[2]))
	{
		header("HTTP/1.0 404 Not Found");
		require('views/404_view.php');
		exit;
	}
	else
	{
		if ($url[3])
		{
			if (method_exists($url[2], $url[3]))
				call_user_func(array($url[2], $url[3]), $url[4]);
			else
			{
				header("HTTP/1.0 404 Not Found");
				require('views/404_view.php');
				exit;
			}
		}
		else
			call_user_func(array($url[2], 'index'));
	}
}
