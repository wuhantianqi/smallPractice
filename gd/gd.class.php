<?php
	class gd{
		/**
		 * 生成验证码,并保存在session中,注意调用页面必须开启了session
		 * @param  string $type   验证码类型,默认为2。1.简单验证码(数字+字母)2.中文验证码(使用前一定要先上传相关字体) 3.扭曲中文验证码
		 * @param  string $width  		验证码宽
		 * @param  string $height 		验证码高
		 * @param  string $fontSize 	验证码字体大小
		 * @param  string $interfere 	干扰线条数
		 * @param  string $length 		验证码长度
		 * @param  array  $color 		验证码字体颜色 rgb数组设置，例如 array(255, 255, 255)
		 * @param  array  $bgcolor 		验证码背景颜色 rgb数组设置，例如 array(0, 0, 0)
		 * @param  string $color 		验证码中文字体
		 * @return [type]         [description]
		 */
		public static function gdCode($type='3',$width='80',$height='33',$fontSize='14',$interfere='3',$length='4',$color=array(255,255,255),$bgcolor=array(0,0,0),$fontttf='simhei.ttf'){
			//开启session用于存储验证码
			session_start();
			//1.造画布
			$im=imagecreatetruecolor($width,$height);
			//2.造颜料(字体颜色)
			$color=imagecolorallocate($im,$color[0],$color[1],$color[2]);
			//2.造颜料(填充背景色用)
			$bjcolor=imagecolorallocate($im,$bgcolor[0],$bgcolor[1],$bgcolor[2]);
			//2.干扰线颜料
			for ($i=1; $i <= $interfere; $i++) { 
				$line[$i]=imagecolorallocate($im,mt_rand(150,200),mt_rand(150,200),mt_rand(150,200));
			}
			//3.填充背景
			imagefill($im,0,0,$bjcolor);
			//4.画干扰线
			for ($i=1; $i <= $interfere; $i++) { 
				imageline($im,0,mt_rand(0,$height/2),$width,mt_rand(0,$height/2),$line[$i]);
			} 
			//5.造字符串,打乱字符串并截取字符串
			$str='的一是了我不人在他有这个上们来到时大地为子中你说生国年着就那和要她出也得里后自以会家可下而过天去能对小多然于心学么之都好看起发当没成只如事把还用第样道想作种开美总从无情己面最女但现前些所同日手又行意动方期它头经长儿回位分爱老因很给名法间斯知世什两次使身者被高已亲其进此话常与活正感见明问力理尔点文几定本公特做外孩相西果走将月十实向声车全信重三机工物气每并别真打太新比才便夫再书部水像眼等体却加电主界门利';
			//每隔3个字符插入一个“,”，转换为数组使用，使用strlen()测出php中一个中文霸占了3个字节
			$re = chunk_split($str,3,",");
			//转换为数组
			$re = explode(",",$re);
			//随机重新排序数组
			shuffle($re);
			//把数据转为字符串
			$str = mb_substr(implode($re),0,$length,'utf-8'); 
			//字体显示位置X坐标
			$positionx=round(($width-$fontSize*$length)/10);
			if('1'==$type){
				$str=strtolower(substr(str_shuffle('abcdefghjkmnpqrstwxyzABCDEFGHJKMNPQRSTWXYZ123456789'),0,$length));
				//字体显示位置X坐标
				$positionx=round(($width-$fontSize*$length)/1.2);
			}
			//session存储验证码
			$_SESSION['code']=$str;
			//字体显示位置Y坐标
			$positiony=round($height-$fontSize);
			//6.写字
			imagettftext($im,$fontSize,0,$positionx,20,$color,$fontttf,$str);
			if('3'==$type){
				//创建一个新画布用于存放扭曲后的验证码
				$dst=imagecreatetruecolor($width,$height);
				$dgray=imagecolorallocate($dst,$bgcolor[0],$bgcolor[1],$bgcolor[2]);
				imagefill($dst,0,0,$dgray);
				//将原图一竖条一竖条的复制，每次复制1px
		      	  for($i=0;$i<$width;$i++){       //原图宽60，所以循环60次
		      	  	//根据正弦曲线计算上下波动的posY
		      	  	$offset=2;    //最大波动几个像素         
		      	  	$round=1;     //扭动周期,一个周期2PI
		      	  	$posY=round(sin($i*$round*2*M_PI/60)*$offset);  //根据正弦曲线计算Y轴的偏移量
		      	  	imagecopy($dst,$im,$i,$posY,$i,0,1,$height);
		      	  }
		      	  //将原图一横条一横条的复制，每次复制1px
		      	  // for($i=0;$i<$height;$i++){       //原图宽60，所以循环60次
		      	  // 	//根据正弦曲线计算上下波动的posY
		      	  // 	$offset=3;    //最大波动几个像素
		      	  // 	$round=2;     //扭动周期,一个周期2PI
		      	  // 	$posY=round(sin($i*$round*2*M_PI/60)*$offset);  //根据正弦曲线计算Y轴的偏移量
		      	  // 	imagecopy($dst,$im,$posY,$i,0,$i,$width,1);
		      	  // }
			}
			//声明头部,输出类型为png的图片
			header('content-type:image/png');
			//输出到页面
			if(isset($dst)){
				imagepng($dst);
				//销毁画布资源
				imagedestroy($dst);
				imagedestroy($im);
			}else{
				imagepng($im);
				//销毁画布资源
				imagedestroy($im);
			}
		}
		/**
		 * 饼状分析图
		 * @param  string $width 		画布的宽
		 * @param  string $height 		画布的高
		 * @param  string $circular 	画布的半径
		 * @param  array  $numarr   	圆弧的度数[40,20..]
		 * @param  array $bcolor   		背景画布的颜色[255,255,255]
		 * @param  array $largecolor   	背景圆的颜色[255,255,255]
		 * @param  array $smallcolor   	前景圆的颜色[[255,255,255],[200,200,200]],默认为空,自动生成
		 * @return [type]           [description]
		 */
		public static function pieAnalysis($width,$height,$circular,$numarr,$bcolor=array(240,240,240),$largecolor=array(105,105,105),$smallcolor=array()){
			//1.造画布,饼状图一般是圆形,所以只需要半径就可计算出画布宽高
			$bim=imagecreatetruecolor($width,$height);
			//2.造颜料,填充画布
			$bcolor=imagecolorallocate($bim,$bcolor[0],$bcolor[1],$bcolor[2]);
			//2.造颜料,前景大圆的颜色
			$largecolor=imagecolorallocate($bim,$largecolor[0],$largecolor[1],$largecolor[2]);
			//3.填充背景色
			imagefill($bim,0,0,$bcolor);
			//先画底圆
			imagefilledarc($bim,$width/2,$height/2,$circular+30,$circular+30,0,360,$largecolor,0+4);
			//计算圆弧的度数
			$numbes=array_sum($numarr);    //获取所有值的和
			$newnumarr=array();            //存储度数
			foreach($numarr as $v){
				$nm=$v/$numbes*360;        //总数/每个单位数*360得到每个单位占用的度数
				array_push($newnumarr,round($nm,2));	
			}
			asort($newnumarr);            //对数组进行升序排列
			$start=0;      //存储弧度起始角度
			//画圆并填充
			for ($i=0; $i < count($numarr); $i++) {
				//2.造颜料,前景小圆的颜色
				if(empty($smallcolor)){   //为空的话颜色自动生成
					$smallcl=imagecolorallocate($bim,mt_rand(50,255),mt_rand(50,255),mt_rand(50,255));
				}else{
					$smallcl=imagecolorallocate($bim,$smallcolor[0],$smallcolor[1],$smallcolor[2]);
				}
				//画前景小圆饼状图
				imagefilledarc($bim,$width/2,$height/2,$circular,$circular,$start,360,$smallcl,0+4);      
				$start+=$newnumarr[$i];
			}		
			//声明头部
			header('content-type:image/png');
			//输出到画布
			imagepng($bim);
			//销毁画布资源
			imagedestroy($bim);
		}

	}
	gd::gdCode();