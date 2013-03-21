<?php

class MailHelper
{

        public static function sendCustomMail($sender,$reciever,$subject,$viewfile,$data = array(),$attachments = '')
        {
                $message = new YiiMailMessage;
                    
                $message->view = $viewfile;
                $message->setBody($data,'text/html','utf-8');
                $message->addTo($reciever);
                $message->setSubject($subject);
                //$message->setEncoder(Swift_Encoding::getQpBitEncoding());
                $message->from = $sender;
                
                return Yii::app()->mail->send($message);
        }
    
    
}

?>
