<?php
    $output = [];
    @$phone = $_REQUEST['phone'];
    @$pwd = $_REQUEST['pwd'];
    //�������ݿ��ļ�
    include('conn.php');
    //����û�������
    $sql = "SELECT uid FROM kf_user where phone='$phone' AND pwd='$pwd' LIMIT 1";
    $result = mysqli_query($conn,$sql);
    if($result){ //ִ�гɹ�
        $output['result'] = 'ok';
        $output['uid'] = mysqli_fetch_assoc($result)['uid'];
    }else{  //ִ��ʧ��
        $output['result'] = 'fail';
        $output['msg'] = '���ʧ�ܣ��ܿ�����SQL�﷨����' .$sql;
    }
    echo json_encode($output);
?>