<?php
include 'include/init.php';
//print_r($_POST);
//echo ($_SESSION['membre']['prenom']);
if(isset($_POST['mail'])){

    $to = $_POST['email'];// this is your Email address subject
    $from = $_SESSION['membre']['email'];// this is the sender's Email address
    //$_SESSION['membre']['prenom']
    $name = $_POST['name'];
    $mobile = $_POST['mobile'];
    $subject = $_POST['subject'];
    $message = $_POST['message'];
    $subject2 = "Copy of your form submission";
    $message = $name . " wrote the following:" . "\n\n" . $message;
    $message2 = "Here is a copy of your message " . $name . "\n\n" . $message;

    $headers = "From:" . $from;
    $headers2 = "From:" . $to;
    mail($to,$subject,$message,$headers);
    mail($from,$subject2,$message2,$headers2); // sends a copy of the message to the sender

    echo "Mail Sent. Thank you " . $name . ", we will contact you shortly.";
    // You can also use header('Location: thank_you.php'); to redirect to another page.
    }
?>
