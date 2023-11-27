<?php

require_once($_SERVER['DOCUMENT_ROOT'] . "/backend/database/DB.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "/backend/Class/User.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "/backend/Class/ReferralPercentage.php");
class ReferralTransfers
{

    public function Create($array)
    {
        $sth = DB::connect()->prepare("INSERT INTO `referral_transfers` SET `id_recipient` = :id_recipient, `id_referral` = :id_referral, `id_order` = :id_order, `amount` = :amount, `ReferralPercentage` =:ReferralPercentage, `status` =:status");
        $value = $sth->execute($array);
        return $value;

    }

    public function ReturnAmount() {
        if($_COOKIE['unique_id']){
            $user = new User();

            $sql = "SELECT SUM(`amount`) AS total_amount FROM `referral_transfers`
            WHERE `status` = 'passed' AND `id_referral` = ?";
            $query = DB::connect()->prepare($sql);
            $query->execute(array($user->ReturnInfoUser('referral_link')));
            $result = $query->fetch();
            return $result['total_amount'];
        }
    }

    public function ReturnAmountAdmin($id) {
            $user = new User();

            $sql = "SELECT SUM(`amount`) AS total_amount FROM `referral_transfers`
            WHERE `status` = 'passed' AND `id_referral` = ?";
            $query = DB::connect()->prepare($sql);
            $query->execute(array($user->ReturnInfoUser('referral_link')));
            $result = $query->fetch();
            return $result['total_amount'];
    }
}