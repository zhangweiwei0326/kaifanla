<?php
    $output = [];
    @$phone = $_REQUEST['phone'];
    @$pwd = $_REQUEST['pwd'];
    //包含数据库文件
    include('conn.php');
    //检测用户名密码
    $sql = "SELECT uid FROM kf_user where phone='$phone' AND pwd='$pwd' LIMIT 1";
    $result = mysqli_query($conn,$sql);
    if($result){ //执行成功
        $output['result'] = 'ok';
        $output['uid'] = mysqli_fetch_assoc($result)['uid'];
    }else{  //执行失败
        $output['result'] = 'fail';
        $output['msg'] = '添加失败！很可能是SQL语法错误：' .$sql;
    }
    echo json_encode($output);
?>