<?php

	// function pailie($t1,$t2,$t3,$t4,$t5,$t6,$n){

	//     $str="$t1$t2$t3$t4$t5$t6";
	//     $sub=array();

	//     for($i=0;$i<$n;$i++){
	//         $a=str_shuffle($str);
	//         if(substr($a,2,1)==4){
	//             continue;
	//         }
	//         if(strpos($a,"35")!==false){
	//             continue;
	//         }
	//         $sub[$i]=$a;
	//     }

	//     $sub=array_unique($sub);
	//     echo count($sub);
	//     echo "\r\n";

	//     print_r($sub);


	// }


	// pailie(1,2,2,3,4,5,10000);
	// function pailie($data,$n){
	// 	$xn=substr($data,0);
	// 	$tmp=0;
	// 	for($i=1;$i<=$n;$i++){
	// 		$tmp+=str_repeat($xn,$i);
	// 	}
	// 	return $tmp;
	// }
	// echo pailie(22,5);
// echo $str = "Thissss7is nice";
// echo substr_count($str,"s",1,8).'<br/>';
	




	// function maxLength($str){
	// 	$arr=array(0);
	// 	$tmp='';
	// 	for($i=0;$i<280;$i++){
	// 		// $n=strlen($str);
	// 		$n=mt_rand(0,strlen($str)-1);
	// 		$tmp.=$str[$n];
	// 	}
	// 	echo $tmp;
	// 	for($j=1;$j<=strlen($str);$j++){
	// 		// echo '--';
	// 		$tmpnum=substr_count($tmp,$str[$j-1]);
	// 		if($arr[0]<$tmpnum){
	// 			$arr[0]=$tmpnum;
	// 			$arr[1]=$str[$j];
	// 		}	
	// 	}
	// 	return $arr;
	// }
	// $str="aaaddxxxxddddxx";
	// // $str.=strtoupper($str);
	// var_dump(maxLength($str));
	// function baimoneny($number){
	// 	$res=array();
	// 	for($i=1;$i<=$number;$i++){
	// 		$tmp=array();
	// 		for($j=1;$j<$i;$j++){
	// 			if($i%$j==0){
	// 				$tmp[]=$j;
	// 			}
	// 		}
	// 		if(array_sum($tmp)==$i){
	// 			$res[]=$i;
	// 		}
	// 	}
	// 	return $res;
	// }
	// var_dump(baimoneny(1000));
	// function quickSort($arr){
	// 	$left=array();
	// 	$right=array();
	// 	$key=$arr[0];
	// 	for($i=1;$i<count($arr);$i++){
	// 		if($arr[$i] <= $key){
	// 			$left[]=$arr[$i];
	// 		}else{
	// 			$right[]=$arr[$i];
	// 		}
	// 	}
	// 	if(!empty($left)){
	// 		$left=quickSort($left);
	// 	}
	// 	if(!empty($right)){
	// 		$right=quickSort($right);
	// 	}
	// 	return array_merge($left,array($key),$right);
	// }
	// $arr = array(225,220,41,190,242,185,42,231);
	// print_r(quickSort($arr));
	// function MK($n,$m){
	//     $monkey=range(1,$n);
	//     print_r($monkey);
	//     $i=0;
	//     while(count($monkey)>1){
	//         $i++;
	//         $header=array_shift($monkey);
	//         if($i%$m!==0){
	//                 array_push($monkey,$header);
	//         }
	//     }
	//     return $monkey[0];
	// }
	// echo MK(10,3);

	// function sheep(){
	// 	$num=1;
	// 	for($i=1;$i<=20;$i++){
	// 		for($j=1;$j<=5;$j++){
	// 			if($j%2==0){
	// 				$num++;
	// 			}
	// 		}
	// 	}
	// 	return $num;
	// }
	// echo sheep();

	

	// $arr=array(1,0,0,0,0);
	// for($i=1;$i<=10;$i++){
	// 	echo '=========-------<br/>';
	// 	print_r($arr);
	// 	$temp=$arr[1]+$arr[3];
	// 	array_unshift($arr,$temp);
	// 	print_r($arr);
	// 	array_pop($arr);
	// 	print_r($arr);
	// 	echo '=========-------<br/>';
	// }
	// echo array_sum($arr);
	// 
	// function num($num){
	// 	$tmp=array();
	// 	for($i=0;$i<$num;$i++){
	// 		$tmp[]=rand(1,1000);
	// 	}
	// 	$tmp=array_unique($tmp);
	// 	natsort($tmp);
	// 	return implode(' ',$tmp);
	// }
	// echo num(10);
	// 
	function num($n){
		$arr=array();
		$tmp='abcdefgh';
		$tmpstr=substr($tmp,0,$n);
		echo $tmpstr.'<br/>';
		echo strlen($tmpstr).'<br/>';
		for($i=0;$i<strlen($tmpstr);$i++){
			for($j=0;$j<strlen($tmpstr);$j++){
				if($tmpstr[$j]==$tmpstr[$i]){
					continue;
				}
				$tmpstr[$i].=$tmpstr[$j];
			}
		}
		return implode(',',$arr);
	}
	echo num(3);


// abc，acb，bac，bca，cba，cab；

                  

