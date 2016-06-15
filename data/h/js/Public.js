/**
 * Created by CPR043 on 2015/5/27.
 */
$(document).ready(function () {
    $(".btn").css({"border-radius":"3px"});
    $(".radio,.checkbox").css({"margin":"0px"});
    $(".control-group .lbl").css({"font-size":"12px"});
    $(".tabbable li").css("cursor","pointer");
    var window_gao = $(window).height();
    var window_kuan = $(window).width();
    var top_gao = $("#navbar").height();
    var admin_gao = $("#sidebar .breadcrumbs").height();
    var nav_gao = window_gao-top_gao-admin_gao-5;
    var navH = $(".main-content .breadcrumbs").height();

    $(".laydate-icon").css({"min-height":"30px"});
    $(".tab-content,.well,.alert,.widget-main").css({"overflow":"hidden"});
    $(".zhezhao").css({"height":$(window).height(),"width":"100%"});//遮罩�?
    $(".zhezhao2").css({"height":"100%","width":"100%","background":"#333333","opacity":"0.7","position":"fixed","top":"0px","z-index":"15","display":"none"});//遮罩�?
    //翻页
    $(".paging_bootstrap").find("a").css("padding","0px 5px");
    $(".paging_bootstrap").parent().parent().css("padding","5px 0px");
    //弹出框位�?
    $(".box").css({"top":120,"left":window_kuan/2-($(".box").width())/2});

    //表格内容  样式设置
    $(".scroll-table-more,.scroll-table").parent().css("padding","0px");
    $(".scroll-table-more table tr td,.scroll-table table tr td").css({"border":"1px solid #DDD","border-left":"none","cursor":"pointer"});
    $("iframe").css({"min-height":window_gao-145,"overflow-y":"auto"});
    //$(".phone-iframe").find(".tab-pane").children("iframe").css({"max-height":window_gao-200,"overflow-y":"auto"})
    //表格部分   有详细信�?
    $(".scroll-table-more").css({"overflow":"hidden","max-height":window_gao-500,"overflow-y":"auto"});
    //表格部分   无下面详细信�?
    $(".scroll-table").css({"overflow":"hidden","max-height":window_gao-225,"overflow-y":"auto"});
    $(".tab-content-hulf").css({"min-height":$(window).height()-600,"overflow-y":"auto"});
    //$(".tab-content-all").css({});
    //$(".tabbable").eq(1).find(".tab-pane").css({"max-height":window_gao-380,"overflow-y":"auto"});
    //table  横向滚动样式
    $(".sample-table").parent().css({"overflow":"hidden","overflow-x":"auto"});
    $("i").css({"cursor":"pointer"});
    //table部分   排序操作
    $(".popover").hide();
    $(".sample-table").find("th").children().click(function(){
        var a = $(this).children("i").prop("class");
        if(a=="icon-caret-down pull-right"){
            $(this).children().last().prop("class","icon-caret-up pull-right");
        }
        else if(a=="icon-caret-up pull-right"){
            $(this).children().last().prop("class","icon-caret-down pull-right")
        }
    });
    $(".popover-content").css({"min-width":"130px","max-width":"300px"})
    $(".sample-table").find("i").click(function(){
        var a = $(this).attr("class");
        if(a=="icon-search pull-left"){
            $(this).parent().css("position","relative");
            $(".popover").hide();
            $(this).next().show().css({"top":"30px","right":"0px;"})
        }
    });
    $(".sample-table").find("a").click(function(){
        var a = $(this).text();
        if(a=="GO"){$(this).parents(".popover").hide();}
    });
    //设置table列表排序
    var leng = $(".tabbable ul").find("div").find("li").length;
    $(".tabbable ul").find("div").find("span").eq(0).children("i").first().css("color","#B3ACAC").next().css("color","#B3ACAC");
    $(".tabbable ul").find("div").find("span").eq(leng-1).children("i").last().css("color","#B3ACAC").prev().css("color","#B3ACAC");
    $(".tabbable ul").find("i").click(function(){
        var a = $(this).prop("class");
        var b = $(this).parents("li").index();
        if(a=="icon-angle-down"){
            var htmla = $(this).parents("ul").children("li").eq(b).html();
            alert(htmla)
        }
    });
    //table部分   右侧各类操作按钮集合
    $("#myTab4").find("div").prop("class","col-xs-4 pull-right text-right");//右侧按钮�?
    //table部分   选中tr样式
    $(".scroll-table-more table tr").click(function(){
        $(".scroll-table-more table tr").css("background-color","#fff");
        $(this).css({"background-color":"#D9EDF7"});
    });
    $(".scroll-table-more").click(function(){
        $(".scroll-table-more").css("background-color","#fff");
        $(this).css({"background-color":"#D9EDF7"});
    });
    $(".box").find(".widget-body").css({"max-height":window_gao-210,"overflow-y":"auto"});
    $(".zhezhao2").css({"width":$(window).width(),"height":$(window).height()});
    $(".table_all_check").click(function () {
        $(this).parents(".sample-table").find(".scroll-table").find("input[type='checkbox']").prop("checked",$(this).prop("checked"));
        $(this).parents(".sample-table").find(".scroll-table-more").find("input[type='checkbox']").prop("checked",$(this).prop("checked"));
    });

    $(".box-choose").css({"top":window_gao/2-($(".box-choose").height())/2,"left":window_kuan/2-($(".box-choose").width())/2});
    $(window).resize(function(){
        var window_gao = $(window).height();
        var window_kuan = $(window).width();
        var top_gao = $("#navbar").height();
        var admin_gao = $("#sidebar .breadcrumbs").height();
        var nav_gao = window_gao-top_gao-admin_gao-5;
        var navH = $(".main-content .breadcrumbs").height();
        $(".zhezhao").css({"height":$(window).height(),"width":"100%"});//遮罩�?
        $("#sidebar .nav").css({"max-height":nav_gao,"overflow-y":"auto"});//左边导航高度控制
        //$(".main-content .page-content").css({"max-height":nav_gao,"overflow-y":"auto"});//主题部分高度控制
        //弹出框位�?
        $(".box").css({"top":120,"left":window_kuan/2-($(".box").width())/2});
        $(".box-huifang").css({"top":window_gao/2-($(".box-huifang").height())/2,"left":window_kuan/2-($(".box-huifang").width())/2});
        //表格部分   有详细信�?
        $(".scroll-table").css({"overflow":"hidden","max-height":window_gao-225,"overflow-y":"auto"});
        //$(".tabbable").eq(1).find(".tab-pane").css({"max-height":(window_gao-top_gao-navH-380)/2,"overflow-y":"auto"});
        $(".scroll-table-more").css({"overflow":"hidden","max-height":window_gao-top_gao-navH-300,"overflow-y":"auto"});
        $(".box").find(".widget-body").css({"max-height":window_gao-210,"overflow-y":"auto"});
    })
});


function closex(){
    $(".zhezhao,.box,.lxkh,.shezhi,.zhezhao2").hide();
}

function close_huifang(){
    $(".zhezhao2,.box-lxkh,.box-FQA,.box-ts,.box-cjgd,.box-xxsjh").hide();
}
function closex1(){
    $(this).hide();
}
function liucheng_add(){
    $(".zhezhao").show();
    $(".box-tongguo").eq(4).show();
}
function hdgz_add(){
    $(".zhezhao").show();
    $(".box-tongguo").eq(3).show();
}
function scsj_add(){
    $(".zhezhao").show();
    var winH = $(window).height();
    $(".box-tongguo").eq(2).show();
}
function yxls_add(){
    $(".zhezhao").show();
    $(".box-tongguo").eq(1).show();
}
function xgwd_add(){
    $(".zhezhao").show();
    $(".box-tongguo").eq(0).show();
}
function tgsh(){
    $(".control-group input[type=checkbox],.control-group textarea").attr("disabled","");
    $(".control-group input[type=checkbox]").removeAttr("checked");
    $(".control-group textarea").val("");

}
function wtgsh(){
    $(".control-group input[type=checkbox],.control-group textarea").removeAttr("disabled");
}
function tijiao(){
    $(".zhezhao,.box").hide();
}

function huifang_open(){
    $(".zhezhao").show();
    $(".box-tongguo").show();
}
function tousu_open(){
    $(".zhezhao").show();
    $(".box-tousu").show();
}
function choose_open(){
    $(".box-choose,.zhezhao2").show();
}
function closex2(){$(".box-choose,.zhezhao2").hide();}

function modal_msg(tit,msg){
    var ohtml='<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">\
<div class="modal-dialog"><div class="modal-content"><div class="modal-header">\
<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>\
<h4 class="modal-title" id="myModalLabel">'+tit+'</h4></div>\
<div class="modal-body">'+msg+'</div>\
<div class="modal-footer">\
<button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>\
<button type="button" class="btn btn-primary">提交更改</button>\
</div></div></div></div>';
    $('body').append(ohtml);
    $('#myModal').modal({
        keyboard: true
    })
}
function modal_alert(msg){
    var ohtml='<div class="modal fade" id="myModal2" tabindex="-1" role="alert" aria-labelledby="myModalLabel" aria-hidden="false">\
<div class="modal-alert">\
<div class="modal-content">\
<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>\
<div class="modal-body">'+msg+'</div>\
<div class="modal-footer tc">\
<button type="button" class="btn btn-primary btn-sm" data-dismiss="modal" style="border-radius:4px">确定</button>\
</div></div></div></div>';
    if($('#myModal2').length){
        $('#myModal2').find('.modal-body').text(msg);
    }else{
        $('body').append(ohtml);
    }
    $('#myModal2').modal();
}