<?php
class Mailer {

	private $mail;

	public function __CONSTRUCT()
    {
        include('PHPMailer-5.1/class.phpmailer.php');

		$this->mail = new PHPMailer(true);
		$this->mail->SMTPDebug = 0;
	    $this->mail->isSMTP();
	    $this->mail->Host = "mail.jk000195.ferozo.com";
	    $this->mail->SMTPAuth = true;
	   	$this->mail->Username = "no-reply@jk000195.ferozo.com";
	    $this->mail->Password = "jkEOSoVtAueu";
	    $this->mail->Port = 587;
    }
    
    public function send($email,$code)
    {
		try
		{
			$this->mail->setFrom('no-reply@jk000195.ferozo.com', 'Kirito');
			$this->mail->AddAddress($email);
			$this->mail->isHTML(true); 
			$this->mail->CharSet = 'UTF-8';
			$this->mail->Subject = 'Tu código de usuario del Prode';
			$this->mail->Body = 'Tomad y comed '.$code;
			return $this->mail->Send();
		}
		catch(Exception $e)
		{
            return 'Message could not be sent. Mailer Error: ' . $this->mail->ErrorInfo;
		}
    }

	
}