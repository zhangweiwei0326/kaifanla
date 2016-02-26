<?php
    /*此页面验证手机是否已经注册
     *
    */
    $output =[];
    @$phone = $_GET['phone'];
    include('conn.php');
    $sql = "SELECT uid FROM kf_user where phone='$phone' LIMIT 1";
    $result = mysqli_query($conn,$sql);
     if($result){ //执行成功
             $output['result'] = 'ok';
             $output['uid'] = mysqli_fetch_assoc($result)['uid'];
         }else{  //执行失败
             $output['result'] = 'fail';
             $output['msg'] = '添加失败！很可能是SQL语法错误：' .$sql;
         }
     if($output['uid']==null){
        echo "true";
     }else{
        echo "false";
     }
?>
