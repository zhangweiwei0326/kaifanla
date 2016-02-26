<?php
/*
 *该php页面用于main.html
 *根据搜索关键字向客户端返回菜品数据，以JSON格式
 *每次最多返回五条菜品数据，
 *需要客户端提供从哪一行(0/5/10/15.。。。)开始读取数据
 *若客户端未提供其实行，则默认从第0行开始读取5条
*/

$output = [];
$count = 5;  //每次最多返回的记录数
@$start = $_REQUEST['start'];
if($start===null){
    $start = 0;
}

include('conn.php');
$sql =  "SELECT did,name,price,img_sm,material FROM kf_dish LIMIT $start,$count";
$result = mysqli_query($conn, $sql);
while (($row=mysqli_fetch_assoc($result))!== NULL ) {
    $output[] = $row;
}

echo json_encode($output);



?>