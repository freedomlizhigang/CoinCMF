@extends('home.layout')

@section('content')
	<script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js" type="text/javascript" charset="utf-8"></script>
	<script type="text/javascript" charset="utf-8">
	    wx.config({!! $js->config(array('onMenuShareTimeline', 'onMenuShareAppMessage','onMenuShareQQ','onMenuShareWeibo','onMenuShareQZone','scanQRCode','chooseImage','uploadImage'), true) !!});
	    wx.ready(function(){
	    	wx.onMenuShareTimeline({
	    	    title: '希夷工作室', // 分享标题
	    	    link: 'http://www.xi-yi.ren', // 分享链接，该链接域名或路径必须与当前页面对应的公众号JS安全域名一致
	    	    imgUrl: 'http://www.xi-yi.ren/statics/home/images/logo.png', // 分享图标
	    	    success: function () { 
	    	        alert('恭喜分享成功！');
	    	    },
	    	    cancel: function () { 
	    	        alert('真难过，分享失败了~');
	    	    }
	    	});
	    	wx.onMenuShareAppMessage({
	    	    title: '希夷工作室', // 分享标题
	    	    desc: '希夷工作室是本地最好的技术服务商', // 分享标题
	    	    link: 'http://www.xi-yi.ren', // 分享链接，该链接域名或路径必须与当前页面对应的公众号JS安全域名一致
	    	    imgUrl: 'http://www.xi-yi.ren/statics/home/images/logo.png', // 分享图标
	    	    success: function () { 
	    	        alert('恭喜分享给朋友成功！');
	    	    },
	    	    cancel: function () {
	    	        alert('真难过，分享失败了~');
	    	    }
	    	});
	    });
	    wx.error(function(res){
		    alert('JsSDK 调用失败~刷新页面重试');
		});
		$(function(){
			$('.scanQRCode').click(function(){
		    	wx.scanQRCode({
				    needResult: 1, // 默认为0，扫描结果由微信处理，1则直接返回扫描结果，
				    scanType: ["qrCode","barCode"], // 可以指定扫二维码还是一维码，默认二者都有
				    success: function (res) {
					    var result = res.resultStr; // 当needResult 为 1 时，扫码返回的结果
					    alert(result);
					}
				});
			});
			// 图片这个上传太麻烦了
			$('.chooseImage').click(function(){
				var localIds;var serverId;
		    	wx.chooseImage({
				    count: 1, // 默认9
				    sizeType: ['original', 'compressed'], // 可以指定是原图还是压缩图，默认二者都有
				    sourceType: ['album', 'camera'], // 可以指定来源是相册还是相机，默认二者都有
				    success: function (res) {
				        localIds = res.localIds; // 返回选定照片的本地ID列表，localId可以作为img标签的src属性显示图片
				        alert(localIds[0] + ' --- 111');
				        wx.uploadImage({
				            localId: localIds[0], // 需要上传的图片的本地ID，由chooseImage接口获得
				            isShowProgressTips: 1, // 默认为1，显示进度提示
				            success: function (res) {
				                serverId = res.serverId; // 返回图片的服务器端ID
				                $('.uploadimg').attr('src',serverId);
				                $('.uploadimgsrc').text(serverId);
				        		alert(serverId + '结果');
				            }
				        });
				    }
				});
			});

		})
	</script>
	<h3 class="scanQRCode">扫一扫</h3>
	<h3 class="chooseImage">上传图片</h3>
	<p class="uploadimgsrc"></p>
	<img src="" class="uploadimg" alt="">
@endsection