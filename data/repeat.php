<?php
    /*��ҳ����֤�ֻ��Ƿ��Ѿ�ע��
     *
    */
    $output =[];
    @$phone = $_GET['phone'];
    include('conn.php');
    $sql = "SELECT uid FROM kf_user where phone='$phone' LIMIT 1";
    $result = mysqli_query($conn,$sql);
     if($result){ //ִ�гɹ�
             $output['result'] = 'ok';
             $output['uid'] = mysqli_fetch_assoc($result)['uid'];
         }else{  //ִ��ʧ��
             $output['result'] = 'fail';
             $output['msg'] = '���ʧ�ܣ��ܿ�����SQL�﷨����' .$sql;
         }
     if($output['uid']==null){
        echo "true";
     }else{
        echo "false";
     }
?>
