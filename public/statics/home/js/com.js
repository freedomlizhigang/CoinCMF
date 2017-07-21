$(function() {
	
});
// 防止上拉下拉出现 浏览器滑动
function stopScrolling(touchEvent) {
	touchEvent.preventDefault();
}
// 计算高度及宽度
function resizeH(){
	var wWid = $(window).width(),wHgt = $(window).height(),hHgt = $('.head img').height();
	if (wHgt > 400) {
		$('.page').height((wHgt - hHgt) + 'px').css('top',hHgt + 'px');
		$('.p_bg').height((wHgt - hHgt) + 'px');
	}else{
		$('.page').height('400px').css('top',hHgt + 'px');
		$('.p_bg').height('400px');
	}
}