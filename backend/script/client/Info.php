<?php

require_once($_SERVER['DOCUMENT_ROOT'] . "/backend/database/DB.php");

class Info
{
    public function name() {

        $sth = DB::connect()->prepare("SELECT * FROM `user` WHERE `unique_id` = ?");
        $sth->execute(array($_COOKIE['unique_id']));
        $array = $sth->fetch(PDO::FETCH_ASSOC);
        return $array['name'];
    }
}