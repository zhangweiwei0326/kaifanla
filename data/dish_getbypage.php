<?php
/*
 *��phpҳ������main.html
 *���������ؼ�����ͻ��˷��ز�Ʒ���ݣ���JSON��ʽ
 *ÿ����෵��������Ʒ���ݣ�
 *��Ҫ�ͻ����ṩ����һ��(0/5/10/15.������)��ʼ��ȡ����
 *���ͻ���δ�ṩ��ʵ�У���Ĭ�ϴӵ�0�п�ʼ��ȡ5��
*/

$output = [];
$count = 5;  //ÿ����෵�صļ�¼��
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