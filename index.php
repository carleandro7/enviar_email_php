<?php
require 'PHPMailer/PHPMailerAutoload.php';

$listaContatos=array();


$types = array( 'pdf');    
$path = 'pasta';
$dir = new DirectoryIterator($path);
foreach ($dir as $fileInfo) {
    $ext = strtolower( $fileInfo->getExtension() );
    if( in_array( $ext, $types ) ){
        echo "<br>".substr($fileInfo->getFilename(),0,-4);
        array_unshift($listaContatos, ["Nome do remetente", substr($fileInfo->getFilename(),0,-4)]);
    }
}
    
foreach ($listaContatos as $value) {
    $mail = new PHPMailer;

    //$mail->SMTPDebug = 3;                               // Enable verbose debug output

    $mail->isSMTP();                                      // Set mailer to use SMTP
    $mail->Host = 'mail.SMTP servers';  // Specify main and backup SMTP servers
    $mail->SMTPAuth = true;                               // Enable SMTP authentication
    $mail->Username = 'email';                 // SMTP username
    $mail->Password = 'senha';                           // SMTP password
    $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
    $mail->Port = 587;                                    // TCP port to connect to

    $mail->setFrom('email');

    
    $mail->addAddress($value[1], $value[0]);     // Add a recipient
    $mail->addAttachment($path."/".$value[1].'.pdf', 'nome do arquivo.pdf');    // Optional name
    $mail->isHTML(true);                                  // Set email format to HTML

    $mail->Subject = 'assunto';
    $mail->Body    = 'mensagem';
    $mail->AltBody = '';

    if(!$mail->send()) {
        echo '<br>Erro ao enviar a mensagem: ' . $mail->ErrorInfo;
    } else {
        echo "<br><br>".$value[0] ;
        echo '<br>Mensagem Enviada';
    }
}


?>