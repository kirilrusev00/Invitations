<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Изпращане на имейл</title>
    <link rel="stylesheet" href="style2.css">
    
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-md-4 offset-md-4 mail-form">
                <h2 class="text-center">Изпрати имейл</h2>
                <p class="text-center">Изпратете имейл на всеки през localhost.</p>
                <!-- starting php code -->
                <?php
                    //first we leave this input field blank
                    $recipient = "";
                    //if user click the send button
                    if(isset($_POST['send'])){
                        //access user entered data
                       $recipient = $_POST['email'];
                       $subject = $_POST['subject'];
                       $message = $_POST['message'];
                       $sender = "From: webinvitations2021@gmail.com";
                       //if user leave empty field among one of them
                       if(empty($recipient) || empty($subject) || empty($message)){
                           ?>
                           <!-- display an alert message if one of them field is empty -->
                            <div class="alert alert-danger text-center">
                                <?php echo "Всички полета трябва да се попълнят!" ?>
                            </div>
                           <?php
                        }else{
                            // PHP function to send mail
                           if(mail($recipient, $subject, $message, $sender)){
                            ?>
                            <!-- display a success message if once mail sent sucessfully -->
                            <div class="alert alert-success text-center">
                                <?php echo "Имейлът е успешно изпратен до $recipient"?>
                            </div>
                           <?php
                           $recipient = "";
                           }else{
                            ?>
                            <!-- display an alert message if somehow mail can't be sent -->
                            <div class="alert alert-danger text-center">
                                <?php echo "Грешка при изпращане на имейла!" ?>
                            </div>
                           <?php
                           }
                       }
                    }
                ?> <!-- end of php code -->
                <form action="mail.php" method="POST">
                    <div class="form-group">
                        <input class="form-control" name="email" type="email" placeholder="Получател" value="<?php echo $recipient ?>">
                    </div>
                    <div class="form-group">
                        <input class="form-control" name="subject" type="text" placeholder="Тема">
                    </div>
                    <div class="form-group">
                        <textarea cols="30" rows="5" class="form-control textarea" name="message" placeholder="Вашето съобщение"></textarea>
                    </div>
                    <div class="form-group">
                        <input class="form-control button btn-primary" type="submit" name="send" value="Изпрати">
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>