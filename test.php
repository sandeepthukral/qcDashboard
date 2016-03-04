<?php
include_once 'api/checkedInFiles.php';

header("Access-Control-Allow-Orgin: *"); 
header("Access-Control-Allow-Methods: *"); 
header("Content-Type: application/json");

if ($_GET['Type'] == "Components")
	echo getAllRecentlyCheckedInComponents(3);
if ($_GET['Type'] == "Resources")
	echo getAllRecentlyCheckedInResources(3);