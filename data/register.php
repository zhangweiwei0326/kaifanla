<?php
/*��ҳPHP����ע��
 *����ע���
 *��ɹ�����{result:ok}
*/
$output =[];
@$phone = $_REQUEST['phone'];
@$pwd = $_REQUEST['pwd'];
 include('conn.php');
  $sql = "INSERT INTO kf_user(uid,phone,pwd) VALUES (NULL,'$phone','$pwd');";
 $result = mysqli_query($conn,$sql);
  if($result){ //ִ�гɹ�
          $output['result'] = 'ok';
          $output['oid'] = mysqli_insert_id($conn);
      }else{  //ִ��ʧ��
          $output['result'] = 'fail';
          $output['msg'] = '���ʧ�ܣ��ܿ�����SQL�﷨����' .$sql;
      }
      echo json_encode($output);
?>