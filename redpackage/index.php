<?php
	session_start();   //开启session存储
	$_POST['info']='成功';
	echo json_encode($_POST);