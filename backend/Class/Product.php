<?php

require_once($_SERVER['DOCUMENT_ROOT'] . "/backend/database/DB.php");

class Product
{

    function selectOneProduct($id) {
        $sth = DB::connect()->prepare("SELECT * FROM `product` WHERE `id` = ?");
        $sth->execute([$id]);
        return $sth->fetch(PDO::FETCH_ASSOC);
    }

    function ProductQuantity() {
        $Shop = new Shop();
        $id = $Shop->ReturnIdShop();
        $sth = DB::connect()->prepare("SELECT SUM(quantity) as total_quantity FROM `product` WHERE `shop_id` = ?");
        $sth->execute([$id]);
        $array = $sth->fetch(PDO::FETCH_ASSOC);
        return $array['total_quantity'];
    }

    function ProductAmount() {
        $Shop = new Shop();
        $id = $Shop->ReturnIdShop();
        $sth = DB::connect()->prepare("SELECT SUM(quantity*price) as total_amout FROM `product` WHERE `shop_id` = ?");
        $sth->execute([$id]);
        $array = $sth->fetch(PDO::FETCH_ASSOC);
        return $array['total_amout'];
    }

    public function DeleteProduct($id){
        $sth = DB::connect()->prepare("DELETE FROM `product` WHERE `id` = ?");
        $sth->execute(array($id));

        $sth = DB::connect()->prepare("DELETE FROM `parameter_table` WHERE `id_product` = ?");
        $sth->execute(array($id));

    }


    //Новинки товаров
    public function  new_products(){
        $sql = "SELECT `product`.`id` as id, `product`.`name` as name, `product`.`cover` as cover, `product`.`price` as price, `product`.`quantity`, `shop`.`name` as shop, `global_categories`.`img` as img, `shop`.`id` as shop_id, `shop`.`rating` as rating FROM `shop` INNER JOIN `product` ON `shop`.`id` = `product`.`shop_id` INNER JOIN `global_categories`  ON `product`.`global_category` = `global_categories`.`id` WHERE `date_of_creation` >= DATE_SUB(NOW(), INTERVAL 5 DAY)";
        $sth = DB::connect()->query($sql);
        $array = $sth->fetchAll(PDO::FETCH_ASSOC);
        return $array;
    }

    public function  discount_products(){
        $sql = "SELECT `product`.`id` as id, `product`.`name` as name, `product`.`cover` as cover, `product`.`price` as price, `product`.`quantity`, `shop`.`name` as shop, `global_categories`.`img` as img, `shop`.`id` as shop_id, `shop`.`rating` as rating FROM `shop` INNER JOIN `product` ON `shop`.`id` = `product`.`shop_id` INNER JOIN `global_categories`  ON `product`.`global_category` = `global_categories`.`id` WHERE TRIM(`product`.`discount`) <> ''";
        $sth = DB::connect()->query($sql);
        $array = $sth->fetchAll(PDO::FETCH_ASSOC);
        return $array;
    }

    function selectWhiteProduct($id) {
        $sql = "SELECT `product`.`id` as id, `product`.`name` as name, `product`.`cover` as cover, `product`.`price` as price, `product`.`quantity`, `shop`.`name` as shop, `global_categories`.`img` as img, `shop`.`id` as shop_id, `shop`.`rating` as shop_rating, `global_categories`.`name` as global_categories, `product`.`fake_rating` as product_fake_rating, `product`.`rating` as product_rating, `product`.`type_rating` as type_rating, `product`.`description` as description, `product`.`discount` FROM `shop` INNER JOIN `product` ON `shop`.`id` = `product`.`shop_id` INNER JOIN `global_categories`  ON `product`.`global_category` = `global_categories`.`id` WHERE product.id = ?";
        $sth = DB::connect()->prepare($sql);
        $sth->execute(array($id));
        $arrayProduct = $sth->fetch(PDO::FETCH_ASSOC);

        $sql = "SELECT * FROM `parameter_table` WHERE `parameter_table`.`id_product` = ?";
        $sth = DB::connect()->prepare($sql);
        $sth->execute(array($id));
        $arrayparameter_table = $sth->fetchAll(PDO::FETCH_ASSOC);

        $array = [
            "arrayProduct" => $arrayProduct,
            "arrayparameter_table" => $arrayparameter_table
        ];
        return $array;
    }
}