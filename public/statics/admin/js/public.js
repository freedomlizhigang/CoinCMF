// lay里的jquery
layui.use(['layer', 'form','element'],function(){
	var layer = layui.layer,form = layui.form;
	var element = layui.element;
	// 获取窗口宽度
	var window_w = $("html").width();
	window.onload = window.onresize = function(){
		$("#LAY_app").removeClass("layadmin-side-shrink").removeClass("layadmin-side-spread-sm");
		// 获取窗口宽度
		window_w = $("html").width();
	};

	// 侧导航点击
	element.on('nav(layadmin-system-side-menu)', function(elem){
		// layer.msg(elem.attr("lay-href"));
		var tLink = elem.attr("lay-href");
		if(tLink == "javascript:;" || tLink == null || tLink == "" || tLink == "#"){
			return false;
		}
		if( tLink ){
			$(".layadmin-iframe:eq(0)").attr("src",tLink);
		}
	});

	// 侧栏收缩与展开
	$(".layadmin-flexible ,.layadmin-body-shade").on("click",function(){
		if(window_w > 1024){
			$("#LAY_app").toggleClass("layadmin-side-shrink");
			if($("#LAY_app").hasClass("layadmin-side-shrink")){
				$(this).find("#LAY_app_flexible").attr("class","layui-icon layui-icon-spread-left");
			}else{
				$(this).find("#LAY_app_flexible").attr("class","layui-icon layui-icon-shrink-right");
			}
		}else{
			$("#LAY_app").toggleClass("layadmin-side-spread-sm");
			if($("#LAY_app").hasClass("layadmin-side-spread-sm")){

				$(this).find("#LAY_app_flexible").attr("class","layui-icon layui-icon-shrink-right");
			}else{
				$(this).find("#LAY_app_flexible").attr("class","layui-icon layui-icon-spread-left");
			}
		}

	});

	// 展开个人资料下的内容
	$(".layui-layout-right .layui-nav-item").hover(function(){
		$(this).addClass("layui-this");
		$(this).find(".layui-nav-more").addClass("layui-nav-mored");
		$(this).find("dl").addClass("layui-show");
	},function(){
		$(this).removeClass("layui-this");
		$(this).find(".layui-nav-more").removeClass("layui-nav-mored");
		$(this).find("dl").removeClass("layui-show");
	});

});