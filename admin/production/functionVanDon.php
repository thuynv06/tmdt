<?php
if (isset($_POST['nhapkhovn'])) {
    $urlStr = "detailOrder.php?id=" . $_POST['idOrder'];

    $idOrder = $_POST['idOrder'];
    $date = $_POST['updateDateStatus'];
//    echo $date;
    $order = $orderRepository->getById($idOrder);
    //            echo(print_r($order, true));
    $arr_unserialize1 = unserialize($order['listsproduct']); // convert to array;
    //                            echo(print_r($arr_unserialize1, true));
    $arr = array();
    if (!empty($arr_unserialize1)) {
        foreach ($arr_unserialize1 as $masp) {
            $product = $kienhangRepository->getById($masp)->fetch_assoc();
            if ($product['status'] == 3) {
                $kienhangRepository->updateStatus($product['id'], $product['ladingCode'], 4, $date);
                $tempDate = DateTime::createFromFormat("Y-m-d\TH:i:s", $date);
                $tempDate = date_add($tempDate, date_interval_create_from_date_string("2 days"))->format("Y-m-d\TH:i:s");
                $kienhangRepository->updateStatus($product['id'], $product['ladingCode'], 5, $tempDate);
                array_push($arr, $product['ladingCode']);
                echo "<script>window.location.href='$urlStr';</script>";
            } else {
            }
        }
    }
}
if (isset($_POST['tqnhan'])) {
    $urlStr = "detailOrder.php?id=" . $_POST['idOrder'];

    $idOrder = $_POST['idOrder'];
    $date = $_POST['updateDateStatus'];
//    echo $date;
    $order = $orderRepository->getById($idOrder);
    //            echo(print_r($order, true));
    $arr_unserialize1 = unserialize($order['listsproduct']); // convert to array;
    //                            echo(print_r($arr_unserialize1, true));
    $arr = array();
    if (!empty($arr_unserialize1)) {
        foreach ($arr_unserialize1 as $masp) {
            $product = $kienhangRepository->getById($masp)->fetch_assoc();
            if ($product['status'] == 1) {
                $kienhangRepository->updateStatus($product['id'], $product['ladingCode'], 2, $date);
                $tempDate = DateTime::createFromFormat("Y-m-d\TH:i:s", $date);
                $tempDate = date_add($tempDate, date_interval_create_from_date_string("2 days"))->format("Y-m-d\TH:i:s");
                $kienhangRepository->updateStatus($product['id'], $product['ladingCode'], 3, $tempDate);
                array_push($arr, $product['ladingCode']);
                echo "<script>window.location.href='$urlStr';</script>";
            } else {
//                echo "<script>alert('Chỉ update khi hàng ở trạng thái shop gửi!');window.location.href='kienHang.php';</script>";
            }
        }
    }
}
if (isset($_POST['dagiao'])) {
    $urlStr = "detailOrder.php?id=" . $_POST['idOrder'];

    $idOrder = $_POST['idOrder'];
    $order = $orderRepository->getById($idOrder);
    //            echo(print_r($order, true));
    $arr_unserialize1 = unserialize($order['listsproduct']); // convert to array;
    //                            echo(print_r($arr_unserialize1, true));
    $arr = array();
    if (!empty($arr_unserialize1)) {
        foreach ($arr_unserialize1 as $masp) {
            $product = $kienhangRepository->getById($masp)->fetch_assoc();
            $obj = json_decode($product['listTimeStatus']);
            if (!empty($obj) && !empty($obj->{5}) && $product['status'] == 5) {
                $date = $obj->{5};
                $tempDate = DateTime::createFromFormat("Y-m-d\TH:i:s", $date);
                $tempDate = date_add($tempDate, date_interval_create_from_date_string("1 days"))->format("Y-m-d\TH:i:s");
                $kienhangRepository->updateStatus($product['id'], $product['ladingCode'], 6, $tempDate);
                array_push($arr, $product['ladingCode']);
                echo "<script>window.location.href='$urlStr';</script>";
            } else {
//                echo "<script>alert('Chỉ update khi hàng ở trạng thái shop gửi!');window.location.href='kienHang.php';</script>";
            }
        }
    }
}

if (isset($_POST['reset'])) {
    $urlStr = "detailOrder.php?id=" . $_POST['idOrder'];

    $idOrder = $_POST['idOrder'];
    $order = $orderRepository->getById($idOrder);
    //            echo(print_r($order, true));
    $arr_unserialize1 = unserialize($order['listsproduct']); // convert to array;
    //                            echo(print_r($arr_unserialize1, true));
    $arr = array();
    if (!empty($arr_unserialize1)) {
        foreach ($arr_unserialize1 as $masp) {
            $product = $kienhangRepository->getById($masp)->fetch_assoc();
            $kienhangRepository->resetStatus($product['id']);

        }
        echo "<script>window.location.href='$urlStr';</script>";
    } else {
//                echo "<script>alert('Chỉ update khi hàng ở trạng thái shop gửi!');window.location.href='kienHang.php';</script>";
    }
}

?>