<?php
/*
 *��phpҳ������myorder.html
 *��ȡ�ͻ����ύ�ĵ绰���룬���ظõ绰�Ŷ�Ӧ�����ж�������JSON��ʽ
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