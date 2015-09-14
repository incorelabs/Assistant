<?php
/**
 * Created by PhpStorm.
 * User: kbokdia
 * Date: 14/09/15
 * Time: 11:24 AM
 */

namespace Assistant\Mail;


class Mailer extends \PHPMailer
{
    function __construct(){
        parent::__construct();

        $this->isSMTP();                                      // Set mailer to use SMTP
        $this->Host = MAIL_HOST;  // Specify main and backup SMTP servers
        $this->SMTPAuth = true;                               // Enable SMTP authentication
        $this->Username = MAIL_USERNAME;                 // SMTP username
        $this->Password = MAIL_PASSWORD;                           // SMTP password
        $this->SMTPSecure = 'ssl';
        $this->Port = MAIL_PORT;

        $this->From = MAIL_FROM;
        $this->FromName = MAIL_FROM_NAME;
    }
}