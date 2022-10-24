<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

require 'PHPMailer-master/PHPMailer-master/src/Exception.php';
require 'PHPMailer-master/PHPMailer-master/src/PHPMailer.php';
require 'PHPMailer-master/PHPMailer-master/src/SMTP.php';

$mail = new PHPMailer(true);
$userName = $userEmail = $messageContent = $response = "";

if ($_SERVER ['REQUEST_METHOD'] == 'POST' && $_POST['action'] == 'contact') {
	try {
		if ($_POST['name'] !== '')
		{
			$userName = $_POST['name'];
			if ($_POST['email'] !== '' && filter_var($_POST['email'], FILTER_VALIDATE_EMAIL))
			{
				$userEmail = $_POST['email'];
				$messageContent = $_POST['message'];
				
				//Server settings
				$mail->SMTPDebug = 0;
				$mail->isMail();
				$mail->Host       = // Top secret info
				$mail->SMTPAuth   = // Top secret info
				$mail->Username   = // Top secret info
				$mail->Password   = // Top secret info
				$mail->SMTPSecure = // Top secret info
				$mail->Port       = // Top secret info

				//Email with form contents
				$mail->setFrom( [imagine my mailbox details here] );
				$mail->addAddress( [imagine my mailbox details here] );
				$mail->isHTML(true);
				$mail->Subject = 'New message from devmonica.com';
				$mail->Body    = "Name: $userName<br><br>Email: $userEmail<br><br>Message: $messageContent";
				
				//If sent successfully...
				if ($mail->send()) {
					$mail->ClearAddresses();
					$mail->addAddress($userEmail, $userName);
					$mail->Subject = 'Thank you from Monica';
					$mail->Body    = "Dear $userName,<br><br>Thank you so much for your message and for taking the time to look through my website. This is just a wee note to confirm that I've received your message and I will get back to you as soon as possible.<br><br>Kind regards,<br>Monica";
					if ($mail->send()) {
						$response = [
						"sent" => true,
						"message" => "Thank you for your message, you should receive a confirmation email very shortly :)"
					];
					echo json_encode($response);
					}
				}
				else {
					echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
				}
			}
			else
			{
				$response = [
					"sent" => false,
					"message" => "Hmmmm that's a weird lookin email you got there, is it correct?"
				];
				echo json_encode($response);
			}
		}
		else {
			$response = [
				"sent" => false,
				"message" => "Knock knock! Who's there? Please enter your name"
			];
			echo json_encode($response);
		}
	} 
	catch (Exception $e) {
		echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
	}
}
?>