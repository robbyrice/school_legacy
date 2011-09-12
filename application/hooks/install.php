<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

function init()
{
	$mysqli = new mysqli('localhost', 'instrck_admin', 'password');
	if($mysqli->query("SHOW DATABASES LIKE 'instrck_ibbl_app'")->num_rows === 0)
	{
		$mysqli->query("CREATE DATABASE `instrck_ibbl_app`");
	}
	$mysqli->select_db('instrck_ibbl_app');
	if($mysqli->query("SHOW TABLES LIKE 'ci_sessions'")->num_rows === 0)
	{
		$mysqli->query("CREATE TABLE `ci_sessions` (
				`session_id` varchar(40) NOT NULL default '0',
				`ip_address` varchar(16) NOT NULL default '0',
				`user_agent` varchar(120) NOT NULL,
				`last_activity` int(10) unsigned NOT NULL default '0',
				`user_data` text,
				PRIMARY KEY  (`session_id`)
			) ENGINE=InnoDB DEFAULT CHARSET=utf8;
		");
	}
}