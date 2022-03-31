<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once '../../PHPMailer/src/Exception.php';
require_once '../../PHPMailer/src/PHPMailer.php';
require_once '../../PHPMailer/src/SMTP.php';
class MailController {

    private $mail = null;
    public function __construct()
    {
        $this->mail = new PHPMailer;
        $this->mail->isSMTP(); 
        $this->mail->Host = "smtp.gmail.com"; // use $this->mail->Host = gethostbyname('smtp.gmail.com'); // if your network does not support SMTP over IPv6
        $this->mail->Port = 587; // TLS only
        $this->mail->SMTPSecure = 'tls'; // ssl is depracated
        $this->mail->SMTPAuth = true;
        $this->mail->Username = 'caliljaudiannn@gmail.com';
        $this->mail->Password = 'jaudian29';
    }

    private function template_log($payload = [])
    {
        global $common;

        $body = "<!DOCTYPE html>";
        $body .= "<html lang='en'>";
        $body .= "<head>";
        $body .= "<meta charset='UTF-8'>";
        $body .= "<meta http-equiv='X-UA-Compatible' content='IE=edge'>";
        $body .= "<meta name='viewport' content='width=device-width, initial-scale=1.0'>";
        $body .= "<title>Document</title>";
        $body .= "  <style>
                    span {
                        display: block;
                        margin: 30px;
                    }
                </style>";
        $body .= "</head>
                    <body>
                        <section>
                            <H2>Daily Log</H2>
                            
                            <h4>Project Name: {$payload['project_name']} </h4>
                            <h4>Name:         {$payload['name']} </h4>
                            <h4>Time In:      {$payload['time_in']} </h4>
                            <h4>Time Out:     {$payload['time_out']}</h4>
                            <h4>Date Logged:  {$payload['log_date']}</h4>
                            <h4>Tasks:        {$payload['tasks']}</h4>
                        </section>
                    </body>
                    </html>";
        return $body;
    }

    public function send_email_logs($config = [])
    {
        // $this->mail->setFrom($config['email_from'], $config['name_from']);
        // $this->mail->setFrom('caliljaudiannn@gmail.com', 'Calil Jaudian');
        $hmtlBody = $this->template_log($config);
        $this->mail->addAddress($config['email_to'], 'Test');
        $this->mail->Subject = 'PHPMailer GMail SMTP test';
        $this->mail->msgHTML($hmtlBody); //$this->mail->msgHTML(file_get_contents('contents.html'), __DIR__); //Read an HTML message body from an external file, convert referenced images to embedded,
        $this->mail->AltBody = 'HTML messaging not supported';

        $this->mail->addAttachment('../uploads' . $config['emp_signature']); //Attach an image file
        $this->mail->addAttachment('../uploads' . $config['supervisor_signature']); //Attach an image file

        return $this->mail->send();
    }
}

$mail_controller = new MailController();