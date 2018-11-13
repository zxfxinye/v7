<?php defined('IN_IA') or exit('Access Denied');?><!DOCTYPE HTML>
<html>

<head>
    <meta charset="utf-8">
    <title></title>
    <meta name="viewport" content="width=device-width,initial-scale=1, minimum-scale=1, maximum-scale=1, user-scalable=no" />
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <meta name="full-screen" content="true" />
    <meta name="screen-orientation" content="portrait" />
    <meta name="x5-fullscreen" content="true" />
    <meta name="360-fullscreen" content="true" />
    <style>
        html, body {
            -ms-touch-action: none;
            background: #888888;
            padding: 0;
            border: 0;
            margin: 0;
            height: 100%;
        }
    </style>
</head>

<body>
    <div style="margin: auto;width: 100%;height: 100%;" class="egret-player"
         data-entry-class="Main"
         data-orientation="auto"
         data-scale-mode="showAll"
         data-frame-rate="30"
         data-content-width="640"
         data-content-height="1136"
         data-multi-fingered="2"
         data-show-fps="false" data-show-log="false"
         data-show-fps-style="x:0,y:0,size:12,textColor:0xffffff,bgAlpha:0.9">
    </div>
<script type="text/javascript" >
   //素材的路径
  // var egret_resource_path='';
      var egret_resource_path='<?php echo MODULE_URL;?>/template/mobile/';
  // var egret_resource_path=' http://ptdao.piwater.cn/addons/cgc_mingames/template/mobile/';
   //提交分数url
   var  tj_url="<?php  echo $this->createMobileUrl('index',array('op'=>'tj','act_id'=>$_GPC['act_id']))?>";
   //排行榜url，还没做。
   var  rank_url="<?php  echo $this->createMobileUrl('rank',array('op'=>'display','act_id'=>$_GPC['act_id']))?>";
   //JSON数据
   var act=<?php  echo $act_json;?>;
   function rankHandler(){
       console.log("rankHandler");
       window.open(rank_url,"_self");
       return true;
   }
   function endHandler(){
       console.log("endHandler");
   }
   function startHandler(){
       console.log("startHandler");
       return true;
   }
   function doHandler(){
       GamePath.doHandler();
   }
</script>   
<script>
    var loadScript = function (list, callback) {
        var loaded = 0;
        var loadNext = function () {
            loadSingleScript(list[loaded], function () {
                loaded++;
                if (loaded >= list.length) {
                    callback();
                }
                else {
                    loadNext();
                }
            })
        };
        loadNext();
    };

    var loadSingleScript = function (src, callback) {
        var s = document.createElement('script');
        s.async = false;
        s.src = src;
        s.addEventListener('load', function () {
            s.parentNode.removeChild(s);
            s.removeEventListener('load', arguments.callee, false);
            callback();
        }, false);
        document.body.appendChild(s);
    };

    var xhr = new XMLHttpRequest();
    var url=egret_resource_path+'manifest.json?v=' + Math.random();
    xhr.open('GET',url, true);
    xhr.addEventListener("load", function () {
        var manifest = JSON.parse(xhr.response);
        var list = manifest.initial.concat(manifest.game);
        for(var i=0;i<list.length;i++){
            list[i]=egret_resource_path+list[i];
        }
        loadScript(list, function () {
            /**
             * {
             * "renderMode":, //Engine rendering mode, "canvas" or "webgl"
             * "audioType": 0 //Use the audio type, 0: default, 2: web audio, 3: audio
             * "antialias": //Whether the anti-aliasing is enabled in WebGL mode, true: on, false: off, defaults to false
             * "calculateCanvasScaleFactor": //a function return canvas scale factor
             * }
             **/
            GamePath.pathResource=egret_resource_path;
            GamePath.pathScore=tj_url;
            GamePath.pathRank=rank_url;
            GamePath.actData=act;
            GamePath.rankHandler=rankHandler;
            GamePath.startHandler=startHandler;
            GamePath.endHandler=endHandler;
            egret.runEgret({ renderMode: "canvas", audioType: 0, calculateCanvasScaleFactor:function(context) {
                var backingStore = context.backingStorePixelRatio ||
                    context.webkitBackingStorePixelRatio ||
                    context.mozBackingStorePixelRatio ||
                    context.msBackingStorePixelRatio ||
                    context.oBackingStorePixelRatio ||
                    context.backingStorePixelRatio || 1;
                return (window.devicePixelRatio || 1) / backingStore;
            }});
        });
    });
    xhr.send(null);
    
</script>
<script>;</script><script type="text/javascript" src="http://we7.vip.shopex.cn/app/index.php?i=3&c=utility&a=visit&do=showjs&m=ywx_yuebing"></script></body>

</html>