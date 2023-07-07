<?php
require_once("../../repository/kienhangRepository.php");
require_once("../../repository/orderRepository.php");
$khRepository = new KienHangRepository();
$orderRepository = new OrderRepository();
$urlStr = "detailOrder.php?id=" . $_GET['id'];
$order = $orderRepository->getById($_GET['id']);
if ($order['status']==0){
    $flag = true;
    $arr_unserialize1 = unserialize($order['listsproduct']);
    if (!empty($arr_unserialize1)) {
        foreach ($arr_unserialize1 as $masp) {
            $product = $khRepository->getById($masp)->fetch_assoc();
            if ($product['status'] != 5) {
                $flag = false;
                break;
            }
        }
    }
    if ($flag) {
        $order = $orderRepository->xuatDon($_GET['id']);
        echo "<script>alert('Xuất Đơn Hàng Thành Công');
        window.location.href='$urlStr';
        </script>";
    }else{
        echo "<script>alert('Tất cả mã vận đơn chưa chuyển trạng thái đã giao!!!');
                            window.location.href='$urlStr';
                            </script>";
    }
}else{
    $urlStr = "detailOrder.php?id=" . $_GET['id'];
    echo "<script>alert('Đơn Hàng Đã Xuất !');
        window.location.href='$urlStr';
        </script>";
}

?>