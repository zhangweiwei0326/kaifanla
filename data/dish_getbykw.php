<?php
/*
 *��phpҳ������main.html
 *���������ؼ�����ͻ��˷��ز�Ʒ����
*/


$output = [];
@$kw = $_REQUEST['kw'];
if(!$kw){
    echo '[]';
    return;  //�˳���ǰҳ��
}

include('conn.php');
$sql =  "SELECT did,name,price,img_sm,material FROM kf_dish WHERE name LIKE  '%$kw%' OR material LIKE '%$kw%'";
$result = mysqli_query($conn, $sql);
while (($row=mysqli_fetch_assoc($result))!== NULL ) {
    $output[] = $row;
}

echo json_encode($output);

?>