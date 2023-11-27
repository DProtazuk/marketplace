<?php

require_once $_SERVER['DOCUMENT_ROOT']."/backend/database/DB.php";
class ReferralPercentage
{

    public function Return() {
        $sth = DB::connect()->prepare("SELECT `value` FROM `referral_percentage` WHERE `id` = ?");
        $sth->execute(array('1'));
        $array = $sth->fetch(PDO::FETCH_ASSOC);
        return $array['value'];
    }
}