$(function(){
	var pid=document.createElement('div');    //创建div元素
	var popup=document.createElement('div');   //创建弹出框
	popup.setAttribute('class','popup');        //元素添加属性
	pid.setAttribute('class','reply');        //元素添加属性
	var ul=document.createElement('ul');      //创建ul元素
	var bool=true;                           //显示或隐藏开关
	ul.setAttribute('class','pid');
	var num=10;                               //加载多少张图片
	var hnum=3;                              //每行显示多少张图片
	var Small_w=86;                        //缩略图宽
	var Small_h=38;                        //缩略图高
	var large_w=460;                           //大图宽
	var large_h=230;                           //大图高
	var li='';
	for (var i = 1; i < num; i++) {
		li += '<li><img src="./images/E___010'+i+'GD00SIGT.gif" alt=""/></li>';
	}
	pid.appendChild(ul);
	document.body.appendChild(popup);           //添加弹出框元素
	document.body.appendChild(pid);           	//添加图片框元素
	$('.pid').html(li);
	$('.popup').css({                         //弹出框样式
		'width': large_w+'px',
		'height': large_h+'px',
		'position':'fixed',
		'left':'35%',
		'top':'37%',
		'background':'rgba(255,255,255,0.8)',
		'opacity':'0',
		'text-align':'center',
	});
	$('.reply').css({                                           
		'position':'absolute',
		'right':'23%',
		'bottom':'38%',
		'background':'#FFF',
		'width': (Small_w*hnum+72)+'px',
		'height':'auto',
		'display':'none',
	});
	$('.pid >li').css({
		'width':(Small_w+10)+'px',
		'height':(Small_h+10)+'px',
		'background':'yellow',
		'text-align':'center',
		'padding-top':'10px',
		'float':'left',
		'margin-left':'10px',
		'margin-top':'10px',
		'margin-bottom':'5px',
		'cursor':'pointer',
	});
	$('.pid >li >img').css({
		'width':Small_w+'px',
		'height':Small_h+'px',
	});
	$(document).on('mouseenter','.god',function(){    //移入小方块
		$('.reply').css('display','block');
	});
	$(document).on('mouseleave','.god',function(){   //移出小方块
		setTimeout(function(){                       //延迟一秒执行
			if(bool){
				$('.reply').css('display','none');
			}
		},1000);
	})
	$(document).on('mouseenter','.reply',function(){   //移入图片区
		bool=false;
		$('.reply').css('display','block');            
	})
	$(document).on('mouseleave','.reply',function(){   //移出图片区
		bool=true;
		$('.reply').css('display','none');            
	})
	var screen_w=$(document).width();          //浏览器当前窗口可视区域宽度
	var screen_h=$(document).height();         //浏览器当前窗口可视区域高度
	$('.reply li').each(function(n){           //点击相应图片
		$(this).click(function(){
			$('.popup').css('opacity','0');    //点击前弹出框隐藏
			$('.popup').animate({opacity:'1'},'1500');  //弹出框显示
			var ejectpic='<img src="./images/E___010'+(n+1)+'GD00SIGT.gif" alt=""/>';
			$('.popup').html(ejectpic);  
			$('.popup img').animate({               //缩小
				width:'-=5px',
				height:'-=5px',
			},150,function(){
				$('body').css({
					'width': (screen_w+30)+'px',
					'height':(screen_h+30)+'px',
				});
			});
			$('.popup img').animate({              //放大
				width:'+=50px',
				height:'+=50px',
			},50,function(){
				$('body').css({
					'width':(screen_w+10)+'px',
					'height':(screen_h+10)+'px',
				});
			});
			$('.popup img').animate({              //还原
				width:large_w+'px',
				height:large_h+'px',
			},10,function(){
				$('body').css({
					'width':screen_w+'px',
					'height':screen_h+'px',
				});
			});
		})
	})
	/**
	 * 设置兼容性
	 * 分辨率1920,默认
	 * 分辨率1600
	 * 分辨率1440
	 * 只做一个的兼容
	 */
	switch(screen_w){
		case 1600:
		$('.god').css("right",'11%');
		$('.reply').css('right','15%');
		break;
		case 1440:
		$('.god').css("right",'4%');
		$('.reply').css('right','9%');
		break;
	}
})