<?php
//if (isset($_POST['shopgui'])) {
//    $idOrder = $_POST['idOrder'];
//    $date = $_POST['updateDateStatus'];
//    $order = $orderRepository->getById($idOrder);
//    if ($order['type'] == 0) {
//        $urlStr = "detailOrder.php?id=" . $_POST['idOrder'];
//    } else {
//        $urlStr = "detailKyGui.php?id=" . $_POST['idOrder'];
//    }
//    $arr_unserialize1 = unserialize($order['listsproduct']); // convert to array;
//    //                            echo(print_r($arr_unserialize1, true));
////    $arr = array();
//    if (!empty($arr_unserialize1)) {
//        foreach ($arr_unserialize1 as $masp) {
//            $product = $kienhangRepository->getById($masp)->fetch_assoc();
//            $kienhangRepository->updateStatus($product['id'], $product['ladingCode'], 1, $date);
////            array_push($arr, $product['ladingCode']);
//            echo "<script>window.location.href='$urlStr';</script>";
//        }
//    }
//}

if (isset($_POST['nhapkhovn'])) {
    $idOrder = $_POST['idOrder'];
//    $date = $_POST['updateDateStatus'];
//    echo $date;
    $order = $orderRepository->getById($idOrder);
    if ($order['type'] == 0) {
        $urlStr = "detailOrder.php?id=" . $_POST['idOrder'];
    } else {
        $urlStr = "detailKyGui.php?id=" . $_POST['idOrder'];
    }
    //            echo(print_r($order, true));
    $arr_unserialize1 = unserialize($order['listsproduct']); // convert to array;
    //                            echo(print_r($arr_unserialize1, true));
//    $arr = array();
    if (!empty($arr_unserialize1)) {
        foreach ($arr_unserialize1 as $mvd_id) {
            $mvdRepository->updateTimesById($mvd_id, 3,$_POST['updateDateStatus']);
            echo "<script>window.location.href='$urlStr';</script>";
//            $product = $kienhangRepository->getById($masp)->fetch_assoc();
//            if ($product['status'] == 3 || $product['status'] == 2) {
//                $kienhangRepository->updateStatus($product['id'], $product['ladingCode'], 4, $date);
//                $tempDate = DateTime::createFromFormat("Y-m-d\TH:i:s", $date);
////                $tempDate = date_add($tempDate, date_interval_create_from_date_string("2 days"))->format("Y-m-d\TH:i:s");
////                $kienhangRepository->updateStatus($product['id'], $product['ladingCode'], 5, $tempDate);
////                array_push($arr, $product['ladingCode']);
                echo "<script>window.location.href='$urlStr';</script>";


        }
    }
}
if (isset($_POST['tqnhan'])) {
    $idOrder = $_POST['idOrder'];
//    $date = $_POST['updateDateStatus'];
//    echo $date;
    $order = $orderRepository->getById($idOrder);
    if ($order['type'] == 0) {
        $urlStr = "detailOrder.php?id=" . $_POST['idOrder'];
    } else {
        $urlStr = "detailKyGui.php?id=" . $_POST['idOrder'];
    }
    //            echo(print_r($order, true));
    $arr_unserialize1 = unserialize($order['listsproduct']); // convert to array;
    //                            echo(print_r($arr_unserialize1, true));
//    $arr = array();
    if (!empty($arr_unserialize1)) {
        foreach ($arr_unserialize1 as $mvd_id) {
            $mvdRepository->updateTimesById($mvd_id, 1,$_POST['updateDateStatus']);
            echo "<script>window.location.href='$urlStr';</script>";
//            $product = $kienhangRepository->getById($masp)->fetch_assoc();
//            if ($product['status'] == 1) {
//                $kienhangRepository->updateStatus($product['id'], $product['ladingCode'], 2, $date);
//                $tempDate = DateTime::createFromFormat("Y-m-d\TH:i:s", $date);
//                $tempDate = date_add($tempDate, date_interval_create_from_date_string("2 days"))->format("Y-m-d\TH:i:s");
//                $kienhangRepository->updateStatus($product['id'], $product['ladingCode'], 3, $tempDate);
////                array_push($arr, $product['ladingCode']);
//                echo "<script>window.location.href='$urlStr';</script>";
//            } else {
////                echo "<script>alert('Chỉ update khi hàng ở trạng thái shop gửi!');window.location.href='kienHang.php';</script>";
//            }
        }
    }
}
if (isset($_POST['dagiaoall'])) {

    $idOrder = $_POST['idOrder'];
    $order = $orderRepository->getById($idOrder);
//    $date = $_POST['updateDateStatus'];

    if ($order['type'] == 0) {
        $urlStr = "detailOrder.php?id=" . $_POST['idOrder'];
    } else {
        $urlStr = "detailKyGui.php?id=" . $_POST['idOrder'];
    }
    //            echo(print_r($order, true));
    $arr_unserialize1 = unserialize($order['listsproduct']); // convert to array;
    //                            echo(print_r($arr_unserialize1, true));
//    $arr = array();
    if (!empty($arr_unserialize1)) {
        foreach ($arr_unserialize1 as $mvd_id) {
//            $ = $kienhangRepository->getById($masp)->fetch_assoc();
//            $obj = json_decode($product['listTimeStatus']);
//            if (!empty($obj) && !empty($obj->{4 }) && $product['status'] == 4) {
//                $date = $obj->{5};

            $mvdRepository->updateTimesById($mvd_id, 5,$_POST['updateDateStatus']);

//            $kienhangRepository->updateStatus($product['id'], $product['ladingCode'], 5, $date);

//            $tempDate = DateTime::createFromFormat("Y-m-d\TH:i:s", $date);
//            $tempDate = date_add($tempDate, date_interval_create_from_date_string("6 hours"))->format("Y-m-d\TH:i:s");
//            $kienhangRepository->updateStatus($product['id'], $product['ladingCode'], 6, $tempDate);
//            array_push($arr, $product['ladingCode']);
            echo "<script>window.location.href='$urlStr';</script>";
//            } else {
//                echo "<script>alert('Chỉ update khi hàng ở trạng thái shop gửi!');window.location.href='kienHang.php';</script>";
//            }
        }
    }
}

if (isset($_POST['reset'])) {

    $idOrder = $_POST['idOrder'];
    $order = $orderRepository->getById($idOrder);
    if ($order['type'] == 0) {
        $urlStr = "detailOrder.php?id=" . $_POST['idOrder'];
    } else {
        $urlStr = "detailKyGui.php?id=" . $_POST['idOrder'];
    }
    //            echo(print_r($order, true));
    $arr_unserialize1 = unserialize($order['listsproduct']); // convert to array;
    //                            echo(print_r($arr_unserialize1, true));
    $arr = array();
    if (!empty($arr_unserialize1)) {
        foreach ($arr_unserialize1 as $mvd_id) {
//            $product = $kienhangRepository->getById($masp)->fetch_assoc();
            $mvdRepository->resetStatus($mvd_id);

        }
        echo "<script>window.location.href='$urlStr';</script>";
    } else {
//                echo "<script>alert('Chỉ update khi hàng ở trạng thái shop gửi!');window.location.href='kienHang.php';</script>";
    }
}

?>