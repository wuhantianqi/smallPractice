/**
 * Created by CPR043 on 2015/5/11.
 */
jQuery(function($){
    $(".badge").css({"max-height":"15px","min-width":'15px',"font-size":"10px","padding":"0px","margin-left":"5px"});
    $(".btn").css({"border-radius":"3px"});
    $(".tab-content").css({"overflow":"hidden"});
    $(".well,.alert").css({"overflow":"hidden"});
    $(".radio,.checkbox").css({"margin":"0px"});
    $(".control-group .lbl").css({"font-size":"12px"});
    //$(".form-control").css("margin","10px 0px");
    $(".bootbox-body").css({"overflow":"hidden"});

    $("#tongguo").focus(function(){$("#noover").hide();});
    $("#weitongguo").focus(function(){$("#noover").show();});

    //$("body").append("<div class='zhezhao' />");
    $(".control-group input[type=checkbox],.control-group textarea").attr("disabled","");

    var window_gao = $(window).height();
    var window_kuan = $(window).width();
    var top_gao = $("#navbar").height();
    var admin_gao = $("#sidebar .breadcrumbs").height();
    var nav_gao = window_gao-top_gao-admin_gao-5;
    $(".zhezhao").css({"height":$(window).height(),"width":"100%"});//遮罩层
    $("#sidebar .nav").css({"max-height":nav_gao,"overflow-y":"auto"});//左边导航高度控制
    $(".main-content .page-content").css({"max-height":nav_gao,"overflow-y":"auto"});//主题部分高度控制

    var map_width = $("#add-shezhi-open").width();
    var map_height = $("#add-shezhi-open").height();
    $("#add-shezhi-open").css({"top":window_gao/2-map_height/2,"left":window_kuan/2-map_width/2});//添加商品-设置地图

    ////商品详情 —— 审核
    $(".box").css({"top":120,"left":window_kuan/2-($(".box").width())/2});

    $("#myTab").css({"border-bottom":"0px","overflow":"hidden"});
    $("#myTab a").css({"border-bottom":"1px"});
    $(".box-weitongguo").find("input[name='form-field-checkbox']").prop("disabled");


    //单元格自动超出隐藏
   // var a = $(".text-sl").parent("td").width();
    //$(".text-sl").css("width",$(".text-sl").parent("td").width());

    $(window).resize(function(){
        $(".btn").css({"border-radius":"3px"});
        var window_gao = $(window).height();
        var window_kuan = $(window).width();
        $(".zhezhao").css({"height":$(window).height(),"width":"100%"});
        var window_gao = $(window).height();
        var window_kuan = $(window).width();
        var top_gao = $("#navbar").height();
        var admin_gao = $("#sidebar .breadcrumbs").height();
        var nav_gao = window_gao-top_gao-admin_gao-5;
        $("#sidebar .nav").css({"max-height":nav_gao,"overflow-y":"auto"});//左边导航高度控制
        $(".main-content .page-content").css({"max-height":nav_gao,"overflow-y":"auto"});//主题部分高度控制

        var map_width = $("#add-shezhi-open").width();
        var map_height = $("#add-shezhi-open").height();
        $("#add-shezhi-open").css({"top":window_gao/2-map_height/2,"left":window_kuan/2-map_width/2});//添加商品-设置地图
    })
});