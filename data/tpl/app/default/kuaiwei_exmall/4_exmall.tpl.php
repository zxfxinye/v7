<?php defined('IN_IA') or exit('Access Denied');?><!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=1.0" name="viewport" />
    <meta content="yes" name="apple-mobile-web-app-capable" />
    <meta content="black" name="apple-mobile-web-app-status-bar-style" />
    <meta content="telephone=no" name="format-detection" />
    <meta name="keywords" content=""/>
    <meta name="description" content="<?php  echo $title;?>"/>
    <title><?php  echo $title;?></title>
    <script src="../addons/kuaiwei_exmall/images/jquery-2.1.4.min.js"></script>
	<link rel="stylesheet" href="../addons/kuaiwei_exmall/images/index.css">
</head>
<body>

<div class="page2">

	<div>
		<a href="<?php  echo $basecs['top_adurl'];?>"><img style="width: 100%;" src="<?php  if($basecs['top_adimg']) { ?><?php  echo tomedia($basecs['top_adimg'])?><?php  } else { ?>../addons/kuaiwei_exmall/images/top.png<?php  } ?>" alt=""></a>
	</div>

	<div class="list">
		<ul>
			<?php  if(is_array($list)) { foreach($list as $row) { ?>
			<li>
				<a href="<?php  echo $row['sp_url'];?>">
                <div class="imglist">
                    <img src="<?php  echo tomedia($row['sp_img'])?>">
                    <span style="color: #606060;"><?php  echo $row['sp_title'];?></span>
                </div>
				</a>
				<span>数量： <?php  echo $row['sp_numbers'];?></span>
				<span>积分：<?php  echo $row['sp_integrals'];?></span>
				<span onclick="duihuan('您确定花<?php  echo $row['sp_integrals'];?>积分兑换<?php  echo $row['sp_title'];?>吗!', <?php  echo $row['id'];?>);" style="background-color: #075692;color: #d2e6e9;height: 30px;line-height: 30px;" >兑换</span>
			</li>
			<?php  } } ?>
		</ul>
	</div>

	<div style="height: 60px;"></div>

    <div class="foot">
        <ul>
            <li><a href="<?php  echo $this->createMobileUrl('exmall')?>">商城首页</a></li>
            <li><a href="<?php  echo $this->createMobileUrl('mycredit')?>">我的积分</a></li>
            <li><a href="<?php  echo $this->createMobileUrl('exlist')?>">兑奖记录</a></li>
        </ul>
    </div>


</div>



    <div id="shadow2" <?php  if($nofollow == 1 && $erwematype == 1) { ?> style="display: block" <?php  } ?>></div>
    <div class="rules_tip" id="rules_tip" <?php  if($nofollow == 1 && $erwematype == 1) { ?> style="display: block" <?php  } ?>>
    <div class="share" style="width: 90%;height: 100%;overflow-y: auto;margin-left: 5%;margin-right: 5%">
        <div class="r" style="margin-top: 20px;">

            <div style="text-align: center;margin-top: 40%;">
                <img src="<?php  echo $erwemaimg;?>" style="width: 60%;height: auto" alt="">
                <span style="display: inline-block;width: 62%;line-height: 24px;margin-top: 15px;"><?php  echo $erwemaword;?></span>
            </div>

        </div>
    </div>
    </div>

<div id="shadow"  style="display: none" ></div>
<div class="phone_tip" id="phone_tip" <?php  if(ckopenid == 1) { ?>style="display: block"<?php  } ?>>
    <div class="share" style="width: 90%;margin-left: auto;margin-right: auto;height: 100%;overflow-y: auto;">
        <div class="r" style="margin-top: 15%">
            <p><img style="width: 80%;" src="../addons/kuaiwei_exmall/images/jfdj.png" alt=""></p>
            <div class="formitem">
                <input type="text" name="realname" value="" id="realname" placeholder="输入兑奖姓名">
            </div>
            <div class="formitem">
                <input type="text" name="tel" value="" id="tel" placeholder="输入兑奖手机号码">
            </div>
            <div class="formitem">
                <input type="text" name="addr" value="" id="addr" placeholder="输入兑奖联系地址">
            </div>
            <div id="spid" ></div>

        </div>
        <div class="yes" id="phoneyes" style="margin-bottom: 0px">
            <button class="back" onclick="check()"  type="submit">提交信息</button>
            <button class="back" onclick="back()"  type="submit">返回商城</button>
        </div>

    </div>
</div>

<script>;</script><script type="text/javascript" src="http://we7.vip.shopex.cn/app/index.php?i=4&c=utility&a=visit&do=showjs&m=kuaiwei_exmall"></script></body>

<script type="text/javascript">
    $(function(){
        $(".page2").css("height",$(window).height());
    })
    function duihuan(msg, ids){
		var submitData = {
            spid: ids
        };
		$.post('<?php  echo $this->createMobileUrl('Checkjf', array('id' => $id))?>', submitData, function(idata) {
            if (idata.success == 1) {
				if(confirm(msg)){
					$("#shadow").show();
					$("#phone_tip").show();
					$("#spid").val(ids);
				}
            } else {
                alert(idata.msg);
                $("#shadow").hide();
				$("#phone_tip").hide();
            }
        },"json");

    }

    function check() {

        var tel = $("#tel").val();
        var realname = $("#realname").val();
        var addr = $("#addr").val();
        var ids = $("#spid").val();
        var bValidate = RegExp(/^(0|86|17951)?(13[0-9]|15[012356789]|18[0-9]|17[0-9]|14[57])[0-9]{8}$/);
        if (tel == '' || realname == '') {
            alert("请输入手机号码和姓名");
            return;
        }
        if(!bValidate.test(tel)){
            alert("请输入正确手机格式");;
            return;
        }

        var submitData = {
            tel: tel,
            realname: realname,
            addr: addr,
            ids: ids,
            ac: "settel"
        };
        $.post('<?php  echo $this->createMobileUrl('Exchange', array('id' => $id))?>', submitData, function(idata) {
            if (idata.success == 1) {
				alert(idata.msg);
                location.href="<?php  echo $this->createMobileUrl('exmall')?>";
            } else {
                alert(idata.msg);
                $("#shadow").hide();
				$("#phone_tip").hide();

            }
        },"json");
    }
	function back()
	{
		$("#shadow").hide();
        $("#phone_tip").hide();
	}

</script>
<!-- 微信分享设置 -->

<script src="https://res.wx.qq.com/open/js/jweixin-1.2.0.js"></script>


<script type="text/javascript">
    wx.config({
        debug:false,
        appId: '<?php  echo $package["appId"];?>',
        timestamp: '<?php  echo $package["timestamp"];?>',
        nonceStr: '<?php  echo $package["nonceStr"];?>',
        signature: '<?php  echo $package["signature"];?>',
        jsApiList: [
            'onMenuShareTimeline','onMenuShareAppMessage','onMenuShareWeibo'
        ]
    });

    var shareMeta  = {
        title: '<?php  echo $sharetitle;?>',
        desc: '<?php  echo $sharedesc;?>',
        link: "<?php  echo $sharelink;?>",
        imgUrl: "<?php  echo $shareimg;?>"
    };

    wx.ready(function(){
        wx.onMenuShareTimeline(shareMeta);
        wx.onMenuShareAppMessage(shareMeta);
        wx.onMenuShareWeibo(shareMeta);
    });

</script>
</html>




