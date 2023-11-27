<?php

require_once $_SERVER['DOCUMENT_ROOT']."/backend/database/DB.php";class Role
{
    public function create($unique_id): void
    {
        $sql = "INSERT INTO `role`(`unique_id`, `client`, `seller`, `admin`) VALUES (?, ?, ?, ?)";
        $sth = DB::connect()->prepare($sql);
        $sth->execute(array($unique_id, 1, 0, 0));
    }

    public function Update($array): void
    {
        $sth = DB::connect()->prepare("UPDATE `role` SET `seller` = :seller WHERE `unique_id` = :unique_id");
        $sth->execute($array);
    }



    static function Check($role)
    {

        $unauthorized = "unauthorized";
        $client = "client";
        $seller = "seller";
        $admin = "admin";

        $keys = [];

        if (isset($_COOKIE['unique_id'])) {

            $sth = DB::connect()->prepare("SELECT * FROM `role` WHERE `unique_id` = ?");
            $sth->execute(array($_COOKIE['unique_id']));
            $array = $sth->fetch(PDO::FETCH_ASSOC);

            if ($array) {
                $keys[] = $client;
                if ($array['seller'] === 1) {
                    $keys[] = $seller;
                    if ($array['admin'] === 1) {
                        $keys[] = $admin;
                    }
                }
            } else $keys[] = $unauthorized;

        } else $keys[] = $unauthorized;


        if (in_array($role, $keys))
            return true;
        else return false;
    }
}