<?php
	/**
	 * 文件处理类
	 * (1) 目录的创建
	 * 		这个功能不需要,用mkdir($path [,$mode [,$recursive]]) 新建目录$mode表示权限，默认0777$recursive表示可创建多级目录，默认false,true递归创建目录,就可以解决了
	 * (2) 文件的创建
	 * 		传值: index.html /index.html ./index.html ./a/b/c/index.html
	 * (3) 目录删除或文件删除
	 * 		单文件传值: 1.txt
	 * 	 	多文件传值: 1.txt,2.txt,3.txt....
	 * 	  	目录传值类似
	 * (4) 文件拷贝或移动
	 * (5) 文件下载
	 * 		<1> 浏览器输出
	 * 		<2> 下载拷贝到指定文件夹
	 */
	class File{
		// protected $path='';    		   //文件路径
		// function __construct($path){
		// 	$this->path=trim($path);
		// }
		/**
		 * 创建文件
		 * @param  string $path [description]
		 * @return [type]       [description]
		 */
		public function f_open($path){
			if(file_exists($path)){
				echo '指定的文件已存在';
				return false;
			} 
			$num=substr_count($path,"/");   //获取/的数量
			if($num <= 1){           //代表创建在/根目录或./当前目录下   
				if($num == 0){      //如果没有/,默认加上./,代表在当前目录下创建
					$path='./'.$path;
				}
				if($pinfo=fopen($path,'a')){
					echo "创建文件成功";
				}else{
					echo '创建文件失败,请检查是否有权限创建';
				}
				fclose($pinfo);  //关闭文件资源
			}else{
				$pid=dirname($path);      //返回目录部分
				if(!mkdir($pid,'0777',true)){   //递归创建目录
					echo '创建目录失败,请检查是否有权限创建';
					return false;
				} 
				if($pinfo=fopen($path,'a')){
					echo "创建文件成功";
				}else{
					echo '创建文件失败,请检查是否有权限创建';
				}
				fclose($pinfo);  //关闭文件资源
			}
		}
		/**
		 * 删除文件或目录
		 * @param  string $path [description]
		 * @return [type] [description]
		 */
		public function delete($path){
			if(!file_exists($path)){
				echo '指定的文件或目录不存在';
				return false;
			}
			if(strchr($path,",") !== false){      //多目录或文件
				$path=explode(",",$path);
				foreach($path as $v){
					if(is_dir($v)){    //目录删除
						$this->rm_dir($v);   //删除目录	
					}else{             //文件删除
						$this->rm_file($v);
					}
				}
			}else{    //单目录或文件
				if(is_dir($path)){          //目录删除
					$this->rm_dir($path);   //删除目录      
				}else{    //文件删除
					$this->rm_file($path);
				}
			}	
		}
		/**
		 * 删除文件
		 * @param  [type] $file [description]
		 * @return [type]       [description]
		 */
		protected function rm_file($file){
			//清除文件缓存
			clearstatcache();
			if(is_file($file)){
				if(unlink($file)){
					echo '删除成功';
				}else{
					echo '删除失败,请检查是否有权限删除';
				}
			}else{
				echo '删除失败,请检查文件路径是否正确';
			}
		}
		/**
		 * 删除目录(循环删除目录下的所有文件并删除该目录)
		 * @param  string $dirname [description]
		 * @return boolean  
		 */
		protected function rm_dir($dirname){
			 //判断是否为一个目录，非目录直接关闭
			 if(is_dir($dirname)){
			 	//如果是目录，打开他
			 	$name=opendir($dirname);
			 	//使用while循环遍历
			 	while($file=readdir($name)){
			  		//去掉本目录和上级目录的点
			  		if($file=="." || $file==".."){
			   			continue;
			  		}
			  		//如果目录里面还有一个目录，再次回调
			  		if(is_dir($dirname."/".$file)){
			   			$this->rm_dir($dirname."/".$file);
			  		}
			  		$this->rm_file($dirname."/".$file);
			 	}
			 	//遍历完毕关闭文件
			 	closedir($name);
			 	//删除目录
			 	if(rmdir($dirname)){      //目录下面确定为空了，删之
					echo '删除目录成功';
				}else{
					echo "删除目录失败，请检验是否有删除权限";
				} 
			 }
		}
		/**
		 * 拷贝或移动文件
		 * @param  string $primary    原文件路径
		 * @param  string $target     目标文件路径
		 * @param  string $pinfo      操作标识符copy拷贝move移动
		 * @return [type]             [description]
		 */
		public function copy_move($primary,$target,$pinfo='move'){
			echo $primary;
			if( !file_exists($primary)){
				echo '原文件路径不正确,请检查';
				return false;
			}
			if(!is_dir(dirname($target))){  //取出目标文件目录部分
				if(!mkdir($target,'0777',true)){
					echo '目标文件目录尝试创建失败,请检查是否有权限';
					return false;
				}	
			}
			if('move'==$pinfo){				
				$this->move_file($primary,$target);	
			}elseif('copy'==$pinfo){
				if(is_dir($primary)){  //目录
					$this->copy_dir($primary,$target);
				}else{                 //文件
					$this->copy_file($primary,$target);
				}
			}
		}
		/**
		 * 移动文件或目录
		 * @param  string $primary 原文件路径
		 * @param  string $target  目标文件路径
		 * @return [type]          [description]
		 */
		protected function move_file($primary,$target){
			// 1. 对于文件，rename可以在不同盘符之间移动。
			// 2. 对于空文件夹，rename也可以在不同盘符之间移动。但是目标文件夹的父目录必须存在。
			// 3. 对于非空文件夹，只能在同一盘符下移动。
			// rename("index.txt", "index.bak");
			// rename("/tmp/www.txt", "/home/my_file.txt");
			// rename("./tmp/www.txt", "./home/my_file.txt");
			// rename("./tmp/www", "./home/www");
			// rename("./tmp/www", "./home/Comm");
			// 注意目标地址必须带文件夹名
			if(rename($primary,$target)){
				echo '文件重命名或移动成功';
			}else{
				echo '文件重命名或移动失败,请检查是否有权限';
			}
		}
		/**
		 * 拷贝文件
		 * @param  string $primary 原文件路径
		 * @param  string $target  目标文件路径
		 * @return [type]          [description]
		 */
		protected function copy_file($primary,$target){
			//copy("index.php","test/index.php"); 
			//copy("index.php","./test/index.php");
			//copy("index.php","index.php.bak");
			//注意目标地址必须带文件名
			if(copy($primary,$target)){
				echo '文件拷贝成功';
			}else{
				echo '文件拷贝失败,请检查是否有权限';
			}
		}
		/**
		 * 拷贝文件夹
		 * @param  string $primary 原文件路径
		 * @param  string $target  目标文件路径
		 * @return [type]          [description]
		 */
		protected function copy_dir($primary,$target){
			if(!is_dir($target)){  //传值的目标目录不存在或递归下的目录中的目录如果不存在就创建
				if(!mkdir($target,'0777',true)){
					echo '目标文件目录尝试创建失败,请检查是否有权限';
					return false;
				}	
			}
			$dir=opendir($primary);     //找开原目录
			while(false !== ($file=readdir($dir))){
				if('.'==$file || '..'==$file){        //过滤虚拟目录
					continue;
				}
				if(is_dir($primary.'/'.$file)){
					$this->copy_dir($primary.'/'.$file,$target.'/'.$file);
				}else{
					$this->copy_file($primary.'/'.$file,$target.'/'.$file);
				}	
			}
			closedir($dir);           //关闭文件资源
		}
		/**
		 * 下载文件
		 * @param  string $file_name 下载文件名
		 * @param  string $file_type 下载类型browser(直接输出到浏览器)down_dir(拷贝到指定文件夹中)
		 * @param  string $file_dir  下载文件存放目录
		 * @return [type]            [description]
		 */
		public function download_file($file_name,$file_type='browser',$file_dir='./tmp'){
			if('browser' == $file_type){
				$this->download_browser($file_name);
			}elseif('down_dir'==$file_type){
				$this->copy_move($file_name,$file_dir,$pinfo='copy');
			}   
		}
		/**
		 * 输出到浏览器,由用户自行下载
		 * @param  string $file_name 文件路径
		 * @return [type]            [description]
		 */
		protected function download_browser($file_name){
			$file_name=iconv("utf-8","gb2312",$file_name);  //将utf-8传成gb2312转码,将中文转成字母，因为is_file函数不识别中文名的文件，会报错
			if(is_file($file_name)){
		        $length = filesize($file_name);             //获取文件大小
		        $type = mime_content_type($file_name);     //获取文件的mime类型
		        $showname =  ltrim(strrchr($file_name,'/'),'/');   //获取文件名,strrchr返回最后一次查找到的/及后面的字符串，ltrim将左边的/删除
		        Header("Content-type: application/octet-stream");  //通过这句代码客户端浏览器就能知道服务端返回的文件形式
		        Header("Accept-Ranges: bytes");    //告诉客户端浏览器返回的文件大小是按照字节进行计算的 
		        header('Content-type: ' . $type);
		        header('Content-Length:' . $length);
		        //Header("Content-Disposition: attachment; filename=".$showname)的作用:告诉浏览器返回的文件的名称 
		        if (preg_match('/MSIE/', $_SERVER['HTTP_USER_AGENT'])) { //for IE
		             header('Content-Disposition: attachment; filename="' . rawurlencode($showname) . '"');
		        } else {
		             header('Content-Disposition: attachment; filename="' . $showname . '"');
		        }
		        readfile($file_name);
		        exit;
		    } else {
		        exit('文件路径不正确或已被删除！');
		    }
		}
	}
