<?php

// SIEBEL
$credentials['SIEBEL']['INT']['DB']="NLDIT";
$credentials['SIEBEL']['INT']['USERNAME']="";
$credentials['SIEBEL']['INT']['PASSWORD']="";

//$credentials['SIEBEL']['UAT']['DB']="NLDUAT";
$credentials['SIEBEL']['UAT']['DB']="New_UAT.world";
$credentials['SIEBEL']['UAT']['USERNAME']="";
$credentials['SIEBEL']['UAT']['PASSWORD']="";

$credentials['SIEBEL']['PREPRD']['DB']="NLDSP";
$credentials['SIEBEL']['PREPRD']['USERNAME']="";
$credentials['SIEBEL']['PREPRD']['PASSWORD']="";

$credentials['TIP']['INT']['USERNAME']='';
$credentials['TIP']['INT']['PASSWORD']='';

$credentials['TIP']['UAT']['USERNAME']='';
$credentials['TIP']['UAT']['PASSWORD']='';

$credentials['T4GINT']['INT']['DB']='T4GINT';
$credentials['T4GINT']['INT']['USERNAME']='';
$credentials['T4GINT']['INT']['PASSWORD']='';

$credentials['OSCAR']['UAT']['DB']='ALHUAT';
$credentials['OSCAR']['UAT']['USERNAME']='';
$credentials['OSCAR']['UAT']['PASSWORD']='';

$wsdlUrl['TIPMobAct']['INT']='wsdl/MobActInt.wsdl';
$wsdlUrl['TIPMobAct']['UAT']='wsdl/MobActUat.wsdl';

$credentials['ACPE']['INT']['DB']='preint';
$credentials['ACPE']['INT']['USERNAME']='';
$credentials['ACPE']['INT']['PASSWORD']='';


$credentials['ALM']['INT']['DB']='//iup-hqcdb01:1521/HQCPRD';
$credentials['ALM']['INT']['USERNAME']='';
$credentials['ALM']['INT']['PASSWORD']='';


function getCredentials($application,$env){
	global $credentials; 
	
	$tempArray = array();
	array_push($tempArray, $credentials[$application][$env]['DB']);
	array_push($tempArray, $credentials[$application][$env]['']);
	array_push($tempArray, $credentials[$application][$env]['']);
	
	return $tempArray;
}
