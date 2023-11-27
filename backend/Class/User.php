<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require_once $_SERVER['DOCUMENT_ROOT'] . '/tools/PHPMailer/src/Exception.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/tools/PHPMailer/src/PHPMailer.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/tools/PHPMailer/src/SMTP.php';

require_once $_SERVER['DOCUMENT_ROOT']."/backend/database/DB.php";
require_once $_SERVER['DOCUMENT_ROOT']."/backend/Class/Role.php";
require_once $_SERVER['DOCUMENT_ROOT']."/backend/Class/balance/Balance.php";
require_once $_SERVER['DOCUMENT_ROOT']."/backend/Class/Contacts.php";
class User
{

    public function Authorization($email, $password): string
    {
        $sql = "SELECT * FROM `user` WHERE `email` = ?";
        $sth = DB::connect()->prepare($sql);
        $sth->execute(array($email));
        $array = $sth->fetch(PDO::FETCH_ASSOC);

        if ($array) {
            if (password_verify($password, $array['password'])) {
                setcookie("unique_id", $array['unique_id'], time() + 3600, "/");
                setcookie("role", "client", time() + 3600, "/");
                return "authorization";
            } else return "password";
        } else return "email";
    }

    public function Registration($name, $email, $password, $second_password, $referral_program): string
    {
        $sql = "SELECT * FROM `user` WHERE `email` = ?";
        $sth = DB::connect()->prepare($sql);
        $sth->execute(array($email));
        $array = $sth->fetch(PDO::FETCH_ASSOC);

        if ($array) {
            return "email";
        } else {
            if ($password !== $second_password) {
                return "password";
            } else {
                if (empty($_POST['referral_link'])) {
                    $referral_program = NULL;
                    $this->SaveRegistration($name, $email, $password, $referral_program);
                    return "registration";
                } else {
                    $sth = DB::connect()->prepare("SELECT * FROM `user` WHERE `referral_link` = ?");
                    $sth->execute(array($_POST['referral_link']));
                    $array = $sth->fetch(PDO::FETCH_ASSOC);

                    if (!$array) {
                        return "referral_link";
                    } else {
                        $referral_program = $_POST['referral_link'];
                        $this->SaveRegistration($name, $email, $password, $referral_program);
                        return "registration";
                    }
                }

            }

        }
    }


    private function SaveRegistration($name, $email, $password, $referral_program): void
    {
        $my_function = new MyFunction();
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $referral_link = '';
        for ($i = 0; $i < 15; $i++) {
            $referral_link .= $characters[rand(0, strlen($characters) - 1)];
        }

        $unique_id = $my_function->random_unique_id();
        $password = password_hash($password, PASSWORD_DEFAULT);

        $sql = "INSERT INTO `user` SET `unique_id` = :unique_id, `name` = :name, `password` = :password, `email` = :email, `link` = NULL, `time` = NULL, `referral_link` = :referral_link, `referral_program` = :referral_program";
        $sth = DB::connect()->prepare($sql);
        $sth->execute(array(
            'unique_id' => $unique_id,
            'name' => $name,
            'password' => $password,
            'email' => $email,
            'referral_link' => $referral_link,
            'referral_program' => $referral_program
        ));

        $role = new Role();
        $role->create($unique_id);

        $balance = new Balance();
        $balance->create($unique_id);

        $contacts = new Contacts();
        $contacts->create($unique_id);

        setcookie("unique_id", $unique_id, time() + 3600, "/");
        setcookie("referral_link", "", time() - 3600, "/");
        setcookie("role", "client", time() + 3600, "/");
    }

    public function ReturnInfoUser($parameter) {

        $array = [
            'name',
            'email',
            'referral_link',
            'referral_program'
        ];

        if(in_array($parameter, $array)) {
            $sth = DB::connect()->prepare("SELECT `$parameter` FROM `user` WHERE `unique_id` = ?");
            $sth->execute(array($_COOKIE['unique_id']));
            $array = $sth->fetch(PDO::FETCH_ASSOC);
            return $array[$parameter];
        }
        else return false;
    }




    public function PasswordReset($email): string
    {
        $sth = DB::connect()->prepare("SELECT * FROM `user` WHERE `email` = ?");
        $sth->execute(array($email));
        $array = $sth->fetch(PDO::FETCH_ASSOC);

        if ($array) {
            $time_start = $array['time'];
            $time_finish = time();

            $time = $time_finish - $time_start;

            if ($array['time'] !== NULL) {
                if ($time > 300) {
                    $this->SendEmail($email, $array['unique_id']);
                    return "send";
                } else {
                    setcookie("time", $time_start + 300, time() + 3600, "/");
                    return "time";
                }
            } else {
                $this->SendEmail($email, $array['unique_id']);
                return "send";
            }

        } else return "email";
    }


    private function SendEmail($email, $unique_id): void
    {
        $my_function = new MyFunction();
        $hash = $my_function->random_link();
        $link = $_SERVER['HTTP_HOST']."/page/entry_system/return_password?key=" . $hash;

        $mail = new PHPMailer();
        $mail->CharSet = 'UTF-8';
        $mail->ContentType = "text/html";

// Настройки SMTP
        $mail->isSMTP();
        $mail->SMTPAuth = true;

        $mail->Host = 'ssl://smtp.rambler.ru';
        $mail->Port = 465;
        $mail->Username = 'exmrkt';
        $mail->Password = 'qwrwesdfs21321Q';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;

// От кого
        $mail->setFrom('exmrkt@rambler.ru', 'EX_MRKT');

// Кому
        $mail->addAddress($email);

// Тема письма
        $mail->Subject = "Возврат пароля";

// Тело письма
        $body = '<p><strong>Ваша ссылка для восстановления пароля: <a href="' . $link . '">Ссылка</a> </strong></p>';
        $mail->msgHTML($body);

        $mail->send();


        $sth = DB::connect()->prepare("UPDATE `user` SET `link` = :link, `time` = :time WHERE `unique_id` = :unique_id");
        $sth->execute(array(
            'unique_id' => $unique_id,
            'link' => $hash,
            'time' => time()
        ));
    }

    public function SaveNewPassword($link, $password, $second_password): string
    {
        $sth = DB::connect()->prepare("SELECT * FROM `user` WHERE `link` = ?");
        $sth->execute(array($link));
        $array = $sth->fetch(PDO::FETCH_ASSOC);

        if ($array) {
            $time_start = $array['time'];
            $time_finish = time();

            $time = $time_finish - $time_start;

            if ($array['time'] !== NULL) {
                if ($time < 300) {
                    if ($password === $second_password) {
                        $password = password_hash($password, PASSWORD_DEFAULT);

                        $sth = DB::connect()->prepare("UPDATE `user` SET  `password` = :password, `time` = NULL, `link` = NULL WHERE `link` = :link");
                        $sth->execute(array(
                            'link' => $link,
                            'password' => $password
                        ));
                        return "save";
                    } else return "password";
                } else return "link";

            } else return "link";
        } else return "link";
    }
}