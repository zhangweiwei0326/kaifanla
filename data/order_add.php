<?php
/*
 *��phpҳ������order.html
 *��ȡ�ͻ����ύ�Ķ������ݣ����浽���ݿ���
 *��ͻ��˱���Ľ������JSON��ʽ
*/

$output = [];
@$user_name = $_REQUEST['user_name'];
@$sex = $_REQUEST['sex'];
@$phone = $_REQUEST['phone'];
@$addr = $_REQUEST['addr'];
@$did = $_REQUEST['did'];
$order_time = time()*1000;      //�µ�ʱ��
if( !$user_name || !$addr || !$phone || !$did ){
    echo '{"result":"err","mag":"INVALID REQUEST DATA"}';
    return;
}

include('conn.php');
    $sql =  "INSERT INTO kf_order VALUES(NULL,'$phone','$user_name','$sex','$order_time','$addr','$did')";
$result = mysqli_query($conn, $sql);
if($result){ //ִ�гɹ�
    $output['result'] = 'ok';
    $output['oid'] = mysqli_insert_id($conn);

}else{  //ִ��ʧ��
    $output['result'] = 'fail';
    $output['msg'] = '���ʧ�ܣ��ܿ�����SQL�﷨����' .$sql;
}

echo json_encode($output);
?>