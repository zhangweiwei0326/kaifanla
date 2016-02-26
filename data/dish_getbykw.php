<?php
/*
 *该php页面用于main.html
 *根据搜索关键字向客户端返回菜品数据
*/


$output = [];
@$kw = $_REQUEST['kw'];
if(!$kw){
    echo '[]';
    return;  //退出当前页面
}

include('conn.php');
$sql =  "SELECT did,name,price,img_sm,material FROM kf_dish WHERE name LIKE  '%$kw%' OR material LIKE '%$kw%'";
$result = mysqli_query($conn, $sql);
while (($row=mysqli_fetch_assoc($result))!== NULL ) {
    $output[] = $row;
}

echo json_encode($output);

?>