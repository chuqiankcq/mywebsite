<?php

if(isset($_POST['Email_Address'])) {
	
	include 'lite_settings.php';
	
	if($email_to == "youremailaddress@yourdomain.com") {
		die("This message is for the Webmaster. Please enter your email address into the file 'lite_settings.php'");
	}
	
	function died($error) {
		echo "Sorry, but there were error(s) found with the form your submitted. ";
		echo "These errors appear below.<br /><br />";
		echo $error."<br /><br />";
		echo "Please go back and fix these errors.<br /><br />";
		die();
	}
	
	if(!isset($_POST['Full_Name']) ||
		!isset($_POST['Email_Address']) ||
		!isset($_POST['Telephone_Number']) ||
		!isset($_POST['Organization']) ||
		!isset($_POST['Subject']) ||
		!isset($_POST['Your_Message'])) {
		died('We are sorry, but there appears to be a problem with the form your submitted.');		
	}
	
	$full_name = $_POST['Full_Name']; // required
	$email_from = $_POST['Email_Address']; // required
	$organization = $_POST['Organization']; // not required
	$telephone = $_POST['Telephone_Number']; // not required
	$subject = $_POST['Subject']; // not required
	$comments = $_POST['Your_Message']; // required
	
	$error_message = "";
	$email_exp = "^[A-Z0-9._%-]+@[A-Z0-9.-]+\.[A-Z]{2,4}$";
  if(!eregi($email_exp,$email_from)) {
  	$error_message .= 'The Email Address you entered does not appear to be valid.<br />';
  }
  if(strlen($full_name) < 2) {
  	$error_message .= 'Your Name does not appear to be valid.<br />';
  }
  if(strlen($comments) < 2) {
  	$error_message .= 'The Comments you entered do not appear to be valid.<br />';
  }
  
  if(strlen($error_message) > 0) {
  	died($error_message);
  }
	$email_message = "Form details below.\r\n";
	
	function clean_string($string) {
	  $bad = array("content-type","bcc:","to:","cc:","href");
	  return str_replace($bad,"",$string);
	}
	
	$email_message .= "Full Name: ".clean_string($full_name)."\r\n";
	$email_message .= "Email: ".clean_string($email_from)."\r\n";
	$email_message .= "Organization: ".clean_string($organization)."\r\n";
	$email_message .= "Telephone: ".clean_string($telephone)."\r\n";
	$email_message .= "Subject: ".clean_string($subject)."\r\n";
	$email_message .= "Message: ".clean_string($comments)."\r\n";
	
$headers = 'From: '.$email_from."\r\n".
'Reply-To: '.$email_from."\r\n" .
'X-Mailer: PHP/' . phpversion();
@mail($email_to, $email_subject, $email_message, $headers);
header("Location: $thankyou");
?>
<script>location.replace('<?php echo $thankyou;?>')</script>
<?php
}
?>