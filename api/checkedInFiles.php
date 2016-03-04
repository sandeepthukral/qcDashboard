<?php

include_once 'functions.php';

function getAllRecentlyCheckedInComponents ( $daysInThePast ) {
	
	// check if daysInThePast is a number. If not, return false
	if ( !isNumberValid ( $daysInThePast ))
		return false;
	
	// get response from Oracle
	$query = "SELECT CO_FOLDER_ID, CO_NAME, CO_VC_STATUS, CO_VC_CHECKIN_USER_NAME, CO_VC_CHECKIN_DATE, 
				CO_VC_CHECKOUT_USER_NAME, CO_VC_CHECKOUT_DATE  FROM MOBILE_REVOLUTION_4G_DB.COMPONENT WHERE CO_IS_OBSOLETE = 'N' AND CO_VC_CHECKIN_DATE > 
				( SYSDATE - " . $daysInThePast . " ) ";
	
	$responseArray = getResponseForQuery ( $query, "INT", "ALM");
	
	// send JSON response
	return json_encode ( $responseArray );
}

function getAllRecentlyCheckedInResources ( $daysInThePast ) {

	// check if daysInThePast is a number. If not, return false
	if ( !isNumberValid ( $daysInThePast ))
		return false;

	// get response from Oracle
	$query = "SELECT RSC_ID, RSC_PARENT_ID, RSC_NAME, RSC_FILE_NAME, RSC_TYPE, RSC_VC_STATUS, RSC_VC_CHECKIN_USER_NAME, 
				RSC_VC_CHECKIN_DATE, RSC_VC_CHECKOUT_USER_NAME, RSC_VC_CHECKOUT_DATE  
				FROM MOBILE_REVOLUTION_4G_DB.RESOURCES WHERE RSC_VC_CHECKIN_DATE > (SYSDATE - " . $daysInThePast . " ) ";

	$responseArray = getResponseForQuery ( $query, "INT", "ALM");
	
	// send JSON response
	return json_encode ( $responseArray , 128);
}


function isNumberValid ( $inputNumber ) {
	
	if ( !is_numeric ( $inputNumber ) )
		return false;
	if ( $inputNumber < 0 )
		return false;
	
	return true;
}