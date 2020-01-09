<?php

	/*
		EMailqueue
		API
	*/

	namespace Emailqueue;
	
	include_once dirname(__FILE__)."/../common.inc.php";
	
	$q = json_decode($utils->getglobal("q"));
	if (is_null($q))
		apiResult(false, "Can't decode query");

	if (!$q["key"] || $q["key"] == "")
		apiResult(false, "No API key passed");

	if ($q["key"] != API_KEY) {
		sleep(rand(1, 3));
		apiResult(false, "Wrong API key");
	}
	
	if ($q["message"] && $q["messages"])
		apiResult(false, "Both message and messages have been passed, please pass only one of them");

	if ($message)
		$messages[] = $message;
	
	foreach ($messages as $message) {
		if (!$message["from"])
			apiResult(false, "Key \"from\" is required");
		if (!$message["to"])
			apiResult(false, "Key \"to\" is required");
		if (!$message["subject"])
			apiResult(false, "Key \"subject\" is required");
	}
	
	$db->disconnect();

	function apiResult($isOk, $description = false) {
		echo json_encode([
			"result" => $isOk,
			"description" => $description
		]);
		die;
	}

?>