<?php
error_reporting(1);
require 'vendor/autoload.php';

try {
	$db_username = "roberbu105_rebp";
	$db_password = "trebor28";
	$db = new PDO("mysql:host=localhost;dbname=roberbu105_excellent", $db_username, $db_password);
	$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
	echo "Error: " . $e->getMessage();
}


if(isset($_POST)) {

	$fname 			= $_POST['fname'];
	$lname 			= $_POST['lname'];
	$phone 			= $_POST['phone'];
	$birthdate 		= $_POST['birthdate'];
	$email 			= $_POST['email'];
	$gender 		= $_POST['gender'];
	$status 		= $_POST['status'];
	$document 		= $_POST['document'];
	$responsable 	= $_POST['responsable'];
	$arrested		= $_POST['arrested'];
	$address 		= $_POST['address'];
	$languages 		= implode(', ', $_POST['language']); 
	$nationality	= $_POST['nationality'];
	$position		= $_POST['position'];
	$hours 			= $_POST['hours'];
	$aboutus 		= $_POST['aboutus'];
	$hotels 		= implode(', ', $_POST['hotel']); 
	$experience		= $_POST['experience'];
	$health			= $_POST['health'];
	$cv_tmp_name	= $_FILES['myfile']['tmp_name'];
	$cv_name 		= $_FILES['myfile']['name'];

	$mail = new PHPMailer;

	$mail->isSMTP();                                      // Set mailer to use SMTP
	$mail->Host = 'mail.rebp.nl';  // Specify main and backup SMTP servers
	$mail->SMTPAuth = true;                               // Enable SMTP authentication
	$mail->Username = 'rober@rebp.nl';                 // SMTP username
	$mail->Password = 'trebor28';                           // SMTP password
	$mail->SMTPSecure = 'TLS';                            // Enable TLS encryption, `ssl` also accepted
	$mail->Port = 25;                                    // TCP port to connect to

	$mail->From = "$email";
	$mail->FromName = "$fname $lname";
	$mail->addAddress('rober@rebp.nl', 'Rober Bautista');     // Add a recipient
	$mail->addAttachment($cv_tmp_name, $cv_name);
	$mail->isHTML(true);
	$mail->Subject = 'Excellent Application';
	$output = "
		<h1>CV - Excellent</h1>
		<p>Firstname: $fname</p>
		<p>Lastname: $lname</p>
		<p>Phone: $phone</p>
		<p>Birthdate: $birthdate</p>
		<p>Email: $email</p>
		<p>Gender: $gender</p>
		<p>Status: $status</p>
		<p>Document: $document</p>
		<p>Responsable: $responsable</p>
		<p>Arrested: $arrested</p>
		<p>Address: $address</p>
		<p>Languages: $languages</p>
		<p>Nationality: $nationality</p>
		<p>Position: $position</p>
		<p>Hours: $hours</p>
		<p>Aboutus: $aboutus</p>
		<p>Hotels: $hotels</p>
		<p>Experience: $experience</p>
		<p>Health: $health</p>
	";
	$mail->Body    = $output;

	if(!$mail->send()) {
	    echo 'Message could not be sent.';
	    echo 'Mailer Error: ' . $mail->ErrorInfo;
	} else {
	    echo 'Message has been sent';
	}	

	try{
		$query = "INSERT INTO application(first_name, last_name, phone, birthdate, email, gender, status, document, responsable, arrested, address, languages, nationality, position, hours, aboutus, hotels, experience, health) 
					VALUES(:first_name, :last_name, :phone, :birthdate, :email, :gender, :status, :document, :responsable, :arrested, :address, :languages, :nationality, :position, :hours, :aboutus, :hotels, :experience, :health)";
		$stmt = $db->prepare($query);
		$stmt->execute([
				':first_name'		=> $fname,
				':last_name'		=> $lname, 
				':phone' 			=> $phone,
				':birthdate'		=> $birthdate, 
				':email'			=> $email, 
				':gender' 			=> $gender,
				':status' 			=> $status,
				':document'			=> $document,
				':responsable' 		=> $responsable,
				':arrested' 		=> $arrested,	
				':address' 			=> $address,
				':languages' 		=> $languages,
				':nationality' 		=> $nationality,
				':position' 		=> $position,
				':hours' 			=> $hours,
				':aboutus' 			=> $aboutus,
				':hotels' 			=> $hotels,
				':experience' 		=> $experience,	
				':health'			=> $health
			]);
		$stmt = null;
	}
	catch(PDOException $e)
	{
		echo "Error: " . $e->getMessage();
	}

}	
