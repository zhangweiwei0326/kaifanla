<?php
/*
 *��phpҳ������detail.html
 *���ݲ�Ʒ�����ͻ��˷���ĳһ����Ʒ������,��JSON��ʽ
*/

$output = [];
@$did = $_REQUEST['did'];
if(!$did){
    echo '[]';
    return;  //�˳���ǰҳ��
}

include('conn.php');
$sql =  "SELECT did,name,price,img_lg,material,detail FROM kf_dish WHERE did=$did";
$result = mysqli_query($conn, $sql);
while (($row=mysqli_fetch_assoc($result))!== NULL ) {
    $output[] = $row;
}

echo json_encode($output);

?>