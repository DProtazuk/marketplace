<?php

require_once($_SERVER['DOCUMENT_ROOT'] . "/backend/Class/Role.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "/backend/Class/ApplicationsForSeller.php");
$role = Role::Check('admin');
if(!$role)
    header("Location: /");

require_once $_SERVER['DOCUMENT_ROOT']."/backend/database/DB.php";

if(isset($_POST['action'])) {
    $action = $_POST['action'];

    if($action === "select") {
        select();
    }
    if($action === "approve") {
        approve();
    }
}


function select() {
    $db = DB::connect();
    $db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);


    $limit = 5;

    $page = $_POST['page'];

    if ($page == 1) {
        $offset = 0;
    } else {
        $page = $page-1;
        $offset = $page * $limit;
    }

    $start =  date('Y-m-d 00:00:00', strtotime($_POST['start']));
    $finish = date('Y-m-d 23:59:59', strtotime($_POST['finish']));


    {
        $parameters = [];

        $sql = "SELECT
                    COUNT(*) as count
                FROM applications_for_seller
                JOIN status AS status_payment ON applications_for_seller.payment = status_payment.id
                JOIN status AS status_applications ON applications_for_seller.status = status_applications.id
                INNER JOIN `user` ON `applications_for_seller`.`unique_id` = `user`.`unique_id`
                INNER JOIN `contacts` ON `applications_for_seller`.`unique_id` = `contacts`.`unique_id`
                WHERE `applications_for_seller`.`status` = 2 AND `applications_for_seller`.`data` >= ? AND `applications_for_seller`.`data` <= ?";

        array_push($parameters, $start);
        array_push($parameters, $finish);

        if (!empty($_POST['search'])) {
            $search = $_POST['search'];
            $sql .= " AND (`user`.`unique_id` LIKE ? OR `user`.`name` LIKE ? OR `user`.`email` LIKE ?)";
            $key = '%' . $search . '%';
            array_push($parameters, $key);
            array_push($parameters, $key);
            array_push($parameters, $key);
        }

        $sql .= " ORDER BY `applications_for_seller`.`data` DESC";

        $query = $db->prepare($sql);
        $query->execute($parameters);
        $array =  $query->fetch();
        $count = $array['count'];
    }


    {
        $parameters = [];

        $sql = "SELECT
                    applications_for_seller.id,
                    applications_for_seller.unique_id,
                    applications_for_seller.data,
                    status_payment.name AS payment,
                    status_applications.name AS status,
                    user.name AS user_name,
                    user.email AS user_email,
                    contacts.telegram AS user_telegram
                FROM applications_for_seller
                JOIN status AS status_payment ON applications_for_seller.payment = status_payment.id
                JOIN status AS status_applications ON applications_for_seller.status = status_applications.id
                INNER JOIN `user` ON `applications_for_seller`.`unique_id` = `user`.`unique_id`
                INNER JOIN `contacts` ON `applications_for_seller`.`unique_id` = `contacts`.`unique_id`
                WHERE `applications_for_seller`.`status` = 2 AND `applications_for_seller`.`data` >= ? AND `applications_for_seller`.`data` <= ?";

        array_push($parameters, $start);
        array_push($parameters, $finish);

        if (!empty($_POST['search'])) {
            $search = $_POST['search'];
            $sql .= " AND (`user`.`unique_id` LIKE ? OR `user`.`name` LIKE ? OR `user`.`email` LIKE ?)";
            $key = '%' . $search . '%';
            array_push($parameters, $key);
            array_push($parameters, $key);
            array_push($parameters, $key);
        }

        $sql .= " ORDER BY `applications_for_seller`.`data` DESC";

        $sql .= " LIMIT ? OFFSET ?";

        array_push($parameters, $limit);
        array_push($parameters, $offset);

        $query = $db->prepare($sql);
        $query->execute($parameters);
        $array =  $query->fetchAll(PDO::FETCH_ASSOC);
    }


    $mass = [
        'data' => $array,
        'count' => $count
    ];

    echo json_encode($mass);
}


function approve() {
    $id = $_POST['id'];

    $arrayApplicationsForSeller = [
        'unique_id'=>$id,
        'status' => 1
    ];

    $ApplicationsForSeller = new ApplicationsForSeller();
    $ApplicationsForSeller->updateStatus($arrayApplicationsForSeller);

    $arrayRole = [
        'unique_id'=>$id,
        'seller' => 1
    ];

    $role = new Role();
    $role->Update($arrayRole);

    echo true;
}