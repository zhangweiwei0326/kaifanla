<?php
/*
 *该php页面用于detail.html
 *根据菜品编号向客户端返回某一道菜品的详情,以JSON格式
*/

$output = [];
@$did = $_REQUEST['did'];
if(!$did){
    echo '[]';
    return;  //退出当前页面
}

include('conn.php');
$sql =  "SELECT did,name,price,img_lg,material,detail FROM kf_dish WHERE did=$did";
$result = mysqli_query($conn, $sql);
while (($row=mysqli_fetch_assoc($result))!== NULL ) {
    $output[] = $row;
}

echo json_encode($output);

?>