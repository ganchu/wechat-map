<?php
//微信打开看效果http://comment.csnet.net.cn/home/map/index/baidumap/23.024347,113.115298/title/楼盘名/address/位置名,如果还没挂的话
require_once "jssdk.php";
$jssdk = new JSSDK("开发者ID(AppID)", "开发者密码(AppSecret)");//公众号资料
$signPackage = $jssdk->GetSignPackage();
$LatLng=$_POST['baidumap'];//'23.024347,113.115298';
$title=$_POST['title'];//内容
$address=$_POST['address'];//位置名
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>位置</title>
</head>
<body>
</body>
<script charset="utf-8" src="http://map.qq.com/api/js?v=2.exp&key=CJDBZ-RK7R4-5GWUA-D35DA-NDJQV-TDF5I"></script>
<script src="http://map.qq.com/api/js?v=2.exp&key=CJDBZ-RK7R4-5GWUA-D35DA-NDJQV-TDF5I&libraries=convertor" type="text/javascript"></script>
<script src="http://res.wx.qq.com/open/js/jweixin-1.2.0.js"></script>
<script>
    //百度坐标转换为腾讯坐标

    var global_lat,global_lng;
    qq.maps.convertor.translate(new qq.maps.LatLng(<?php echo $LatLng; ?>), 3, function (res) {
      //console.log(res[0].lat);console.log(res[0].lng);
      global_lat = res[0].lat;
      global_lng = res[0].lng;
    })
  /*
   * 注意：
   * 1. 所有的JS接口只能在公众号绑定的域名下调用，公众号开发者需要先登录微信公众平台进入“公众号设置”的“功能设置”里填写“JS接口安全域名”。
   * 2. 如果发现在 Android 不能分享自定义内容，请到官网下载最新的包覆盖安装，Android 自定义分享接口需升级至 6.0.2.58 版本及以上。
   * 3. 常见问题及完整 JS-SDK 文档地址：http://mp.weixin.qq.com/wiki/7/aaa137b55fb2e0456bf8dd9148dd613f.html
   *
   * 开发中遇到问题详见文档“附录5-常见错误及解决办法”解决，如仍未能解决可通过以下渠道反馈：
   * 邮箱地址：weixin-open@qq.com
   * 邮件主题：【微信JS-SDK反馈】具体问题
   * 邮件内容说明：用简明的语言描述问题所在，并交代清楚遇到该问题的场景，可附上截屏图片，微信团队会尽快处理你的反馈。
   */
  wx.config({
    debug: false,
    appId: '<?php echo $signPackage["appId"];?>',
    timestamp: <?php echo $signPackage["timestamp"];?>,
    nonceStr: '<?php echo $signPackage["nonceStr"];?>',
    signature: '<?php echo $signPackage["signature"];?>',
    jsApiList: [
      // 所有要调用的 API 都要加到这个列表中
        'openLocation',
        'getLocation',
    ]
  });
  wx.ready(function () {
    wx.getLocation({
      type: 'wgs84', // 默认为wgs84的gps坐标，如果要返回直接给openLocation用的火星坐标，可传入'gcj02'
      success: function (res) {
      var latitude = res.latitude; // 纬度，浮点数，范围为90 ~ -90
      var longitude = res.longitude; // 经度，浮点数，范围为180 ~ -180。
      var speed = res.speed; // 速度，以米/每秒计
      var accuracy = res.accuracy; // 位置精度
      }
      });
    wx.openLocation({
      latitude: global_lat, // 纬度，浮点数，范围为90 ~ -90
      longitude:global_lng, // 经度，浮点数，范围为180 ~ -180。
      name: "<?php echo $address; ?>", // 位置名
      address: "<?php echo $title; ?>", // 地址详情说明
      scale: 22, // 地图缩放级别,整形值,范围从1~28。默认为最大
      infoUrl: '' // 在查看位置界面底部显示的超链接,可点击跳转
      });
  });
</script>
</html>