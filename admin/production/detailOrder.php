<?php include "headeradmin.php";

$loinhuan = 0;

if (isset($_POST['xuatphieu'])) {
    $order = $orderRepository->getById($_GET['id']);
//    echo $order['user_id'];
    include "phieuxuatkho.php";
    phieuxuatkho($_POST['listproduct'],$order['user_id']);
}

?>

<div class="right_col" role="main" style="font-size: 11px;">
    <a class="btn btn-primary" href="vandon.php" role="button">Trở Về</a>
    <div class="row" style="margin-left: 0px;">
        <form method="POST" enctype="multipart/form-data">
            <?php
            $order = $orderRepository->getById($_GET['id']);
//            echo dirname(__FILE__, 5);
//            echo dirname(__FILE__);
//            $temppath="..".dirname(__FILE__);
//            echo $temppath;
//            echo $order['listsproduct'];
            $arr_unserialize1 = unserialize($order['listsproduct']); // convert to array;
//                                        echo(print_r($arr_unserialize1, true));
//            print_r($arr_unserialize1,true);
//            $arr_unserialize1 = array_diff($arr_unserialize1, ["265"]);
//            echo(print_r($arr_unserialize1, true));
            $startdate = date("Y-m-d\TH:i:s", strtotime($order['startdate']));
//            if (!empty($arr_unserialize1)) {
//                foreach ($arr_unserialize1 as $masp) {
//                    $thanhtiennhap=0;
//                    $thanhtienban=0;
//                    $phidv=0;
//                    $product = $kienhangRepository->getById($masp)->fetch_assoc();
//                    $thanhtiennhap = $product['gianhap'] * $product['amount']* $order['giatenhap'] + $product['shiptq']* $order['giatenhap'] - $product['magiamgia']* $order['giatenhap'] - $product['giamgiacuahang']* $order['giatenhap'];
//                    $thanhtienban = $product['price'] * $product['amount'] * $order['tygiate'] + $product['shiptq'] * $order['tygiate'] - $product['magiamgia'] * $order['tygiate'];
//                    $phidv = $thanhtienban * $product['servicefee'];
////                    echo "thanhtien ban: ".$thanhtienban;
////                    echo "phi dv  : ".$phidv;
//                    $loinhuan += $thanhtienban + $phidv - $thanhtiennhap;
////                    echo $loinhuan;
////                    echo ">>> ";
//                }
//                $loinhuan = $loinhuan - $order['thukhac'];
//            }
            ?>
            <?php
            $listUser = $userRepository->getAll();
            foreach ($listUser as $user) {
                ?>
                <?php if ($user['id'] == $order['user_id']) {
                    $user_id = $user['id'];
                    $user_code = $user['code'];
                    $user_name = $user['username'];
                    $kh = $user;
                    break;
                }
            }
            function product_price($priceFloat)
            {
                $symbol = ' VNĐ';
                $symbol_thousand = '.';
                $decimal_place = 0;
                $price = number_format($priceFloat, $decimal_place, ',', $symbol_thousand);
                return $price . $symbol;
            }

            ?>
            <div class="row">
                <div class="col-md-4 table-responsive">
                    <h3>Thông Tin Khách Hàng</h3>
                    <table id="tableShoe">
                        <tr style="min-width:100px">
                            <th>Họ tên</th>
                            <td><input readonly class="form-control" value="<?php echo $kh['fullname'] ?>"></td>
                        </tr>
                        <tr style="min-width:100px">
                            <th>Mã Khách Hàng</th>
                            <td>
                                <select name="user_id" class="form-control">
                                    <?php
                                    $listUser = $userRepository->getAllByType(0);
                                    foreach ($listUser as $user) {
                                        ?>
                                        <option <?php if ($user['id'] == $kh['id']) echo "selected" ?>
                                                value="<?php echo $user['id']; ?>"><?php echo $user['code']; ?></option>
                                        <?php
                                    }
                                    ?>
                                </select>
                            </td>
                        </tr>
                        <tr style="min-width:100px">
                            <th>D.O.B</th>
                            <td><input readonly class="form-control" value="<?php echo $kh['dob'] ?>"></td>
                        </tr>
                        <tr style="min-width:100px">
                            <th>Email</th>
                            <td><input readonly class="form-control" value="<?php echo $kh['email'] ?>"></td>
                        </tr>
                        <tr style="min-width:100px">
                            <th>SĐT</th>
                            <td><input readonly class="form-control" value="<?php echo $kh['phone'] ?>"></td>
                        </tr>
                        <tr style="min-width:100px">
                            <th>Địa Chỉ</th>
                            <td><input readonly class="form-control" value="<?php echo $kh['address'] ?>"></td>
                        </tr>
                    </table>

                </div>
                <div class="col-md-4 table-responsive">
                    <h3>Tổng Quan Đơn Hàng</h3>
                    <table id="tableShoe">

                        <tr style="min-width:100px">
                            <th>ID</th>
                            <td><input readonly value="<?php echo $order['id'] ?>"
                                       name="orderId" type="text" class="form-control"></td>
                        </tr>
                        <tr class="form-group" style="min-width:100px">
                            <th>Tỷ Giá Tệ</th>
                            <td>
                                <input required min="0" max="99999999999" name="tygiate" type="number"
                                       class="form-control"
                                       step="0.01"
                                       id="exampleInputPassword1" value="<?php echo $order['tygiate'] ?>"
                                       placeholder="Nhập tỷ giá tệ: vd 3650"></td>
                        </tr>
                        <tr style="min-width:100px">
                            <th>Giá tệ nhập</th>
                            <td><input <?php if( $checkCookie['role']!=2) echo "disabled" ?> required min="0" max="99999999999" name="giatenhap" type="number"
                                       class="form-control"
                                       step="0.01"
                                       id="exampleInputPassword1" value="<?php if($checkCookie['role']==2) { echo $order['giatenhap'];} ?>"
                                ></td>
                        </tr>

                        <tr style="min-width:100px">
                            <th>Giá Vận Chuyển</th>
                            <td><input required min="0" max="99999999999" name="giavanchuyen" type="number" size="50"
                                       class="form-control"
                                       step="0.01"
                                       id="exampleInputPassword1" value="<?php echo $order['giavanchuyen'] ?>"
                                       placeholder="Nhập giá tiền"></td>
                        </tr>
                        <tr style="min-width:100px">
                            <th>Tiền Hàng</th>
                            <td><input readonly required min="0" max="99999999999" name="tongtienhangweb" type="number"
                                       class="form-control"
                                       step="0.01"
                                       id="exampleInputPassword1" value="<?php echo $order['tongtienhang'] ?>"></td>
                        </tr>
                        <tr style="min-width:100px">
                            <th>Tiền Ship TQ</th>
                            <td><input readonly required min="0" max="99999999999" name="tongtienhangweb" type="number"
                                       class="form-control"
                                       step="0.01"
                                       id="exampleInputPassword1" value="<?php echo $order['shiptq'] ?>"></td>
                        </tr>
                        <tr style="min-width:100px">
                            <th>Mã Giảm Giá</th>
                            <td><input readonly required min="0" max="99999999999" name="tongmagiamgia" type="number"
                                       step="0.01"
                                       class="form-control"
                                       id="exampleInputPassword1" value="<?php echo $order['giamgia'] ?>"
                                       placeholder="Nhập mã giảm giá"></td>
                        </tr>
                        <tr style="min-width:100px">
                            <th>Phí dịch vụ (%)</th>
                            <td><input readonly min="0" max="99999999999" name="phidichvu" type="number"
                                       class="form-control"
                                       step="0.01"
                                       id="exampleInputPassword1" value="<?php echo $order['phidichvu'] ?>"
                                ></td>
                        </tr>
                        <tr style="min-width:100px">
                            <th>Tiền Công</th>
                            <td><input readonly required min="0" max="99999999999" name="tongmagiamgia" type="number"
                                       step="0.01"
                                       class="form-control"
                                       id="exampleInputPassword1" value="<?php echo $order['tiencong'] ?>"></td>
                        </tr>
                        <tr style="min-width:100px">
                            <th>Ship về VN</th>
                            <td><input readonly min="0" max="99999999999" name="tienvanchuyen"
                                       value="<?php echo $order['tienvanchuyen'] ?>"
                                       type="number"
                                       step="0.01" class="form-control"
                                       id="exampleInputPassword1"></td>
                        </tr>
                        <tr style="min-width:100px">
                            <th>Ghi Chú</th>
                            <td><input value="<?php echo $order['ghichu'] ?>" minlength="1" maxlength="500" name="note"
                                       type="text"
                                       class="form-control"
                                       id="exampleInputPassword1" placeholder="Nhập ghi chú đơn hàng"></td>
                        </tr>
                    </table>
                </div>
                <div class="col-md-4 table-responsive">
                    <h3>Tổng</h3>
                    <table id="tableShoe">
                        <tr style="min-width:100px">
                            <th>Mã Đơn</th>
                            <td><input readonly value="<?php echo $order['code'] ?>"
                                       name="code" type="text" class="form-control"></td>
                        </tr>
                        <tr style="min-width:100px">
                            <th>Ngày Tạo</th>
                            <td><input  value="<?php echo $startdate ?>" name="startdate" type="datetime-local"
                                       step="1"
                                       class="form-control"
                                       id="startdate"></td>
                        </tr>
                        <tr style="min-width:100px">
                            <th>Ngày Xuất</th>
                            <td><input readonly name="enddate" value="<?php if(isset($order['enddate'])) echo $order['enddate'] ?>" type="datetime-local" step="1"
                                       class="form-control"
                                       id="enddate"></td>
                        </tr>
                        <tr style="min-width:100px">
                            <th>Tổng Kg</th>
                            <td><label for="exampleInputPassword1">Tổng KLG (Kg)</label>
                                <input required min="0" max="99999999999" value="<?php echo $order['tongcan'] ?>"
                                       name="tongcan"
                                       type="number" step="0.01"
                                       class="form-control"
                                       id="exampleInputPassword1" placeholder="Nhập số lượng"></td>
                        </tr>
                        <tr style="min-width:100px">
                            <th>Tổng Tiền</th>
                            <td><h6 for="" style="color: blue;font-weight: bold">
                                    <?php echo product_price($order['tongall']) ?></h6>
                            </td>
                        </tr>
                        <tr style="min-width:100px">
                            <th>Đã Thanh Toán</th>
                            <td><label style="color: #00CC00;font-weight: bold">Đã Ứng (VNĐ)
                                    - <?php echo product_price($order['tamung']) ?></label><input min="0"
                                                                                                  max="99999999999"
                                                                                                  name="tamung"
                                                                                                  value="<?php echo $order['tamung'] ?>"
                                                                                                  type="number"
                                                                                                  step="0.01"
                                                                                                  class="form-control"
                                                                                                  id="exampleInputPassword1">
                            </td>
                        </tr>
                        <tr style="min-width:100px">
                            <th>Còn Thiếu</th>
                            <td><label style="color: red;font-weight: bold">Công Nợ (VNĐ)
                                    - <?php echo product_price($order['tongall'] - $order['tamung']) ?></label></td>
                        </tr>
                        <tr style="min-width:100px">
                            <th>Trạng Thái</th>
                            <td><input style="font-weight: bold;color: blue" readonly value="<?php
                                switch ($order['status']) {
                                    case "0":
                                        echo "Chưa Xuất";
                                        break;
                                    case "1":
                                        echo "Đã Giao";
                                        break; ?><?php
                                } ?>"
                                       name="status" type="text" class="form-control"></td>
                        </tr>
                        <tr style="min-width:100px">
                            <th>Thu Khác</th>
                            <td><input min="0" max="99999999999" name="thukhac" type="number" step="0.01"
                                       class="form-control"
                                       id="exampleInputPassword1" value="<?php echo $order['thukhac'] ?>"
                                       placeholder="Nhập tiền thu khác"></td>
                        </tr>
                        <tr style="min-width:100px">
                            <th>Lợi Nhuận (VNĐ)</th>
                            <td>
                                <h4 style="color: green;font-weight: bold;margin-top: 6px; text-indent: 20px;"><?php if($checkCookie['role']==2) { echo product_price($loinhuan);} else echo "No Permistion" ?></h4>
                            </td>
                        </tr>


                    </table>
                </div>
                <div class="col-md-4">
                    <button <?php if ($order['status']==1) echo "disabled" ?> class="btn-sm btn-primary" type="submit" name="updateOrder"
                            href="detailOrder.php?id=<?php echo $order['id'] ?>"
                            role="button">Cập Nhật
                    </button>

                    <a  class="btn btn-success"  href="xuatdon.php?id=<?php echo $order['id'] ?>"
                       role="button" onclick="return confirm('Bạn có chắc chắn Xuất Đơn ?');">Xuất Đơn</a>

                    <button <?php if ($order['status']==1) echo "disabled" ?> class="btn-sm btn-danger" href="deleteOrder.php?id=<?php echo $order['id'] ?>"
                            type="submit" onclick="return confirm('Bạn có muốn xóa không?');">Xóa
                    </button>
                    <button <?php if ($order['status']==1) echo "disabled" ?> class="btn-sm btn-primary" type="submit" name="updatedMaVanDon"
                                                                              href="detailOrder.php?id=<?php echo $order['id'] ?>"
                                                                              role="button">Cập Nhật MVĐ
                    </button>


                </div>

            </div>
            <?php

            if (isset($_POST['updatedMaVanDon'])) {
                $arr_unserialize1 = unserialize($order['listsproduct']);
//                print_r($arr_unserialize1);
                    foreach ($arr_unserialize1 as $idKH) {
                        $product = $kienhangRepository->getById($idKH)->fetch_assoc();
//                        $tempMaVanDon=null;
                        if(!empty($product['mavandon']) && isset($product['mavandon'])){
                            $mvd =$mvdRepository->findByMaVanDon($product['mavandon']);
//                    print_r($mvd);
                            if (isset($mvd) && !empty($mvd) && !empty($product['mavandon']) && isset($product['mavandon'])){
                                $tempMaVanDon=$mvd->fetch_assoc();
//                                print_r($tempMaVanDon);
                                if(isset($tempMaVanDon) && !empty($tempMaVanDon)){
                                    $kienhangRepository->updateKienHangByMVD($idKH,$tempMaVanDon['id'],$tempMaVanDon['cannang'],$tempMaVanDon['giavc'],$tempMaVanDon['status'],$tempMaVanDon['times']);
                                }
//                        print_r($tempMaVanDon);
                            }
                        }
                    }
            }


            if (isset($_POST['updateOrder'])) {
                $tygiate = $order['tygiate'];
                if (!empty($_POST['tygiate'])) {
                    $tygiate = $_POST['tygiate'];
                }
                $giatenhap = $order['giatenhap'];
                if (!empty($_POST['giatenhap'])) {
                    $giatenhap = $_POST['giatenhap'];
                }
                $giavanchuyen = $order['giavanchuyen'];
                if (!empty($_POST['giavanchuyen'])) {
                    $giavanchuyen = $_POST['giavanchuyen'];
                }
                $phidichvu = $order['phidichvu'];
                if (!empty($_POST['phidichvu'])) {
                    $phidichvu = $_POST['phidichvu'];
                }
                $phidichvu = $order['phidichvu'];
                if (!empty($_POST['phidichvu'])) {
                    $phidichvu = $_POST['phidichvu'];
                }
                $tamdung = $order['tamung'];
                if (!empty($_POST['phidichvu'])) {
                    $tamdung = $_POST['tamung'];
                }
                $ghichu = $order['ghichu'];
                if (!empty($_POST['note'])) {
                    $ghichu = $_POST['note'];
                }
                if (!empty($_POST['user_id'])) {
                    $user_id = $_POST['user_id'];
                }

                if (!empty($_POST['startdate'])) {
//                    $startdate = $_POST['startdate'];
                    $sdate = date("Y-m-d\TH:i:s", strtotime($_POST['startdate']));

                }

                $arr_unserialize1 = unserialize($order['listsproduct']); // convert to array;
                //
                //                            echo(print_r($arr_unserialize1, true));
                $tongcan = 0;
                $tongtienhang = 0;
                $listproduct = array();
                $shiptq = 0;
                $tongall = 0;
                $giamgia = 0;
                $tienvanchuyen = 0;
                $tongcan = 0;
                if (!empty($arr_unserialize1)) {
                    foreach ($arr_unserialize1 as $masp) {
                        $product = $kienhangRepository->getById($masp)->fetch_assoc();
                        $tongtienhang += $product['giasp'] * $product['soluong'];
                        $shiptq += $product['shiptq'];
                        $tongcan += $product['cannang'];
                        $giamgia += $product['magiamgia'];
                    }
                }
                $tienvanchuyen += $tongcan * $giavanchuyen;
                $tiencong = ($tongtienhang + $shiptq-$giamgia) * $phidichvu;
                $tongall = ($tongtienhang + $shiptq + $tiencong - $giamgia) * $tygiate + $tienvanchuyen;

                if (isset($_POST['tongcan']) && !empty($_POST['tongcan'])) {
                    $tongcan = $_POST['tongcan'];
                    $tienvanchuyen = $tongcan * $giavanchuyen;
                    $tongall = ($tongtienhang + $shiptq + $tiencong - $giamgia) * $tygiate + $tienvanchuyen;

                }

                $orderRepository->update($_POST['orderId'],$user_id, $giatenhap, $tygiate, $giavanchuyen, $phidichvu, $tongcan, $tamdung, $tongtienhang,
                    $shiptq, $giamgia, $tienvanchuyen, $tiencong, $tongall, $ghichu, $arr_unserialize1,$sdate);
                echo "<script>window.location.href='$urlStr';</script>";
            }
            ?>

        </form>
    </div>
    <button <?php if ($order['status']==1) echo "disabled" ?> class="btn-sm btn-success" id="modalVanDon" data-toggle="modal"
            data-target="#vandon" data-id="<?php echo $order['id'] ?>"
            role="button" onclick="openVanDon()">Vận Đơn
    </button>
<!--    <button  --><?php //if ($order['status']==1) echo "disabled" ?><!--  class="btn-sm btn-warning" id="modalMaVanDon" data-toggle="modal"-->
<!--                                                                data-target="#mavandon" data-id="--><?php //echo $order['id'] ?><!--"-->
<!--                                                                role="button" onclick="openUpdateAllMVD()">Update All MVĐ-->
<!--    </button>-->


    <h3>Danh Sách Sản Phẩm</h3>
    <div class="row">
        <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12 ">
            <form name="search" class="form-inline ps-subscribe__form" method="POST"
                  enctype="multipart/form-data">
                <div class="form-group">
                    <input required style="margin-right: 20px; margin-bottom: 5px;"
                           class="form-control input-large " name="mavandon"
                           type="text" value="" placeholder="Nhập Mã Vận Đơn">
                </div>
                <div class="form-group">
                    <select style="margin-right: 20px; margin-bottom: 5px;" name="trangthai"
                            class="form-select custom-select" onchange="searchStatus()">
                        <?php
                        $listStatus = $statusRepository->getAll();
                        foreach ($listStatus as $status) {
                            ?>
                            <option value="<?php echo $status['status_id']; ?>"><?php echo $status['name']; ?></option>
                            <?php
                        }
                        ?>
                    </select>
                </div>
                <button class="btn btn--green btn-th" style="background-color: #ff6c00;margin-right: 20px; ">
                     Tra Cứu
                </button>
                <a style="" href="detailOrder.php?id=<?php echo $_GET['id']?>" class="btn btn-primary btn-large btn-th">RELOAD</a>
            </form>
        </div>
        <form method="POST" enctype="multipart/form-data">

            <button class="btn-sm btn-primary" type="submit" name="xuatphieu"
                    role="button">Xuất Phiếu
            </button>
<!--            <button class="btn-sm btn-primary" type="submit" name="addKienHang"-->
<!--                    role="button">Thêm Sản Phẩm-->
<!--            </button>-->
            <button <?php if ($order['status']==1) echo "disabled" ?>  type="button" id="modalthemSP" class="btn btn-primary btn-sm"
                    data-toggle="modal"
                    data-target="#modalThemSanPham" data-id="<?php echo $order['id'] ?>"
                    onclick="openModalThemSanPham()">
                Thêm Sản Phẩm
            </button>
            <div class="table-responsive">
                <table id="tableShoe">
                    <tr>
                        <th class="text-center" style="min-width:50px">STT</th>
                        <th class="text-center" style="min-width:50px"><input onclick="clickAll()" type="checkbox"
                                                                              id="selectall"/>All
                        </th>
                        <th class="text-center" style="min-width:95px;">Mã Kiện</th>
                        <th class="text-center" style="min-width:130px">Tên Kiện Hàng</th>
                        <th class="text-center" style="min-width:95px;">Ảnh</th>
                        <th class="text-center" style="min-width:100px">Mã Vận Đơn</th>
                        <!--                <th class="text-center" style="min-width:100px">Khách Hàng</th>-->
                        <th class="text-center" style="min-width:50px">Giá</th>
                        <th class="text-center" style="min-width:50px">Số Lượng</th>
                        <th class="text-center" style="min-width:50px">Cân nặng</th>
                        <!--                    <th class="text-center" style="min-width:100px">Đường Vận Chuyển</th>-->
                        <th class="text-center" style="min-width:90px">Lộ Trình</th>
                        <th class="text-center" style="min-width:130px">Chi tiết</th>
                        <th class="text-center" style="min-width:50px">Link SP</th>
                        <th class="text-center" style="min-width:50px">Ghi Chú</th>
                        <th class="text-center" style="min-width:50px"></th>
                        <th class="text-center" style="min-width:50px"></th>
                        <th class="text-center" style="min-width:50px"></th>
                    </tr>
                    <?php
                    $arr = array();
                    if (isset($_POST['mavandon']) && !empty($_POST['mavandon'])) {
//                        echo "tim mvd";
                        $tempList = $kienhangRepository->findByMaVanDonAndOrderId($_POST['mavandon'], $_GET['id']);
                        foreach ($tempList as $p) {
                            array_push($arr, $p['id']);
//                            echo(print_r($arr, true));
                        }
                    } else if (isset($_POST['trangthai'])) {
//                        echo "trang thai";
                        $arr = array();
                        $tempList = $kienhangRepository->findByStatusAndOrderId($_POST['trangthai'], $_GET['id']);
                        foreach ($tempList as $p) {
                            array_push($arr, $p['id']);
                        }
//                        echo(print_r($arr, true));
                    } else if (!empty($_GET['mvd'])) {
                       $tempList = $kienhangRepository->findByMaVanDonAndOrderId($_GET['mvd'], $_GET['id']);
                        foreach ($tempList as $p) {
                            array_push($arr, $p['id']);
                        }
                    }else{
//                        echo "macdinh";
                        $order = $orderRepository->getById($_GET['id']);
                        $arr = unserialize($order['listsproduct']);// convert to array;
//                        echo(print_r($arr, true));
                    }
                    //                            echo(print_r($arr_unserialize1, true));
                    if (!empty($arr)) {
                        $i = 1;
                        foreach ($arr as $masp) {
                            $product = $kienhangRepository->getById($masp)->fetch_assoc();
                            $tempMaVanDon=null;
                            if(isset($product )){
                                $link_image = $kienhangRepository->getImage($product['id'])->fetch_assoc();
                                $mvd =$mvdRepository->findByMaVanDon($product['mavandon']);
                                if (isset($mvd) && !empty($mvd) && !empty($product['mavandon']) && isset($product['mavandon'])){
                                    $tempMaVanDon=$mvd->fetch_assoc();
//                        print_r($tempMaVanDon);
                                }
                            }

                            //                    echo(print_r($product, true));?>

                    <tr>
                                <td><?php echo $i++; ?></td>
                                <td><input type="checkbox" name="listproduct[]" value="<?php if (!empty($tempMaVanDon)) { echo $tempMaVanDon['id'];}  ?>"
                                           id=""> Chọn
                                </td>
                                <td><p style="font-weight: 700;"><?php echo $product['code'] ?></p>
                                    <p style="color: blue"> <?php
                                        switch ($product['status']) {
                                            case "0":
                                                echo "Chờ Phát Hàng";
                                                break;
                                            case "1":
                                                echo "Kho TQốc Nhận";
                                                break;
                                            case "2":
                                                echo "Đang Vận Chuyển";
                                                break;
                                            case "3":
                                                echo "Nhập Kho VN";
                                                break;
                                            case "4":
                                                echo "Đang Giao";
                                                break;
                                            case "5":
                                                echo "Đã Giao";
                                                break;
                                            default:
                                                echo "Đang updated...";
                                        }
                                        ?> </p>
                                    <p><?php echo $product['line'] ?></p>
                                </td>
                                <td><?php echo $product['name'] ?></td>
                                <td><img width="150px" height="150px"
                                         src="<?php if (!empty($link_image['link_image']) && isset($link_image['link_image'])) echo $link_image['link_image'];
                                         if (empty($link_image['link_image'])) echo 'images/LogoTHzz.png' ?>"></td>
                                <td style="font-weight: bold;color: blue"><?php echo $product['mavandon'] ?></td>
                                <!--                        <td>-->
                                <!--                            --><?php
                                //                            $listUser = $userRepository->getAll();
                                //                            foreach ($listUser as $user) {
                                //                                if ($user['id'] == $product['user_id']) {
                                //                                    ?>
                                <!--                                    <p>-->
                                <?php //echo $user['username'] ?><!--</p>-->
                                <!--                                    <p style="color: blue;font-weight: bold">-->
                                <?php //echo $user['code'] ?><!--</p>-->
                                <!--                                --><?php //}
                                //                            }
                                //                            ?>
                                <!--                        </td>-->
                                <td><p style="color:red;font-weight: 700"><?php echo $product['giasp'] ?><span> &#165;</span></p>
                                    <p style="color:green;font-weight: 700"><?php echo $product['gianhap'] ?><span> &#165;</span></p>
                                </td>
                                <td><?php echo $product['soluong'] ?></td>
                                <td><p style="font-weight: 700"><?php echo $product['cannang'] ?> <span>/Kg</span></p>
                                    <button <?php if ($order['status']==1) echo "disabled" ?> type="button" id="modalUpdateS" class="btn-sm btn-primary "
                                            data-toggle="modal"
                                            data-target="#suacannang" data-id="<?php echo $product['id'] ?>"
                                            onclick="openModalSuaCan()">
                                        Sửa Giá/Cân
                                    </button>
                                </td>
                                <td>
                                    <ul style="text-align: left ;">
<!--                                        <li><p class="fix-status">Shop Gửi</p></li>-->
                                        <li><p class="fix-status">TQ Nhận</p></li>
                                        <li><p class="fix-status">Vận Chuyển </p></li>
                                        <li><p class="fix-status">NhậpKho VN</p></li>
                                        <li><p class="fix-status">Yêu cầu giao</p></li>
                                        <li><p class="fix-status">Đã giao </p></li>
                                    </ul>
                                </td>
                                <td><?php $obj=null; if (!empty($tempMaVanDon['times'])) { $obj = json_decode($tempMaVanDon['times']);} ?>

                                     <?php if (empty($obj)) { ?>
                                        <ul style="text-align: left;">
<!--                                            <li><p class="fix-status">............</p></li>-->
                                            <li><p class="fix-status">............</p></li>
                                            <li><p class="fix-status">............</p></li>
                                            <li><p class="fix-status">............</p></li>
                                            <li><p class="fix-status">............</p></li>
                                            <li><p class="fix-status">............</p></li>
                                        </ul><?php
                                    } else { ?>
                                        <ul style="text-align: left;">
<!--                                            <li><p class="fix-status">............</p></li>-->
                                            <li><p class="fix-status"><?php if (!empty($obj->{1})) echo $obj->{1}; ?>
                                            </li>
                                            <li>
                                                <p class="fix-status"><?php if (!empty($obj->{2})) echo $obj->{2}; ?></p>
                                            </li>
                                            <li>
                                                <p class="fix-status"><?php if (!empty($obj->{3})) echo $obj->{3}; ?></p>
                                            </li>
                                            <li>
                                                <p class="fix-status"><?php if (!empty($obj->{4})) echo $obj->{4}; ?></p>
                                            </li>
                                            <li>
                                                <p class="fix-status"><?php if (!empty($obj->{5})) echo $obj->{5}; ?></p>
                                            </li>
<!--                                            <li>-->
<!--                                                <p class="fix-status">--><?php //if (!empty($obj->{6})) echo $obj->{6}; ?><!--</p>-->
<!--                                            </li>-->
                                        </ul>
                                        <?php
                                    } ?>
                                </td>
                                <td><a href="<?php echo $product['linksp'] ?>">Link</a></td>
                                <td><?php echo $product['note'] ?></td>
                                <td>
                                    <button <?php if ($order['status']==1) echo "disabled" ?> type="button" id="modalUpdateS" class="btn btn-primary btn-sm"
                                            data-toggle="modal"
                                            data-target="#myModal" data-id="<?php echo $product['id'] ?>"
                                            onclick="openModal()">
                                        Cập Nhập
                                    </button>
                                </td>
                                <td><a class="btn btn-warning" <?php if ($order['status']==0) echo "href=".'"'."updateKH.php?id=".$product['id'].'"' ?>
                                       role="button">Sửa</a></td>
                                <td><a class="btn btn-danger" <?php if ($order['status']==0) echo "href=".'"'."deleteKienHang.php?id=".$product['id']."&orderId=".$order['id'].'"' ?>
                                       role="button" <?php if ($order['status']==0) echo "onclick=".'"'."return confirm('Bạn có muốn xóa không?')".'"' ?> >Xóa</a></td>
                                </tr>


                            <?php


                            if (isset($_POST['submit'])) {
                                $kienhangRepository->updateStatus($_POST['idKH'], $_POST['ladingCode'], $_POST['status_id'], $_POST['updateDateStatus']);
                                $urlStr = "detailOrder.php?id=" . $_GET['id']."&mvd=".$_POST['ladingCode'];
                                echo "<script>window.location.href='$urlStr';</script>";
                            }
                            if (isset($_POST['khotq'])) {
                                if ($_POST['status_id'] < 5) {
                                    $kienhangRepository->updateStatus($_POST['idKH'], $_POST['ladingCode'], 2, $_POST['updateDateStatus']);
                                    $tempDate = DateTime::createFromFormat("Y-m-d\TH:i:s", $_POST['updateDateStatus']);
                                    $tempDate = date_add($tempDate, date_interval_create_from_date_string("2 days"))->format("Y-m-d\TH:i:s");
                                    $kienhangRepository->updateStatus($_POST['idKH'], $_POST['ladingCode'], 3,$tempDate );
                                    $urlStr = "detailOrder.php?id=" . $_GET['id']."&mvd=".$_POST['ladingCode'];
//                                    $kienhangRepository->updatekhoTQNhan($_POST['idKH'],$_POST['updateDateStatus']);
                                    echo "<script>window.location.href='$urlStr';</script>";
                                } else {
                                    echo "<script>alert('Chỉ update khi hàng ở trạng thái shop gửi!');window.location.href='$urlStr';</script>";
                                }

                            }
                            if (isset($_POST['khovn'])) {
                                if ($_POST['status_id'] == 2 || $_POST['status_id'] == 3) {
                                    $kienhangRepository->updateStatus($_POST['idKH'], $_POST['ladingCode'], 4, $_POST['updateDateStatus']);
//                                    $tempDate = date_add($date, date_interval_create_from_date_string("1 days"))->format("Y-m-d\TH:i:s");
//                                    $kienhangRepository->updateStatus($_POST['idKH'], $_POST['ladingCode'], 5, $tempDate); update đang giao hàng
                                    $urlStr = "detailOrder.php?id=" . $_GET['id']."&mvd=".$_POST['ladingCode'];

                                    echo "<script>window.location.href='$urlStr';</script>";
                                } else {
                                    echo "<script>alert('Chỉ update khi hàng ở trạng thái nhập kho VN hoặc đang VC!');window.location.href='$urlStr';</script>";
                                }

                            }
                            ?>

                            <?php
                            if (isset($_POST['dagiao'])) {
                                if ($_POST['status_id'] == 4 || $_POST['status_id'] == 5) {
                                    $tempDate = DateTime::createFromFormat("Y-m-d\TH:i:s", $_POST['updateDateStatus']);
                                    $kienhangRepository->updateStatus($_POST['idKH'], $_POST['ladingCode'], 5, $_POST['updateDateStatus']);
                                    $tempDate = date_add($tempDate, date_interval_create_from_date_string("1 days"))->format("Y-m-d\TH:i:s");
                                    $kienhangRepository->updateStatus($_POST['idKH'], $_POST['ladingCode'], 6, $tempDate);
                                    $urlStr = "detailOrder.php?id=" . $_GET['id']."&mvd=".$_POST['ladingCode'];
                                    echo "<script>window.location.href='$urlStr';</script>";
                                } else {
                                    echo "<script>alert('Chỉ update khi hàng ở trạng thái nhập kho TQ hoặc đang VC!');window.location.href='$urlStr';</script>";
                                }
                            }
                            ?>
                            <?php
                            if (isset($_POST['resetStatus'])) {
                                $kienhangRepository->resetStatus($_POST['idKH']);
                                $urlStr = "detailOrder.php?id=" . $_GET['id']."&mvd=".$_POST['ladingCode'];
                                echo "<script>window.location.href='$urlStr';</script>";
                            }
                            ?>
                            <?php
                        }
                    }
                    ?>
                </table>
                <div>
        </form>
    </div>
    <?php include 'footeradmin.php' ?>

</div>
<div id="myModal" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <form action="" id="edit-form" method="POST" enctype="multipart/form-data">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Cập Nhập Trạng Thái Kiện Hàng</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                    <div class="form-group">
                        <label>ID</label>
                        <input class="form-control" name="idKH" type="number" value="" readonly>
                    </div>
                    <div class="form-group">
                        <label>Mã Kiện Hàng</label>
                        <input required value="" minlength="5" maxlength="250" name="orderCode" type="text"
                               class="form-control" disabled>
                    </div>
                    <div class="form-group">
                        <label>Mã Vận Đơn</label>
                        <input required value="" minlength="5" maxlength="250" name="ladingCode" type="text"
                               class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Status</label>
                        <select name="status_id" class="form-control">
                            <?php
                            $listStatus = $statusRepository->getAll();
                            foreach ($listStatus as $status) {
                                ?>
                                <option value="<?php echo $status['status_id']; ?>"><?php echo $status['name']; ?></option>
                                <?php
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Chọn Thời Gian</label>
                        <input value="" name="updateDateStatus" type="datetime-local" step="1"
                               class="form-control" id="updateDate">
                    </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button id="btnSaveChangeStautus" name="submit" type="submit" class="btn btn-primary" data-id="">
                    Lưu
                </button>
                <button id="btnSaveChangeStautus" name="khotq" type="submit" class="btn btn-success" data-id="">
                    KhoTQ Nhận
                </button>
                <button id="btnSaveChangeStautus" name="khovn" type="submit" class="btn btn-success" data-id="">
                    NhậpKho VN
                </button>

                <button id="btnSaveAllStatus" name="dagiao" type="submit" class="btn btn-warning" data-id="">
                    Đã Giao
                </button>
                <button id="btnResetStatus" name="resetStatus" type="submit" class="btn btn-danger" data-id="">
                    Reset
                </button>
            </div>
            </form>
        </div>
    </div>
</div>

<div id="suacannang" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Cập Nhập Trạng Thái Kiện Hàng</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
            </div>
            <form action="" id="edit-form" method="POST" enctype="multipart/form-data">
                <div class="modal-body">

                    <div class="form-group">
                        <label>ID</label>
                        <input class="form-control" name="idKH" type="number" value="" readonly>
                    </div>
<!--                    <div class="form-group">-->
<!--                        <label>Mã Kiện Hàng</label>-->
<!--                        <input required value="" minlength="5" maxlength="250" name="orderCode" type="text"-->
<!--                               class="form-control" disabled>-->
<!--                    </div>-->
                    <div class="form-group">
                        <label>Mã Vận Đơn</label>
                        <input readonly required value="" minlength="5" maxlength="250" name="ladingCode" type="text"
                               class="form-control">
                    </div>
<!--                    <div class="form-group">-->
<!--                        <label>Status</label>-->
<!--                        <select readonly name="status_id" class="form-control">-->
<!--                            --><?php
//                            $listStatus = $statusRepository->getAll();
//                            foreach ($listStatus as $status) {
//                                ?>
<!--                                <option value="--><?php //echo $status['status_id']; ?><!--">--><?php //echo $status['name']; ?><!--</option>-->
<!--                                --><?php
//                            }
//                            ?>
<!--                        </select>-->
<!--                    </div>-->
                    <div class="form-group">
                        <label class="radio-container m-r-45">Hàng TMDT
                            <input id="tmdt" onclick="checkButton()" type="radio" value=1 name="type">
                            <span class="checkmark"></span>
                        </label>
                        <label class="radio-container">Hàng KM
                            <input id="km" onclick="checkButton()" type="radio" value=0 name="type">
                            <span class="checkmark"></span>
                        </label>
                        <input  value="" minlength="5" maxlength="250" id="giavc" name="giavchuyen" type="number"
                                class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Số KLG</label>
                        <input  autofocus value="00" minlength="1" maxlength="250" name="socan" type="number" step="0.01"
                               class="form-control" placeholder="Nhập số cân">
                    </div>
                    <div class="form-group">
                        <label>Giá Nhập</label>
                        <input  value="00" minlength="1" maxlength="250" name="gianhap" type="number"
                               step="0.01"
                               class="form-control" placeholder="Nhập Giá Nhập">
                    </div>
                    <div class="form-group">
                        <label>Giảm giá cửa hàng</label>
                        <input  value="00" minlength="1" maxlength="250" name="giamgiacuahang" type="number"
                               step="0.01"
                               class="form-control" placeholder="Nhập tiền giảm giá cửa hàng">
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button id="xxx" name="suacan" type="submit" class="btn btn-primary" data-id="">
                        Lưu
                    </button>
                </div>
                <?php
                if (isset($_POST['suacan'])) {
                    $p = $kienhangRepository->getById($_POST['idKH'])->fetch_assoc();
                    $order = $orderRepository->getById($p['order_id']);
                    $kienhangRepository->updateCanNang($_POST['idKH'], $_POST['socan'], $_POST['gianhap'], $_POST['giamgiacuahang']);
                    $kienhangRepository->updateGiaVC($_POST['idKH'],$_POST['giavchuyen']);
                    $tongcan = 0;
                    $tienvanchuyen=0;
                    if (!empty($arr_unserialize1)) {
                        foreach ($arr_unserialize1 as $masp) {
                            $product = $kienhangRepository->getById($masp)->fetch_assoc();
                            $tongcan += $product['cannang'];
                            $tienvanchuyen += $product['cannang'] * $product['giavc'];
                        }
                    }
//                    $tienvanchuyen = $tongcan * $order['giavanchuyen'];
                    $tongall = ($order['tongtienhang'] + $order['shiptq'] + $order['tiencong'] - $order['giamgia']) * $order['tygiate'] + $tienvanchuyen;
                    $orderRepository->updateCan($p['order_id'], $tongcan, $tienvanchuyen, $tongall);

                    $urlStr = "detailOrder.php?id=" . $_GET['id']."&mvd=".$_POST['ladingCode'];;
                    echo "<script>window.location.href='$urlStr';</script>";
                }

                ?>
            </form>
        </div>
    </div>
</div>

<div id="vandon" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Cập Nhập Trạng Thái Đơn Hàng</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <form action="" id="edit-form" method="POST" enctype="multipart/form-data">
                    <div class="form-group">
                        <label>ID</label>
                        <input class="form-control" id="idOrder" name="idOrder" type="number" value="" readonly>
                    </div>
                    <div class="form-group">
                        <label>Chọn Thời Gian</label>
                        <input value="" name="updateDateStatus" type="datetime-local" step="1"
                               class="form-control" id="timeVanDon">
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button id="btnSaveChangeStautus" name="shopgui" type="submit" class="btn btn-success" data-id="">
                    ShopGui
                </button>
                <button id="btnSaveChangeStautus" name="tqnhan" type="submit" class="btn btn-success" data-id="">
                    KhoTQ Nhận
                </button>
                <button id="btnSaveChangeStautus" name="nhapkhovn" type="submit" class="btn btn-success" data-id="">
                    NhậpKho VN
                </button>
                <button id="btnSaveChangeStautus" name="dagiaoall" type="submit" class="btn btn-success" data-id="">
                    Đã Giao
                </button>
                <button id="btnSaveChangeStautus" name="reset" type="submit" class="btn btn-danger" data-id="">
                    Reset
                </button>
            </div>
        </form>
        </div>
    </div>
</div>

<div id="modalThemSanPham" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Thêm Sản Phẩm  </h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
            </div>
            <form action="" id="ThemSanPham" method="POST" enctype="multipart/form-data">
                <div class="modal-body">

                    <div class="form-group">
                        <label>Mã Đơn Hàng</label>
                        <input class="form-control" name="orderID" id="orderID" type="number" value="" readonly>
                    </div>
                    <div class="form-group">
                        <label>Têm Sản Phẩm</label>
                        <input required value="" minlength="5" maxlength="500" name="tensanpham" type="text"
                               class="form-control" >
                    </div>
                    <div class="form-group">
                        <label>Mã Vận Đơn</label>
                        <input  required value="" minlength="5" maxlength="250" name="ladingCode" type="text"
                               class="form-control">
                    </div>

                    <div class="form-group">
                        <label>Số Lượng</label>
                        <input required value="1" minlength="1" maxlength="250" name="soluong" type="number" step="1"
                               class="form-control" placeholder="Nhập số lương">
                    </div>
<!--                    <div class="form-group">-->
<!--                        <label>Status</label>-->
<!--                        <select readonly name="status_id" class="form-control">-->
<!--                            --><?php
//                            $listStatus = $statusRepository->getAll();
//                            foreach ($listStatus as $status) {
//                                ?>
<!--                                <option value="--><?php //echo $status['status_id']; ?><!--">--><?php //echo $status['name']; ?><!--</option>-->
<!--                                --><?php
//                            }
//                            ?>
<!--                        </select>-->
<!--                    </div>-->
                    <div class="form-group">
                        <label>Kg/Khối</label>
                        <input  value="0" minlength="1" maxlength="250" name="khoiluong" type="number" step="0.01"
                                class="form-control" placeholder="Nhập số cân nang">
                    </div>
                    <div class="form-group">
                        <label>Chọn Thời Gian</label>
                        <input value="" name="dateCreate" type="datetime-local" step="1"
                               class="form-control" id="timeadd">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button id="xxx" name="themsanpham" type="submit" class="btn btn-primary" data-id="">
                        Thêm Sản Phẩm
                    </button>
                </div>
                <?php
                if (isset($_POST['themsanpham'])) {
                    $orderId= $_POST['orderID'];
                    $o = $orderRepository->getById($orderId);
                    if (!empty($_POST['dateCreate'])) {
//                    $startdate = $_POST['startdate'];
                        $dateCreadted = date("Y-m-d\TH:i:s", strtotime($_POST['dateCreate']));
//                            echo $startdate;
                    }
                    $myObj = new stdClass();
                    $myObj->{1} = "$dateCreadted";
                    $listStatusJSON = json_encode($myObj);

                    $kienhang_id = $kienhangRepository->insert($orderId, 0, 0, $_POST['tensanpham'], null, $_POST['ladingCode'], $_POST['soluong'], "BT/HN1",  $_POST['khoiluong'], $o['giavanchuyen'], 1, 0, 0, $o['user_id'], $_POST['linksanpham'], 0, $dateCreadted, $listStatusJSON, 0, 0, 0, 0);
                    $arrayList =$orderRepository-> getListProductById($orderId);
                    $arr_unserialize1 = unserialize($arrayList['listsproduct']);
                    array_push($arr_unserialize1, $kienhang_id);
                    $orderRepository->updatedListProductById($orderId,$arr_unserialize1);
                    $kienhangRepository->updateMaKien($kienhang_id);
                    $urlStr = "detailOrder.php?id=" . $orderId;
                    echo "<script>alert('Thêm thành công');window.location.href='$urlStr';</script>";
                }
                ?>
            </form>
        </div>
    </div>
</div>

<div id="mavandon" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Cập nhập tất cả MVĐ  </h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
            </div>
            <form action="" id="updateMVD" method="POST" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="form-group">
                        <label>ID</label>
                        <input class="form-control" id="order_ID" name="order_ID" type="number" value="" readonly>
                    </div>
                    <div class="form-group">
                        <label>Mã Vận Đơn</label>
                        <input class="form-control" name="mavandon"  type="text" value="" >
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button id="xxx" name="updateMVD" type="submit" class="btn btn-primary" data-id="">
                            Update All MVD
                        </button>
                    </div>
            </form>
            <?php
            if (isset($_POST['updateMVD'])) {
                if (isset($_POST['mavandon'])){
                    $order_Id= $_POST['order_ID'];
                    echo $order_Id;
                    $kienhangRepository->updateAllMVDByOrderId($order_Id,$_POST['mavandon']);
                    $urlStr = "detailOrder.php?id=" . $order_Id;
                    echo "<script>window.location.href='$urlStr';</script>";
                }
            }
            ?>

        </div>
    </div>
</div>

<?php include 'functionVanDon.php';

ob_end_flush();
?>
<script>
    function get() {
        $(document).delegate("[data-target='#myModal']", "click", function () {

            var id = $(this).attr('data-id');

            // Ajax config
            $.ajax({
                type: "GET", //we are using GET method to get data from server side
                url: 'getKienHang.php', // get the route value
                data: {id: id}, //set data
                beforeSend: function () {//We add this before send to disable the button once we submit it so that we prevent the multiple click

                },
                success: function (response) {//once the request successfully process to the server side it will return result here
                    response = JSON.parse(response);
                    $("#edit-form [name=\"idKH\"]").val(response.id);
                    $("#edit-form [name=\"orderCode\"]").val(response.code);
                    $("#edit-form [name=\"ladingCode\"]").val(response.mavandon);
                    $("#edit-form [name=\"status_id\"]").val(response.status);
                }
            });
        });
    }

    function openModal() {
        get();
        _getTimeZoneOffsetInMs();
        document.getElementById('updateDate').value = timestampToDatetimeInputString(Date.now());
    }
    function openModalThemSanPham() {
        var id = $(this).attr('data-id');

        $(document).delegate("[data-target='#modalThemSanPham']", "click", function () {
            var id = $(this).attr('data-id');
            document.getElementById('orderID').value = id;
        });
        _getTimeZoneOffsetInMs();
        document.getElementById('timeadd').value = timestampToDatetimeInputString(Date.now());

    }
    function openUpdateAllMVD() {
        $(document).delegate("[data-target='#mavandon']", "click", function () {
            var id = $(this).attr('data-id');
            document.getElementById('order_ID').value = id;
        });

        document.getElementById('timeVanDon').value = timestampToDatetimeInputString(Date.now());
    }

    function openModalSuaCan() {
        $(document).delegate("[data-target='#suacannang']", "click", function () {

            var id = $(this).attr('data-id');

            // Ajax config
            $.ajax({
                type: "GET", //we are using GET method to get data from server side
                url: 'getKienHang.php', // get the route value
                data: {id: id}, //set data
                beforeSend: function () {//We add this before send to disable the button once we submit it so that we prevent the multiple click

                },
                success: function (response) {//once the request successfully process to the server side it will return result here
                    response = JSON.parse(response);
                    $("#edit-form [name=\"idKH\"]").val(response.id);
                    // $("#edit-form [name=\"orderCode\"]").val(response.orderCode);
                    $("#edit-form [name=\"ladingCode\"]").val(response.mavandon);
                    $("#edit-form [name=\"socan\"]").val(response.cannang);
                    $("#edit-form [name=\"gianhap\"]").val(response.gianhap);
                    $("#edit-form [name=\"giamgiacuahang\"]").val(response.giamgiacuahang);
                    $("#edit-form [name=\"giavchuyen\"]").val(response.giavc);

                    if (response.feetransport == 28000){
                        document.getElementById('tmdt').checked=true;
                    }else{
                        document.getElementById('km').checked=true;
                    }
                }
            });
        });
    }

    function openVanDon() {
        $(document).delegate("[data-target='#vandon']", "click", function () {
            var id = $(this).attr('data-id');
            document.getElementById('idOrder').value = id;
        });
        _getTimeZoneOffsetInMs();

        document.getElementById('timeVanDon').value = timestampToDatetimeInputString(Date.now());
    }

    function checkInputTraCuu() {
        let input = document.getElementById("inputtracuu").value;
        if (!input) {
            alert('Vui lòng nhập mã vận đơn');
        }
    }

    function timestampToDatetimeInputString(timestamp) {
        const date = new Date((timestamp + _getTimeZoneOffsetInMs()));
        // slice(0, 19) includes seconds
        return date.toISOString().slice(0, 19);
    }

    function _getTimeZoneOffsetInMs() {
        return new Date().getTimezoneOffset() * -60 * 1000;
    }

    function searchStatus() {
        document.search.submit();
    }

    function clickAll() {
        if (document.getElementById('selectall').checked == true) {
            var ele = document.getElementsByName('listproduct[]');

            for (var i = 0; i < ele.length; i++) {
                if (ele[i].type == 'checkbox')
                    ele[i].checked = true;
            }
        } else {
            var ele = document.getElementsByName('listproduct[]');

            for (var i = 0; i < ele.length; i++) {
                if (ele[i].type == 'checkbox')
                    ele[i].checked = false;
            }
        }


    }
    function checkButton() {
        if (document.getElementById('tmdt').checked) {
            document.getElementById('giavc').value = "28000" ;

        }
        if (document.getElementById('km').checked) {
            document.getElementById('giavc').value = "33000";
        }
    }

    // document.getElementById('enddate').value = timestampToDatetimeInputString(Date.now());
</script>

