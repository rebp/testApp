<?php

try {
	$db_username = "roberbu105_rebp";
	$db_password = "trebor28";
	$db = new PDO("mysql:host=localhost;roberbu105_dbname=excellent", $db_username, $db_password);
	$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
	echo "Error: " . $e->getMessage();
}


if($_POST['id']) {
	$id = $_POST['id'];

	$dbh = $db->prepare("SELECT * FROM jobs WHERE id = :id");
	$dbh->execute([":id" => $id]);
	$job = $dbh->fetch(PDO::FETCH_ASSOC);

	echo $job['job_name'];

}


