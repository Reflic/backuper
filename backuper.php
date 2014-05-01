<?php
/** 
 * backuper - fast export of MySQL Database to Amazon S3
 * (c) 2014 Kevin B.
 * https://github.com/reflic/backuper
 */

require_once "S3.php";

// ---------- SETTINGS ----------
// Database Credentials
define('DB_USER', "root");
define('DB_PW', "");
define('DB_HOST', "localhost");
define('DB_NAME', "");

// AWS Credentials
define("AWS_accessKey", "");
define("AWS_secretKey", "");
define("S3_bucketName", "");

// ---------- OPTIONS ----------
$file_name = "backup.sql";
$sendErrors = false;
$error_mail = "";

/**
 * Checks if errors should be send via mail and sends the mail
 * @param  string $text The text which is the content of the mail.
 * @return void
 */
function mailError($text){
	global $sendErrors, $error_mail;

	if($sendErrors){
		mail ($error_mail, "backuper - Error", $text);
	}
}


// Command e.g mysqldump -h localhost -u root -proot  --routines -B appspark > backup.sql
$command = "mysqldump -h ".DB_HOST." -u ".DB_USER." -p".DB_PW."  --routines -B ".DB_NAME." --result-file=".$file_name." 2>&1";

$output = array();
exec($command, $output);

if(count($output) != 0){
	// Error
	$content = "";
	foreach ($output as $text) {
		$content = $text."\n";
	}
	mailError($content);

}
else{
	// Everything has worked
	if(file_exists($file_name)){
		// Generate a good filename
		$date = new DateTime;
		$rand = uniqid();
		$pre = $date->format("Y_m_d-H:i:s");
		$uploadName = $pre."_".DB_NAME."-".$rand.".sql";

		// Begin upload
		$s3 = new S3(AWS_accessKey, AWS_secretKey);
		$s3->putObject(S3::inputFile($file_name, false), S3_bucketName, $uploadName, S3::ACL_PUBLIC_READ);	

		// Delete file
		unlink($file_name);	
	}
	else{
		mailError("Temp backup file not present.");
	}
}
