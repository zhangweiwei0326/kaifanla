<?php
/*该页PHP用于注册
 *接收注册表单
 *如成功返回{result:ok}
*/
$output =[];
@$phone = $_REQUEST['phone'];
@$pwd = $_REQUEST['pwd'];
 include('conn.php');
  $sql = "INSERT INTO kf_user(uid,phone,pwd) VALUES (NULL,'$phone','$pwd');";
 $result = mysqli_query($conn,$sql);
  if($result){ //执行成功
          $output['result'] = 'ok';
          $output['oid'] = mysqli_insert_id($conn);
      }else{  //执行失败
          $output['result'] = 'fail';
          $output['msg'] = '添加失败！很可能是SQL语法错误：' .$sql;
      }
      echo json_encode($output);
?>