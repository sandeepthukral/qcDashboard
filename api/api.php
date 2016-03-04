<?php

require_once 'api.class.php';
include_once 'functions.php';
//define("DB_NAME", "MOBILE_REVOLUTION_4G_DB");
define("DB_NAME", "TELE2_TCOE_TELE2_TCOE_TESTINGS");

class User{
	
	private $name = "";
		
	public function __constructor($name){
		$this->name = $name;
	}
	
	public function getName(){
		return $this->name;
	}
	
	public function setName($name){
		$this->name = $name;
	}
}



class MyAPI extends API
{
	protected $User;

	public function __construct($request, $origin) {
		parent::__construct($request);

		$this->User = new User();
	}

	/**
	 * Example of an Endpoint
	 */
	protected function example() {
		if ($this->method == 'GET') {
			return "Your name is " . $this->User->getName();
		} else {
			return "Only accepts GET requests";
		}
	}
	
	
	
	protected function components($args){
		
		if ($this->method == 'GET') {
			if (count($args) >1){
				return "Please send only one parameter to the call";
			}

			$noOfDays = 3;
			$wasArgumentPassed = false;
			
			if (count($args) == 1){
				
				if (is_numeric($args[0])){
				
					if ($args[0] > 0){
				
						$wasArgumentPassed = true;
						$noOfDays = $args[0];
						
					}
				}
			} 
			
			// verb 'count' is treated as special. 
			// It returns all checked out components, or those checked out for X number of days
			if ($this->verb == "count"){
				$query = "SELECT COUNT(*) FROM " . DB_NAME . ".COMPONENT 
						WHERE CO_VC_STATUS='Checked_Out' ";
				
				if ($wasArgumentPassed && $args[0] == 'all'){
					;
				} else if ( count($args) == 1  && is_numeric ( $args[0] ) ){
					$query .= "AND CO_VC_CHECKOUT_DATE > ( SYSDATE - " . $noOfDays . " ) ";
				}
				 
			} else {
				$query = "SELECT CO_FOLDER_ID, CO_NAME, CO_VC_STATUS, CO_VC_CHECKIN_USER_NAME, CO_VC_CHECKIN_DATE,
				CO_VC_CHECKOUT_USER_NAME, CO_VC_CHECKOUT_DATE  FROM " . DB_NAME . ".COMPONENT WHERE CO_IS_OBSOLETE = 'N' AND CO_VC_CHECKIN_DATE >
				( SYSDATE - " . $noOfDays . " ) ";
			}
			
			$responseArray = getResponseForQuery ( $query, "INT", "ALM");
			return $responseArray;
		}
	}
	
	
	
	
	
	
	protected function resources($args){
	
		if ($this->method == 'GET') {
			if (count($args) >1){
				return "Please send only one parameter to the call";
			}
	
			$noOfDays = 30;
			$wasArgumentPassed = false;
				
			if (count($args) == 1){
				if (is_numeric($args[0])){
					if ($args[0] > 0){
						$wasArgumentPassed = true;
						$noOfDays = $args[0];
					}
				}
			}
			
			
			// verb 'count' is treated as special.
			// It returns all checked out components, or those checked out for X number of days
			if ($this->verb == "count"){
				$query = "SELECT COUNT(*) FROM " . DB_NAME . ".RESOURCES
						WHERE RSC_VC_STATUS='Checked_Out' ";
			
				if ($wasArgumentPassed && $args[0] == 'all'){
					;
				} else if ( count($args) == 1  && is_numeric ( $args[0] ) ){
					$query .= "AND RSC_VC_CHECKOUT_DATE > ( SYSDATE - " . $noOfDays . " ) ";
				}
					
			} else {
				$query = "SELECT RSC_ID, RSC_PARENT_ID, RSC_NAME, RSC_FILE_NAME, RSC_TYPE, RSC_VC_STATUS, RSC_VC_CHECKIN_USER_NAME,
					RSC_VC_CHECKIN_DATE, RSC_VC_CHECKOUT_USER_NAME, RSC_VC_CHECKOUT_DATE
					FROM " . DB_NAME . ".RESOURCES WHERE ";
				
				if ($this->verb == "checkedIn"){
					$query .= "RSC_VC_CHECKIN_DATE > (SYSDATE - " . $noOfDays . " ) ";
				} else if ($this->verb == "checkedOut"){
					$query .= "RSC_VC_STATUS='Checked_Out' AND RSC_VC_CHECKIN_DATE < (SYSDATE - " . $noOfDays . " ) ";
				} else {
					$query .= "RSC_VC_CHECKIN_DATE > (SYSDATE - " . $noOfDays . " ) ";
				}
			}
				
				
			$responseArray = getResponseForQuery ( $query, "INT", "ALM");
			return $responseArray;
		}
	}
	
	
	
	
	
	
	protected function testCases($args){
	
		if ($this->method == 'GET') {
			if (count($args) >1){
				return "Please send only one parameter to the call";
			}
	
			$noOfDays = 30;
			$wasArgumentPassed = false;
	
			if (count($args) == 1){
				if (is_numeric($args[0])){
					if ($args[0] > 0){
						$wasArgumentPassed = true;
						$noOfDays = $args[0];
					}
				}
			}
				
				
			// verb 'count' is treated as special.
			// It returns all checked out components, or those checked out for X number of days
			if ($this->verb == "count"){
				$query = "SELECT COUNT(*) FROM " . DB_NAME . ".TEST
						WHERE TS_VC_STATUS='Checked_Out' ";
					
				if ($wasArgumentPassed && $args[0] == 'all'){
					;
				} else if ( count($args) == 1  && is_numeric ( $args[0] ) ){
					$query .= "AND TS_VC_CHECKOUT_DATE > ( SYSDATE - " . $noOfDays . " ) ";
				}
					
			} else {
				$query = "SELECT TS_TEST_ID, TS_PATH, TS_SUBJECT, TS_NAME, TS_TYPE, TS_VC_STATUS, TS_VC_CHECKIN_USER_NAME,
					TS_VC_CHECKIN_DATE, TS_VC_USER_NAME, TS_VC_DATE
					FROM " . DB_NAME . ".TEST WHERE ";
	
				if ($this->verb == "checkedIn"){
					$query .= "TS_VC_CHECKIN_DATE > (SYSDATE - " . $noOfDays . " ) ";
				} else if ($this->verb == "checkedOut"){
					$query .= "TS_VC_STATUS='Checked_Out' AND TS_VC_CHECKIN_DATE < (SYSDATE - " . $noOfDays . " ) ";
				} else {
					$query .= "TS_VC_CHECKIN_DATE > (SYSDATE - " . $noOfDays . " ) ";
				}
			}
	
	
			$responseArray = getResponseForQuery ( $query, "INT", "ALM");
			return $responseArray;
		}
	}
	
	
	
	
	protected function checkedOutComponents($args){
	
	if ($this->method == 'GET') {
			if (count($args) >1){
				return "Please send only one parameter to the call";
			}

			$noOfDays = 3;
			$wasArgumentPassed = false;
			
			// see if there wre arguments passed
			if (count($args) == 1){
				if (is_numeric($args[0])){
					if ($args[0] > 0){
						$wasArgumentPassed = true;
						$noOfDays = $args[0];
					}
				}
			}
			
			// verb 'count' is treated as special. 
			// It returns all checked out components, or those checked out for X number of days
			if ($this->verb == "count"){
				$query = "SELECT COUNT(*) FROM " . DB_NAME . ".COMPONENT 
						WHERE CO_VC_STATUS='Checked_Out' ";
				
				if ($wasArgumentPassed && $args[0] == 'all'){
					;
				} else if ( count($args) == 1  && is_numeric ( $args[0] ) ){
					$query .= "AND CO_VC_CHECKOUT_DATE > ( SYSDATE - " . $noOfDays . " ) ";
				}
				 
			} else {
				$query = "SELECT CO_FOLDER_ID, CO_NAME, CO_VC_STATUS, CO_VC_CHECKIN_USER_NAME, CO_VC_CHECKIN_DATE,
				CO_VC_CHECKOUT_USER_NAME, CO_VC_CHECKOUT_DATE  FROM " . DB_NAME . ".COMPONENT WHERE CO_IS_OBSOLETE = 'N' AND CO_VC_CHECKIN_DATE >
				( SYSDATE - " . $noOfDays . " ) ";
			}
			
			$responseArray = getResponseForQuery ( $query, "INT", "ALM");
			return $responseArray;
		}
	}
		
}


if (!array_key_exists('HTTP_ORIGIN', $_SERVER)) {
	$_SERVER['HTTP_ORIGIN'] = $_SERVER['SERVER_NAME'];
}

try {
	$API = new MyAPI($_REQUEST['request'], $_SERVER['HTTP_ORIGIN']);
	echo $API->processAPI();
} catch (Exception $e) {
	echo json_encode(Array('error' => $e->getMessage()));
}



