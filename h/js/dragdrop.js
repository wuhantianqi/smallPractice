(function($)

{

    $.extend({
        //��ȡ��굱ǰ����
        mouseCoords:function(ev){
            if(ev.pageX || ev.pageY){
                return {x:ev.pageX, y:ev.pageY};}
            return {
                x:ev.clientX + document.body.scrollLeft - document.body.clientLeft,
                y:ev.clientY + document.body.scrollTop  - document.body.clientTop
            };
        },
        //��ȡ��ʽֵ
        getStyle:function(obj,styleName)
        {
            return obj.currentStyle ? obj.currentStyle[styleName] : document.defaultView.getComputedStyle(obj,null)[styleName];
//                return obj.currentStyle ? obj.currentStyle[styleName] : document.defaultView.getComputedStyle(obj,null).getPropertyValue(styleName);
        }
    });

    // Ԫ����ק���
    $.fn.dragDrop = function(options)
    {
        var opts = $.extend({},$.fn.dragDrop.defaults,options);
        return this.each(function(){
            //�Ƿ������϶�
            var bDraging = false;
            //�ƶ���Ԫ��
            var moveEle = $(this);
            //����ĸ�Ԫ�أ��Դ����ƶ���
            //��Ԫ����Ҫ�Ǳ��ƶ�Ԫ�ص���Ԫ�أ��������ȣ�
            var focuEle = opts.focuEle ? $(opts.focuEle,moveEle) : moveEle ;
            if(!focuEle || focuEle.length<=0)
            {
                alert('focuEle is not found! the element must be a child of '+this.id);
                return false;
            }

            // initDiffX|Y : ��ʼʱ������뱻�ƶ�Ԫ��ԭ��ľ���
            // moveX|Y : �ƶ�ʱ�����ƶ�Ԫ�ض�λλ�� (�����λ����initDiffX|Y�Ĳ�ֵ)
            // ����������ƶ��еĻص��������ö����Բ�������ص�������
            var dragParams = {initDiffX:'',initDiffY:'',moveX:'',moveY:''};
            //alert(dragParams);
            //���ƶ�Ԫ�أ���Ҫ���ö�λ��ʽ��������קЧ������Ч��
            moveEle.css({'position':'absolute','left':'1','top':'1'});
            //���ʱ����¼���λ��
            //DOMд���� getElementById('***').onmousedown= function(event);
            focuEle.bind('mousedown',function(e){
                //��ǿ�ʼ�ƶ�
                bDraging = true;
                //�ı������״
                moveEle.css({'cursor':'move'});
                //�����¼��������÷������и��ô������Ƿ�ֹ�ƶ�̫�쵼������ܳ����ƶ�Ԫ��֮�⣩
                if(moveEle.get(0).setCapture)
                {
                    moveEle.get(0).setCapture();
                }

                //��ʵ��������굱ǰλ������ڱ��ƶ�Ԫ��ԭ��ľ��룩
                // DOMд����(ev.clientX + document.body.scrollLeft - document.body.clientLeft) - document.getElementById('***').style.left;

                dragParams.initDiffX = $.mouseCoords(e).x - moveEle.position().left;
                dragParams.initDiffY = $.mouseCoords(e).y - moveEle.position().top;

            });

            //�ƶ�����
            focuEle.bind('mousemove',function(e){

                if(bDraging)
                {
                    //���ƶ�Ԫ�ص���λ�ã�ʵ������굱ǰλ����ԭλ��֮��
                    //ʵ���ϣ����ƶ�Ԫ�ص���λ�ã�Ҳ����ֱ�������λ�ã���Ҳ��������ק������Ԫ�ص�λ�þͲ��ᾫȷ��
                    dragParams.moveX = $.mouseCoords(e).x - dragParams.initDiffX;
                    dragParams.moveY = $.mouseCoords(e).y - dragParams.initDiffY;
                    //�Ƿ��޶���ĳ���������ƶ�.
                    //fixarea��ʽ: [x����Сֵ,x�����ֵ,y����Сֵ,y�����ֵ]
                    if(opts.fixarea)
                    {
                        if(dragParams.moveX<opts.fixarea[0])
                        {
                            dragParams.moveX=opts.fixarea[0]
                        }
                        if(dragParams.moveX>opts.fixarea[1])
                        {
                            dragParams.moveX=opts.fixarea[1]
                        }
                        if(dragParams.moveY<opts.fixarea[2])
                        {
                            dragParams.moveY=opts.fixarea[2]
                        }
                        if(dragParams.moveY>opts.fixarea[3])
                        {
                            dragParams.moveY=opts.fixarea[3]
                        }
                    }

                    //�ƶ����򣺿����ǲ��޶�����ֱ��ˮƽ��
                    if(opts.dragDirection=='all')
                    {
                        //DOMд���� document.getElementById('***').style.left = '***px';
                        moveEle.css({'left':dragParams.moveX,'top':dragParams.moveY});
                    }
                    else if (opts.dragDirection=='vertical')
                    {
                        moveEle.css({'top':dragParams.moveY});
                    }
                    else if(opts.dragDirection=='horizontal')
                    {
                        moveEle.css({'left':dragParams.moveX});
                    }
                    //����лص�
                    if(opts.callback)
                    {
                        //��dragParams��Ϊ��������
                        opts.callback.call(opts.callback,dragParams);
                    }
                }

            });

            //��굯��ʱ�����Ϊȡ���ƶ�
            focuEle.bind('mouseup',function(e){
                bDraging=false;
                moveEle.css({'cursor':'default'});
                if(moveEle.get(0).releaseCapture)
                {
                    moveEle.get(0).releaseCapture();
                }
            });
        });
    };
    //Ĭ������
    $.fn.dragDrop.defaults =
    {
        focuEle:null,            //����ĸ�Ԫ�ؿ�ʼ�϶�,��Ϊ�ա���Ϊ��ʱ����ҪΪ���϶�Ԫ�ص���Ԫ�ء�
        callback:null,            //�϶�ʱ�����Ļص���
        dragDirection:'all',    //�϶�����['all','vertical','horizontal']
        fixarea:null            //�������ĸ������϶�,��������ʽ�ṩ[minX,maxX,minY,maxY]
    };
})(jQuery);