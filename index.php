<?php
require_once("sendemail.php");
//require_once("repository/kienhangRepository.php");
require_once("repository/mvdRepository.php");
$mvdRepository = new MaVanDonRepository();

$sendEmail = new SendEMail();
//$kienhangRepository = new KienHangRepository();
?>
<!DOCTYPE html>
<html lang="en">
<?php include 'head.php'; ?>
<!--[if IE 7]>
<body class="ie7 lt-ie8 lt-ie9 lt-ie10"><![endif]-->
<!--[if IE 8]>
<body class="ie8 lt-ie9 lt-ie10"><![endif]-->
<!--[if IE 9]>
<body class="ie9 lt-ie10"><![endif]-->
<style>
</style>
<body class="ps-loading">
<?php include 'header.php'; ?>
<main class="ps-main">
    <div class="ps-tracuu">
        <div class="titleTH">
            <h3 style="font-weight: 700;">Tra Cứu Mã Vận Đơn</h3>
            <img src="images/devider.png">
        </div>
        <div class="container">
            <div class="row">
                <div class="col-lg-2 col-md-12 col-sm-12 col-xs-12">
                </div>
                <div class="col-lg-8 col-md-7 col-sm-12 col-xs-12 " style="padding-bottom: 30px;">
                    <form id="tracuu" class="ps-subscribe__form" method="POST"
                    ">
                    <input required id="inputtracuu" class="form-control" type="text" name="ladingCode"
                           placeholder="Nhập mã vận đơn…">
                    <button style="background-color: #26e102;">Tra Cứu</button>
                    </form>
                </div>
                <div class="col-lg-2 col-md-5 col-sm-12 col-xs-12 ">
                </div>
            </div>
            <div class="col-lg-2 col-md-5 col-sm-12 col-xs-12 ">
            </div>
            <div class="row col-lg-10 col-xs-12 ">
                <div class="table-responsive">
                    <table id="tableShoeIndex">
                        <tr>
                            <th class="text-center" style="min-width:50px">STT</th>
                            <th class="text-center" style="min-width:100px">Mã Vận Đơn</th>
                            <th class="text-center" style="min-width:100px">Trạng Thái</th>
<!--                            <th class="text-center" style="min-width:100px">Mã Vận Đơn</th>-->
                            <th class="text-center" style="min-width:80px">Cân nặng</th>
<!--                            <th class="text-center" style="min-width:80px">Đường Vận Chuyển</th>-->
                            <th class="text-center" style="min-width:150px;max-width: 200px;">Lộ Trình</th>
                            <th class="text-center" style="min-width:150px;max-width: 200px;">Chi tiết</th>
                        </tr>
                        <?php
                        if (!empty($_POST['ladingCode'])) {
                            $ladingCode = $_POST['ladingCode'];
//                echo $orderCode;
                            $result = $mvdRepository->findByMaVanDon($ladingCode);
                            $i = 1;
                            foreach ($result as $mvd) {
                                ?>
                                <tr>
                                <td><?php echo $i++; ?></td>
                                <td><p style="font-weight: 700;color:#000"><?php echo $mvd['mvd'] ?></p>
                                <p ><?php echo $mvd['line'] ?></p>
                                </td>
                                <td style="color: blue"><?php
                                    switch ($mvd['status']) {
                                        case "1":
                                            echo "Kho TQ Nhận";
                                            break;
                                         case "2":
                                             echo "Vận Chuyển";
                                             break;
                                        case "3":
                                            echo "Nhập Kho VN";
                                            break;
                                        case "4":
                                            echo "Yêu Cầu Giao";
                                            break;
                                        case "5":
                                            echo "Đã Giao";
                                            break;
                                        default:
                                            echo "--";
                                    }
                                    ?>
                                </td>
<!--                                <td>--><?php //echo $mvd['mvd'] ?>
<!--                                </td>-->
                                <td><?php echo $mvd['cannang'] ?><span> /Kg</span></td>
<!--                                <td>--><?php //echo $mvd['line'] ?><!--</td>-->
                                <td>
                                    <ul style="text-align: left ;">
<!--                                        <li><p class="fix-status"><span>&#8658;</span> Shop Gửi Hàng</p></li>-->
                                        <li><p class="fix-status"><span>&#8658;</span> TQ Nhận hàng</p></li>
                                         <li><p class="fix-status"><span>&#8658;</span> Vận chuyển</p></li>
                                        <li><p class="fix-status"><span>&#8658;</span> Nhập kho VN</p></li>
                                        <li><p class="fix-status"><span>&#8658;</span> Yêu cầu giao</p></li>
                                        <li><p class="fix-status"><span>&#8658;</span> Đã giao hàng</p></li>
                                    </ul>
                                </td>
                                <td><?php $obj = json_decode($mvd['times']); ?>
                                    <?php if (empty($obj)) { ?>
                                        <ul style="text-align: left;">
                                            <!-- <li><p class="fix-status">............</p></li> -->
                                            <li><p class="fix-status">............</p></li>
                                            <li><p class="fix-status">............</p></li>
                                            <li><p class="fix-status">............</p></li>
                                            <li><p class="fix-status">............</p></li>
                                            <li><p class="fix-status">............</p></li>
                                        </ul><?php
                                    } else { ?>
                                        <ul style="text-align: left;">
                                            <li><p class="fix-status">=> <?php if (!empty($obj->{1})) echo $obj->{1}; ?>
                                            </li>
                                            <li>
                                                <p class="fix-status">
                                                    => <?php if (!empty($obj->{2})) echo $obj->{2}; ?></p>
                                            </li>
                                            <li>
                                                <p class="fix-status">
                                                    => <?php if (!empty($obj->{3})) echo $obj->{3}; ?></p>
                                            </li>
                                            <li>
                                                <p class="fix-status">
                                                    => <?php if (!empty($obj->{4})) echo $obj->{4}; ?></p>
                                            </li>
                                            <li>
                                                <p class="fix-status">
                                                    => <?php if (!empty($obj->{5})) echo $obj->{5}; ?></p>
                                            </li>
                                        </ul>
                                        <?php
                                    } ?>
                                </td>
                                </tr><?php
                            }
                        }
                        ?>
                    </table>
                </div>
            </div>
            <div class="col-lg-2 col-md-5 col-sm-12 col-xs-12 ">
            </div>
        </div>
    </div>
    <div class="ps-dichvu">
        <div class="ps-container">
            <div class="row style= justify-content: center">
                <div class="titleTH">
                    <h3 style="font-weight: 700;">Dịch Vụ Của Chúng Tôi</h3>
                    <!--                    <img src="images/devider.png">-->
                </div>
                <div class="ps-container">
                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 "
                         style="text-align: center;padding-bottom: 10px;">
                        <div class="card">
                            <!-- Card image -->
                            <img class="card-img-top card-th" src="images/services-1.jpg" alt="Card image cap">
                            <!-- Card content -->
                            <div class="card-body">
                                <!-- Title -->
                                <h4 class="card-title"><a>Order hàng Trung Quốc</a></h4>
                                <!-- Text -->
                                <p class="card-text">Dịch vụ đặt hàng Trung Quốc 1688, Taobao, Tmall, Alibaba nhanh
                                    chóng
                                    qua app mua hàng tiện ích.</p>
                                <!-- Button -->
                                <a href="dathang.php" class="btn btn-primary btn-th">Xem Thêm</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 "
                         style="text-align: center;padding-bottom: 10px;">
                        <div class="card">
                            <!-- Card image -->
                            <img class="card-img-top card-th" src="images/services-2.jpg" alt="Card image cap">
                            <!-- Card content -->
                            <div class="card-body">
                                <!-- Title -->
                                <h4 class="card-title"><a>Vận chuyển Trung Việt</a></h4>
                                <!-- Text -->
                                <p class="card-text">Vận chuyển hỏa tốc chỉ sau 5-7 ngày, kể từ khi chúng tôi nhận hàng
                                    từ
                                    shop bên Trung Quốc.</p>
                                <!-- Button -->
                                <a href="dichvuvanchuyen.php" class="btn btn-primary btn-th">Xem Thêm</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="ps-taisao">
        <div class="ps-container">
            <div class="titleTH">
                <h3 style="font-weight: 700;">TẠI SAO NÊN CHỌN TMDT Trung Việt </h3>
<!--                <img src="images/devider.png">-->
            </div>
            <div class="row">
                <div class="col-md-3 col-12 th-taisao">
                    <h3><i class="fa fa-arrow-circle-left"></i></h3>
                    <h3 class=""><span>TIẾT KIỆM</span></h3>
                    <p class="">30% chi phí nhập hàng Trung Quốc</p>
                </div>
                <div class="col-md-3 col-6 th-taisao">
                    <h3><i class="fa fa-car"></i></h3>
                    <h3 class=""><span>TỐC ĐỘ</span></h3>
                    <p class="">Đặt hàng nhanh chóng trong 24h</p>
                </div>
                <div class="col-md-3 col-6 th-taisao">
                    <h3><i class="fa fa-calendar"></i></h3>
                    <h3 class=""><span>TINH GỌN</span></h3>
                    <p class="">Quy trình xử lý đơn hàng nhanh chóng</p>
                </div>
                <div class="col-md-3 col-6 th-taisao">
                    <h3><i class="fa fa-smile-o"></i></h3>
                    <h3 class=""><span>TẬN TÂM</span></h3>
                    <p class="">Nhân viên dày dặn kinh nghiệm</p>
                </div>
            </div>
        </div>
    </div>
    <div class="ps-bangiadichvu" )>
        <div class="titleTH">
            <h3 style="font-weight: 700;">Phí Dịch Vụ</h3>
            <!--            <img src="images/devider.png">-->
        </div>
        <div class="ps-container">
            <img class="img" style="width: 80%;padding-bottom: 30px;" src="images/banggia.png"/>
        </div>
    </div>
    <div class="ps-alldichvu">
        <div class="ps-container">
            <div class="titleTH">
                <h3 style="font-weight: 700;">Dịch Vụ Khác</h3>
                <img src="images/devider.png">
            </div>
            <div class="row style=justify-content: center">
                <div class="card col-md-3 col-12" style="text-align: center">
                    <div class="card-content">
                        <div class="card-body"><img class="img" src="images/1.jpg" href="dathang.php"/>
                            <div class="shadow"></div>
                            <div class="card-title" style="font-weight: 700;">Đặt Hàng</div>
                        </div>
                    </div>
                </div>
                <div class="card col-md-3 col-12" style="text-align: center">
                    <div class="card-content">
                        <div class="card-body"><img class="img" src="images/2.jpg"/>
                            <div class="shadow"></div>
                            <div class="card-title" style="font-weight: 700;"> Vận Chuyển</div>
                        </div>
                    </div>
                </div>
                <div class="card col-md-3 col-12" style="text-align: center">
                    <div class="card-content">
                        <div class="card-body"><img class="img" src="images/3.jpg"/>
                            <div class="shadow"></div>
                            <div class="card-title" style="font-weight: 700;"> Mua Bán Tệ</div>
                        </div>
                    </div>
                </div>
                <div class="card col-md-3 col-12" style="text-align: center">
                    <div class="card-content">
                        <div class="card-body"><img class="img" src="images/4.jpg"/>
                            <div class="shadow"></div>
                            <div class="card-title" style="font-weight: 700;"> Thanh Toán Hộ</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="ps-camket">
        <div class="ps-container">
            <div class="row">
                <div class="col-lg-7 col-md-7 col-sm-12 col-xs-12">
                    <h1 class=""><span>CAM KẾT DỊCH VỤ</span></h1>
                    <ul>
                        <li><h3><i class="fa fa-check-circle"></i> Cam kết hàng về chỉ sau 3-5 ngày (Kể từ khi shop
                                Trung Quốc phát hàng)</h3></li>
                        <li><h3><i class="fa fa-check-circle"></i> Đền 100% tiền hàng nếu mất/ vỡ do quá trình vận
                                chuyển</h3></li>
                        <li><h3><i class="fa fa-check-circle"></i> Cam kết mua đúng link, đúng sản phẩm</h3></li>
                        <li><h3><i class="fa fa-check-circle"></i> Hỗ trợ 24/7 nhanh chóng, tiện lợi</h3></li>
                        <li><h3><i class="fa fa-check-circle"></i> Cam kết tỷ giá phù hợp nhất</h3></li>
                    </ul>
                </div>
                <div class="col-lg-5 col-md-5 col-sm-12 col-xs-12">
                    <div class="">
                        <div class="form-group">
                            <header>
                                <h3>Liên hệ với chúng tôi</h3>
                            </header>
                            <footer>
                                <form action="" method="post">
                                    <div class="form-group">
                                        <label>Name<span>*</span></label>
                                        <input name="name" class="form-control" type="text">
                                    </div>
                                    <div class="form-group">
                                        <label>Email<span>*</span></label>
                                        <input name="email" class="form-control" type="email">
                                    </div>
                                    <div class="form-group">
                                        <label>SĐT<span>*</span></label>
                                        <input name="phone" class="form-control" type="phone">
                                    </div>
                                    <div class="form-group text-center">
                                        <button name="send_email" class="ps-btn btn-th">Gửi Đi<i
                                                    class="fa fa-angle-right"></i></button>
                                    </div>
                                    <?php
                                    if (isset($_POST['send_email']))
                                        $sendEmail->send($_POST['name'], $_POST['email'], "Xin Chào", $_POST['phone']);
                                    ?>
                                </form>
                            </footer>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="ps-subscribe">
        <div class="titleTH">
            <h3 style="font-weight: 700;">ĐỊA CHỈ KHO HÀNG</h3>
            <img src="images/devider.png">
        </div>
        <div class="ps-container">
            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 ">
                    <h3><i class="fa fa-home"></i>TMDT Trung Việt - KĐT Mới Văn Khê - Hà Đông - Hà Nội</h3>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 ">
                    <h3><i class="fa fa-phone"></i>Holine: 033.699.1688 </h3>
                </div>
            </div>
        </div>

    </div>
</main>
<?php include 'footer.php'; ?>
<!-- JS Library-->
<?php include 'script.php'; ?>
<script>

</script>
</body>
</html>