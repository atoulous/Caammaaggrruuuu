<?php
session_start();
include_once('config/database.php');
if (!$db_exist)
	include_once('config/setup.php');
include_once('views/header.php');
