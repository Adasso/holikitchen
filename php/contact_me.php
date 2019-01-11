<?php
// Import PHPMailer classes into the global namespace
// These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;


//Load composer's autoloader
require '../vendor/autoload.php';
// Check for empty fields
if(empty($_POST['name'])  		||
   empty($_POST['email']) 		||
   empty($_POST['date']) 		||
   empty($_POST['time']) 		||
   empty($_POST['phone']) 		||
   empty($_POST['people']) 		||
   !filter_var($_POST['email'],FILTER_VALIDATE_EMAIL))
   {
	echo "Falta completar campos";
	return false;
   }

$name = strip_tags(htmlspecialchars($_POST['name']));
$email_address = strip_tags(htmlspecialchars($_POST['email']));
$date = strip_tags(htmlspecialchars($_POST['date']));
$time = strip_tags(htmlspecialchars($_POST['time']));
$phone = strip_tags(htmlspecialchars($_POST['phone']));
$people = strip_tags(htmlspecialchars($_POST['people']));

// Create the email and send the message
$to = 'marketing@envero.pe'; // Add your email address inbetween the '' replacing yourname@yourdomain.com - This is where the form will send a message to.
$email_subject = 'Reserva de '.$name.' para '.$date." ";
$email_body = nl2br('Solicitud de reserva de '.$name.'.'. "\n\n".' Quiere reservar para '.$people.' personas.'. "\n\n".' Fecha (AAAA,MM,DD): '.$date. "\n\n Hora: ".$time.' '. "\n\n".' Correo: '.$email_address. "\n\n".' Teléfono: '.$phone."");
//$headers = "From: noreply@dada.com.pe\n"; // This is the email address the generated message will be from. We recommend using something like noreply@yourdomain.com.
//$headers .= "Reply-To: $email_address";
//mail($to,$email_subject,$email_body,$headers);
//$to2 = 'info@dada.com.pe';
//$to3 = 'guillermo.dasso@dada.com.pe';
//mail($to2,$email_subject,$email_body,$headers);




    $mail = new PHPMailer(true);                              // Passing `true` enables exceptions
    try {
        //Server settings
        $mail->SMTPDebug = 2;                                 // Enable verbose debug output
        $mail->isSMTP();                                      // Set mailer to use SMTP
        $mail->Host = 'smtp.gmail.com';  // Specify main and backup SMTP servers
        $mail->SMTPAuth = true;                               // Enable SMTP authentication
        $mail->Username = 'reservas.holikitchen@gmail.com';                 // SMTP username
        $mail->Password = 'HoliKitchen123!';                           // SMTP password
        $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
        $mail->Port = 587;                                    // TCP port to connect to


        //Recipients
        $mail->setFrom($email_address, $name);
        $mail->addAddress($to, 'Reservas HK');     // Add a recipient
        $mail->addAddress('tamara@holikitchen.com.pe', 'Tamara HK');
        $mail->addAddress('gerencia@holikitchen.com.pe', 'Gerencia HK');
        $mail->addAddress('contabilidad@holikitchen.com.pe', 'Contabilidad HK');
        //$mail->addAddress($to2);               // Name is optional
        //$mail->addAddress($to3);               // Name is optional
        $mail->addReplyTo($email_address, $name);
        //$mail->addCC('cc@example.com');
        //$mail->addBCC('bcc@example.com');

        //Attachments
        //$mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
        //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name

        //Content
        $mail->isHTML(true);                                  // Set email format to HTML
        $mail->Subject = $email_subject;
        $mail->Body    = $email_body;
        //$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

        $mail->send();
        echo 'El mensaje ha sido enviado';
    } catch (Exception $e) {
        echo 'El mensaje no ha sido enviado.';
        echo 'Mailer Error: ' . $mail->ErrorInfo;
    }
 return true;
?>
