<?php

require_once $_SERVER['DOCUMENT_ROOT']."/backend/database/DB.php";
class Balance
{
    public function create($unique_id): void
    {
        $sql = "INSERT INTO `balance`(`unique_id`, `balance_seller`, `balance_client`, `balance_referral`) VALUES (?, ?, ?, ?)";
        $sth = DB::connect()->prepare($sql);
        $sth->execute(array($unique_id, 0, 0, 0));
    }

    public function ReturnBalance($parameter) {

        $array = [
            'balance_seller',
            'balance_client',
            'balance_referral'
        ];

        if(in_array($parameter, $array)) {
            $sth = DB::connect()->prepare("SELECT `$parameter` FROM `balance` WHERE `unique_id` = ?");
            $sth->execute(array($_COOKIE['unique_id']));
            $array = $sth->fetch(PDO::FETCH_ASSOC);
            return $array[$parameter];
        }
        else return false;
    }

    public function AddRefBalance($id, $amount) {
        $sql = "UPDATE `balance` SET `balance_referral` = `balance_referral` + ? WHERE `unique_id` = ?";
        $query = DB::connect()->prepare($sql);
        $query->execute(array($amount, $id));
    }

    //вывод реферальных средств
    public function WithdrawalOfReferralFunds($value) {
        $sql = "UPDATE `balance` SET `balance_referral` = `balance_referral` - ? WHERE `unique_id` = ?";
        $query = DB::connect()->prepare($sql);
        $query->execute(array($value, $_COOKIE['unique_id']));
    }

    public function AddSellerBalance($order_id) {
        $sql = "SELECT `user`.`unique_id`, `orders`.`amount` FROM `user`
        INNER JOIN `shop` ON `user`.`unique_id` = `shop`.`seller_id`
        INNER JOIN `product` ON `shop`.`id` = `product`.`shop_id`
        INNER JOIN `orders` ON `product`.`id` = `orders`.`product_id` 
        WHERE `orders`.`id` = ?";
        $query = DB::connect()->prepare($sql);
        $query->execute(array($order_id));
        $array = $query->fetch();

        $amount = ($array['amount']/100)*75;

        $sql = "UPDATE `balance` SET `balance_seller` = `balance_seller` + ? WHERE `unique_id` = ?";
        $query = DB::connect()->prepare($sql);
        $query->execute(array($amount, $array['unique_id']));
    }

    public function AddBalanceClient($amount, $unique_id) {
        $sql = "UPDATE `balance` SET `balance_client` = `balance_client` + ? WHERE `unique_id` = ?";
        $query = DB::connect()->prepare($sql);
        $query->execute(array($amount, $_COOKIE['unique_id']));
    }
}