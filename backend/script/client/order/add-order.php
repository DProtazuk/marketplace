<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/backend/database/DB.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/backend/Class/User.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/backend/Class/Orders.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/backend/Class/Product.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/backend/Class/balance/BalanceHistoryClientExpenditure.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/backend/Class/ReferralPercentage.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/backend/Class/ReferralTransfers.php";

$Orders = new Orders();
$User = new User();
$BalanceHistory = new BalanceHistoryClientExpenditure();
$ReferralPercentage = new ReferralPercentage();
$ReferralTransfers = new ReferralTransfers();

function CheckProduct()
{
    if (isset($_POST['id'])) {
        $product = new Product();
        $product = $product->selectOneProduct($_POST['id']);

        if ($product) {
            return $product;
        } else return false;
    } else return false;
}

if (isset($_COOKIE['unique_id'])) {
    $sth = DB::connect()->prepare("SELECT `user`.`referral_program`, `balance`.`balance_client` FROM `user` 
        INNER JOIN `balance` ON `user`.`unique_id` = `balance`.`unique_id` 
         WHERE `user`.`unique_id` = ?");

    $sth->execute(array($_COOKIE['unique_id']));
    $ArrayUser = $sth->fetch(PDO::FETCH_ASSOC);

    //Проверка наличия клиента
    if ($ArrayUser) {
        //Проверка наличия продукта
        if (CheckProduct()) {
            $product = CheckProduct();

            $price = $product['price'];
            $discount = $product['discount'];
            $quantity = $_POST['quantity'];


            if($discount) {
                $price = $price-($price/100)*$discount;
            }

            if($quantity == "0"){
                return false;
            }

            //Проверка наличия колличества
            if ($product['quantity'] >= $quantity) {
                //Проверка Баланса
                if ($ArrayUser['balance_client'] >= $price * $quantity) {

                    //Изменить статус у аккаунтов
                    {
                        $db = DB::connect();
                        $db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

                        $parameters = [];
                        array_push($parameters, "acquired");
                        array_push($parameters, "new");
                        array_push($parameters, $_POST['id']);
                        array_push($parameters, $quantity);

                        $sql = "UPDATE `accounts` SET `status` = ? WHERE `status` = ? AND `id_product` = ? LIMIT ?";
                        $stmt = $db->prepare($sql);
                        $stmt->execute($parameters);
                    }

                    //Добавить запись в таблицы заказов
                    {
                        $amount = $quantity * $price;

                        $array = [
                            'unique_id' => $_COOKIE['unique_id'],
                            'product_id' => $product['id'],
                            'price' => $price,
                            'amount' => $amount,
                            'amount_seller' => $amount - ($amount/100)*25,
                            'quantity' => $quantity,
                            'data' => date('Y-m-d H:i:s'),
                            'status' => '2'
                        ];

                        $id_order = $Orders->Create($array);
                    }

                    //Добавить в связь купленных аккаунтов
                    {
                        $sql = "SELECT `id` FROM `accounts` WHERE `id_product` = ? AND `status` = ? LIMIT ?";
                        $sth = $db->prepare($sql);
                        $sth->execute(array($product['id'], "acquired", $quantity));
                        $array = $sth->fetchAll(PDO::FETCH_ASSOC);

                        $sql = "INSERT INTO `account_on_order` (`product_id`, `account_id`, `order_id`) VALUES ";

                        $parameters = [];

                        foreach ($array as $item) {
                            $sql .= "(?, ?, ?), ";

                            array_push($parameters, $product['id']);
                            array_push($parameters, $item['id']);
                            array_push($parameters, $id_order);
                        }
                        $sql = rtrim($sql);
                        $sql = substr($sql, 0, -1);

                        $sth = $db->prepare($sql);
                        $sth->execute($parameters);
                    }

                    //Изменить колличество товара
                    {
                        $stmt = $db->prepare("UPDATE product SET quantity = quantity - ? WHERE id = ?");
                        $stmt->execute([$quantity, $product['id']]);
                    }

                    //Добавить в историю баланса
                    {
                        $array = [
                            'unique_id' => $_COOKIE['unique_id'],
                            'data' => date('Y-m-d H:i:s'),
                            'amount' => $amount,
                            'content' => $id_order,
                            'status' => 2,
                            'type' => 'order'
                        ];

                        $BalanceHistory->Create($array);
                    }

                    //Изменить баланс
                    {
                        $stmt = DB::connect()->prepare("UPDATE balance SET balance_client = balance_client - ? WHERE unique_id = ?");
                        $stmt->execute([$amount, $_COOKIE['unique_id']]);
                    }

                    $mass = [
                        'id' => $id_order,
                        'amount' => $amount,
                        'quantity' => $quantity,
                        'status' => 'good',
                        'data' => date('Y-m-d H:i:s')
                    ];

                    //Если есть рефералка
                    {
                        if($ArrayUser['referral_program']){

                            $id_referral = $User->ReturnInfoUser('referral_program');
                            $referralNum = $ReferralPercentage->Return();

                            $amount = ceil((($price*$quantity)/100)*$referralNum);

                            $array = [
                                'id_recipient' => $_COOKIE['unique_id'],
                                'id_referral' => $id_referral,
                                'id_order' => $id_order,
                                'amount' => $amount,
                                'ReferralPercentage' => $referralNum,
                                'status' => "not passed"
                            ];

                            $ReferralTransfers->Create($array);
                        }
                    }

                    echo json_encode($mass);

                } else {
                    echo json_encode("balance");
                }
            } else {

            }
        } else {

        }

    } else {

    }
}