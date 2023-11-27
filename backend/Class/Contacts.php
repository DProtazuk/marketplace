<?php

require_once $_SERVER['DOCUMENT_ROOT']."/backend/database/DB.php";

class Contacts
{
    public function create($unique_id): void
    {
        $sql = "INSERT INTO `contacts`(`unique_id`, `telegram`, `2FA`) VALUES (?, ?, ?)";
        $sth = DB::connect()->prepare($sql);
        $sth->execute(array($unique_id, NULL, NULL));
    }

}