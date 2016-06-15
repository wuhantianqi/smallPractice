// JavaScript Document

$(function(){
	var winH = $(window).height();
	var scrollauto = winH-50;
	var ie8 = scrollauto + "px!important";
	$('#autoscroll').css('max-height',winH-50);
	$("#autoscroll_table").css('max-height',winH-80);
	$("#autoscroll_table0").css('max-height',winH-80);
	$("#autoscroll_table1").css('max-height',winH-110);
	$('#autoscroll2').css('height',winH-150);
	var aa = $('.panel-heading').text();
	if(aa='最近工单列表'){$('.panel-heading').parent('.panel-default').css('height',winH-150);}
	$(window).resize(function(){
		var winH = $(window).height();
		$('#autoscroll').css('max-height',winH-50);
		$('#autoscroll_table').css('max-height',winH-80);
		$("#autoscroll_table0").css('max-height',winH-80);
		$("#autoscroll_table1").css('max-height',winH-110);
		$('#autoscroll2').css('height',winH-150);
	var aa = $('.panel-heading').text();
	if(aa='最近工单列表'){$('.panel-heading').parent('.panel-default').css('height',winH-150);}
		})
	})
