<?php

include_once 'ftp_class.php';
include_once 'DOMValidator.php';
include_once 'database.php';

	try
	{
		$ftp = new ftpClass('ftp.21826319341.thesite.link','z115866pan','3o*Q?6Zid!');//insert here the credentials of the ftp server
		$ftp->logIn();
		$ftp->downloadFiles();
				
	}
	catch(Exception $e)
	{
		echo $e->getMessage();
		exit();
	}
	
	try
	{
		$validator = new DOMValidator();
		$validator->validateFeeds($ftp->local_file);
		$validator->getValues();		
	}
	catch(Exception $e)
	{
		echo $e->getMessage();
		exit();
	}
	
	
	try
	{
		 $validator->getValues();
	}
	catch(Exception $e)
	{
		echo $e->getMessage();
		exit();
	}
	
	$hostname_DB = "127.0.0.1";
	$database_DB = "test";
	$username_DB = "root";
	$password_DB = "";
		
	try 
	{
	   $CONNPDO = new PDO("mysql:host=".$hostname_DB.";dbname=".$database_DB.";charset=UTF8", $username_DB, $password_DB, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, PDO::ATTR_TIMEOUT => 3));
	} 
	catch (PDOException $e) 
	{
	   echo $e->getMessage()." Please check if SQL server is active or your connection credentials";
	   exit();
	}
	
	
		$entry = $validator->jsonedEntries;
		$dataEnter = new DataEntry($CONNPDO, $entry);
		$dataEnter->enterData();
	
	
		
	

		
	



?>