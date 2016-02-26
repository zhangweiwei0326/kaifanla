<?php
/*
 *该php页面用于order.html
 *获取客户端提交的订单数据，保存到数据库中
 *向客户端保存的结果，以JSON格式
*/

$output = [];
@$user_name = $_REQUEST['user_name'];
@$sex = $_REQUEST['sex'];
@$phone = $_REQUEST['phone'];
@$addr = $_REQUEST['addr'];
@$did = $_REQUEST['did'];
$order_time = time()*1000;      //下单时间
if( !$user_name || !$addr || !$phone || !$did ){
    echo '{"result":"err","mag":"INVALID REQUEST DATA"}';
    return;
}

include('conn.php');
    $sql =  "INSERT INTO kf_order VALUES(NULL,'$phone','$user_name','$sex','$order_time','$addr','$did')";
$result = mysqli_query($conn, $sql);
if($result){ //执行成功
    $output['result'] = 'ok';
    $output['oid'] = mysqli_insert_id($conn);

}else{  //执行失败
    $output['result'] = 'fail';
    $output['msg'] = '添加失败！很可能是SQL语法错误：' .$sql;
}

echo json_encode($output);
?>