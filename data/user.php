<?php
session_start();

//����Ƿ��½����û��½ת���½ҳ��
if(isset($.SESSION['phone'])){
    header("Location:login.html");
    exit();
}
?>