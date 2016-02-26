<?php
session_start();

//检测是否登陆，若没登陆转向登陆页面
if(isset($.SESSION['phone'])){
    header("Location:login.html");
    exit();
}
?>