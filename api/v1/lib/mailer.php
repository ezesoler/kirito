<?php
class Mailer {

	private $mail;

	public function __CONSTRUCT()
    {
        include('PHPMailer-5.1/class.phpmailer.php');

		$this->mail = new PHPMailer(true);
		$this->mail->SMTPDebug = 0;
	    $this->mail->isSMTP();
	    $this->mail->Host = "[SMTP_HOST]";
	    $this->mail->SMTPAuth = true;
	   	$this->mail->Username = "[SMTP_USER]";
	    $this->mail->Password = "[SMTP_PASS]";
	    $this->mail->Port = 587;
    }
    
    public function send($email,$code)
    {
		try
		{
			$this->mail->setFrom('[MAIL_FROM]', 'Prode 2018');
			$this->mail->AddAddress($email);
			$this->mail->isHTML(true); 
			$this->mail->CharSet = 'UTF-8';
			$this->mail->Subject = 'Tu código de usuario de Prode 2008';
			$this->mail->Body = '<p>Este es tu código de activación para prode:</p><h1>'.$code.'</h1>';
			return $this->mail->Send();
		}
		catch(Exception $e)
		{
            return 'Message could not be sent. Mailer Error: ' . $this->mail->ErrorInfo;
		}
    }

	
}