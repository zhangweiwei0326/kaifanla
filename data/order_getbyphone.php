<?php
/*
 *该php页面用于myorder.html
 *获取客户端提交的电话号码，返回该电话号对应的所有订单，以JSON格式
*/

$output = [];
$myorder = [];
@$phone = $_REQUEST['phone'];
if(!$phone){
    echo '{"result":"err","mag":"INVALID REQUEST DATA"}';
    return;
}

include('conn.php');
$sql =  "SELECT o.did,order_time,user_name,img_sm FROM kf_order o,kf_dish d WHERE phone='$phone' AND o.did=d.did ORDER BY order_time DESC";
$result = mysqli_query($conn, $sql);
while (($row=mysqli_fetch_assoc($result))!== NULL ) {
    $output[] = $row;
}


echo json_encode($output);


?>