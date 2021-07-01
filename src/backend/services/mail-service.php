<?php
class MailService
{
  function __construct()
  {  }

  function sendMail($mail, $eventId, $eventName) {
    $eventUrl = "http://localhost/Invitations/src/frontend/event/event.html?id=".$eventId;
    
    $recipient = $mail;
    $subject = $eventName;
    $message = $eventUrl;
    $sender = "From: webinvitations2021@gmail.com";

    mail($recipient, $subject, $message, $sender);

  }
}
