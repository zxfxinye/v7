<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/header', TEMPLATE_INCLUDEPATH)) : (include template('common/header', TEMPLATE_INCLUDEPATH));?>


<div class="main"> <form action="" method="post" class="form-horizontal form">

<div class="panel panel-default">
    <div class="panel-heading">
       <h4>借用高级认证设置（卡券无法使用借权功能）<small>如果你的公众号没有oauth2接口权限。</small></h4>
    </div>
    <div class="panel-body">
        <div class="form-group">
            <label class="col-xs-12 col-sm-3 col-md-2 control-label">AppId</label>
            <div class="col-sm-9 col-xs-12">
               <input type="text" name="appid" class="form-control" value="<?php  echo $set['appid'];?>" />
        </div>
        </div>
 <div class="form-group">
            <label class="col-xs-12 col-sm-3 col-md-2 control-label">AppSecret</label>
            <div class="col-sm-9 col-xs-12">
               	 <input type="text" name="appsecret" class="form-control" value="<?php  echo $set['appsecret'];?>" />
            </div>
        </div>
     
            
                  
         <div class="form-group">
            <label class="col-xs-12 col-sm-3 col-md-2 control-label"></label>
            <div class="col-sm-9 col-xs-12">
               	借用说明：必需设置借用高级认证号的OAuth2.0网页授权的回调域名为你公众号第三方平台的全域名。
                如：你的系统域名为：www.xxxx.com ，你必需让借用高级认证号设置OAuth2.0网页授权的回调域名为:www.xxxx.com
                <br />
                <img src="../addons/kuaiwei_exmall/images/appid.jpg">
                <br />
                <img src="../addons/kuaiwei_exmall/images/jssdk.png">
            </div>
        </div>
            
            
    </div>
    
        
</div>
    

        
        <div class="form-group col-sm-12">
			<input type="submit" name="submit" value="提交" class="btn btn-primary col-lg-1" />
			<input type="hidden" name="token" value="<?php  echo $_W['token'];?>" />
		</div>
        
    </form>
    </div>
 
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/footer', TEMPLATE_INCLUDEPATH)) : (include template('common/footer', TEMPLATE_INCLUDEPATH));?>