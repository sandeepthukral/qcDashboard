<?php

include_once 'sqlformatter.php';
include_once 'configuration.php';

define("DB_LOG_FILE", "dbLogFile.csv");




function updateTable($query, $env, $application) {

	global $isTest;

	// code for getting the credentials
	$credentials 	= getCredentials($application, $env);
	$username 		= $credentials[1];
	$password 		= $credentials[2];
	$databaseName 	= $credentials[0];

	// code for executing the query
	if ($isTest)
		printLog ( "Connecting to " . $databaseName . " / " . $username . " with update statement <br>" . SqlFormatter::format($query) );
	$timeOfCall = 0;
	
	$didQueryExecute = false;
	$numberOfRowsAffected = 0;

	try {
		$start 			= microtime ( true );
		$conn 			= oci_connect ( $username, $password, $databaseName );
		$stid 			= oci_parse ( $conn, $query );
		$didQueryExecute 	= oci_execute ($stid, OCI_COMMIT_ON_SUCCESS );
		$end 			= microtime ( true );
		$timeOfCall 	= $end - $start;
	} catch ( Exception $e ) {
		echo "<p class=\"error\">Error caucht in update";
		printLog ( $e );
		echo "</p>\n";
	}
	
	// code for closing the connection
	if ($didQueryExecute)
		$numberOfRowsAffected = oci_num_rows($stid);
	
	oci_close ( $conn );
	
	logDbTimes(DB_LOG_FILE, $databaseName, $username, $query, $timeOfCall);

	if ($isTest) {
		echo "Status was " . $didQueryExecute;
		echo "Number of rows affected = " . $numberOfRowsAffected;
	}

	// return the result
	return $numberOfRowsAffected ;
}




function getResponseForQuery($query, $env, $application) {

	global $isTest;

	$temp_array = array ();

	// code for getting the credentials

	$credentials = getCredentials($application, $env);
	$username = $credentials[1];
	$password = $credentials[2];
	$databaseName = $credentials[0];

	// code for executing the query
	if ($isTest)
		printLog ( "Connecting to " . $databaseName . " / " . $username . " with query <br>" . SqlFormatter::format($query) );
	$timeOfCall = 0;

	try {
		
		$start = microtime ( true );
		$conn = oci_connect ( $username, $password, $databaseName );
		
		if ($conn != null){
			$stid = oci_parse ( $conn, $query );
			oci_execute ($stid );
			
		} else {
			$stid = null;
			echo "<p class=\"error\">Error connecting to the database. contact the Administrator</p>";
			echo "<p class=\"error\">Database: " . $databaseName . " using username: " . $username . "</p>";
		}
		
		$end = microtime ( true );
		$timeOfCall = $end - $start;
		
	} catch ( Exception $e ) {
		echo "<p class=\"error\">Error caucht in query";
		printLog ( $e );
		echo "</p>\n";
	}

	// code for filling the temp_Array
	$temp_array = array ();
	if (null != $stid) {
		while ( ($row = oci_fetch_array ( $stid, OCI_ASSOC + OCI_RETURN_NULLS )) != false ) {
			if (is_resource($row))
				echo "RESOURCE!!!<br>";
			 $temp_array[] = $row ;
		}
	}
	
	// code for closing the connection
	if ($conn != null)
		oci_close ( $conn );

	if ($isTest) {
		print_r($temp_array);
	}

	// return the result
	return $temp_array;
}

function printErrorMessage($message){

	echo "<div class='row'>"
			,"<div class='col-md-4 col-md-offset-4'> <p class='text-center bg-danger'>" , $message , "</p> </div>"
					, "</div>";
}

function printLog($message){
	echo "<p class='printLog'>" . $message . "</p>\n";
}

function handleCookie($logFile){
	define('COOKIENAME', 'uuid');

	if (isset($_COOKIE[COOKIENAME])){
		logUsage($logFile, $_COOKIE[COOKIENAME]);
	} else {
		$newUserId = generateRandomCookieId();
		setcookie(COOKIENAME,$newUserId,null,null,null,null,true);
		logUsage($logFile, $newUserId);
	}
}

function generateRandomCookieId(){
	return rand(100000,999999) . '-' . rand(100000,999999);
}

function logUsage ($logFile, $user)
{
	$file_pointer = fopen($logFile, "a+");
	if ($file_pointer)
	{
		fwrite($file_pointer, date("Y-m-d H:i:s") . "," . $user  . "\n");
		fclose($file_pointer);
	}
}



/**
 *
 * Log the time a query takes in the DB
 *
 * @param string $logFile The name of the log file
 * @param string $db The database against which this query is fired
 * @param string $user The user which was used to connect to the DB
 * @param string $query The query which was executed
 * @param string $time The time it took to execute the query
 */
function logDbTimes ($logFile, $db, $user, $query, $time)
{
	$filePointer = fopen($logFile, "a+");
	if ($filePointer){
		fwrite($filePointer, date("Y-m-d H:i:s") . "," . $db . "," . $user . ",\"" . $query. "\"," . $time. "\n");
		fclose($filePointer);
	}
}



function debugToConsole( $data ) {
	if ( is_array( $data ) )
		$output = "<script>console.log( 'Debug Objects: " . implode( ',', $data) . "' );</script>";
	else
		$output = "<script>console.log( 'Debug Objects: " . $data . "' );</script>";

	echo $output;
}