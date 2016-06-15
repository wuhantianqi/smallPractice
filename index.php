<?php
	session_start();   //开启session存储
	// require('./gd/gd.class.php');
	// // $im ='./data/index/1.txt,./data/index/2.txt';
	// // // $im ='./data/1.txt';
	// // $path=new File($im);	
	// // $path->delete();
	// // $im ='./1.txt,./2.txt';
	// // $im ='./data/1.txt';
	// $path=new File();	
	// // $path->f_open();
	// $primary ='123.txt';
	// // $target  ='browser';
	// // echo copy($primary,$target);
	// $path->download_file($primary,'down_dir','./bools/123.txt');
	$ycode=$_SESSION['code'];
	$code=$_POST['co'];
	if($ycode == $code){
		echo '验证码输入成功';
	}else{
		echo '验证码输入失败';
	}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
	<script src="jquery-1.11.1.min.js" type="text/javascript"></script>
	<script type="text/javascript">
		// $(function(){
		// 	// $("#form").serialize()
		// 	$(document).on('click','input[type="button"]',function(){
		// 		console.log($("#form").serialize());
		// 	})
		// })
	</script>
</head>
<body>
	<form action="index.php" method="post" id="form">
		用户名:<input type="text" value='' name='nm'>
		密  码:<input type="password" name="pw">
		验证码:<input type="text" name="co"><img src="./gd/gd.class.php" alt="">
		<input type="submit" value='提交'>
	</form>
</body>
</html>