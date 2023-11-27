<?php

require_once $_SERVER['DOCUMENT_ROOT']."/backend/database/DB.php";
require_once $_SERVER['DOCUMENT_ROOT']."/backend/Class/User.php";

class ReferralProgram
{
    public function NumberOfReferrals() {
        $unique_id = $_COOKIE['unique_id'];
        $sql = "SELECT `referral_link` FROM `user` WHERE `unique_id` = ?";
        $array = DB::connect()->prepare($sql);
        $array->execute(array($unique_id));
        $array = $array->fetch(PDO::FETCH_ASSOC);
        $referral_link = $array['referral_link'];

        $sql = "SELECT * FROM `user` WHERE `referral_program` = ?";
        $array = DB::connect()->prepare($sql);
        $array->execute(array($referral_link));
        $array = $array->fetchAll(PDO::FETCH_ASSOC);
        return count($array);
    }

    public function ReturnReferralBalance() {
        $unique_id = $_COOKIE['unique_id'];
        $sql = "SELECT `balance_referral` FROM `balance` WHERE `unique_id` = ?";
        $array = DB::connect()->prepare($sql);
        $array->execute(array($unique_id));
        $array = $array->fetch(PDO::FETCH_ASSOC);
        return $array['balance_referral'];
    }

    public function ReturnReferralBalanceAdmin($id) {
        $sql = "SELECT `balance_referral` FROM `balance` WHERE `unique_id` = ?";
        $array = DB::connect()->prepare($sql);
        $array->execute(array($id));
        $array = $array->fetch(PDO::FETCH_ASSOC);
        return $array['balance_referral'];
    }

    public function ReturnReferralLink() {
        $unique_id = $_COOKIE['unique_id'];
        $sql = "SELECT `referral_link` FROM `user` WHERE `unique_id` = ?";
        $array = DB::connect()->prepare($sql);
        $array->execute(array($unique_id));
        $array = $array->fetch(PDO::FETCH_ASSOC);
        return $array['referral_link'];
    }

    public function ReturnReferralPayment_Details() {
        $unique_id = $_COOKIE['unique_id'];
        $sql = "SELECT `type`, `value` FROM `payment_details` WHERE `unique_id` = ?";
        $array = DB::connect()->prepare($sql);
        $array->execute(array($unique_id));
        $array = $array->fetch(PDO::FETCH_ASSOC);
        return $array;
    }

    public function ReturnAmount_referral_transfers() {
        $sql = "SELECT SUM(amount) as 'total_sum' FROM `referral_transfers` WHERE `id_referral` = ?";

        $user = new User();

        $query = DB::connect()->prepare($sql);
        $query->execute(array($user->ReturnInfoUser('referral_link')));

        $totalSum = $query->fetch(); // Получаем сумму из результата запроса

        return $totalSum['total_sum'];
    }
}