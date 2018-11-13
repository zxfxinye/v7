<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 0) ? (include $this->template('common/header', TEMPLATE_INCLUDEPATH)) : (include template('common/header', TEMPLATE_INCLUDEPATH));?>
	<div class="">
		<ol class="breadcrumb we7-breadcrumb">
			<a href="<?php  echo url('platform/qr/list');?>"><i class="wi wi-back-circle"></i> </a>
			<li><a href="<?php  echo url('platform/qr/list');?>">二维码列表</a></li>
			<li><a href="<?php  echo url('platform/url2qr');?>">长链接转二维码</a></li>
		</ol>
		<div class="we7-form" id="url-to-qr" ng-controller="UrlToQr" ng-cloak>
			<div class="form-group">
				<label for="" class="control-label col-sm-2">输入长链接</label>
				<div class="form-controls col-sm-9">
					<div class="input-group">
						<input type="text" name="longurl" class="form-control" id="longurl" value="<?php  echo $setting['welcome'];?>" placeholder="请输入长链接" autocomplete="off">
						<span class="input-group-btn color-default" ng-click="selectUrl()"><button class="btn btn-default"><i class="fa fa-external-link"></i>选择系统链接</button></span>
					</div>
					<span class="help-block">请输入您要转换的长链接，支持http://、https://、weixin://wxpay 格式的url</span>
					<span class="btn btn-primary we7-margin-horizontal-none we7-margin-vertical" id="change" ng-click="transformUrl()">立即转换</span>
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-sm-2">转换长链接</label>
				<div class="form-controls col-sm-9">
					<div class="url2qr-content">
						<div class="qr">
							<p>生成的二维码</p>
							<div class="qr-img">
								<img src="" id="qrsrc" style="border:1px solid #ccc;padding:0px;border-radius:4px;"/>
							</div>
							<a href="javascript:;" ng-click="downQr()" class="btn btn-default disabled">保存</a>
						</div>
						<div class="url">
							生成的短链接
							<div class="url-short">
								<input type="text" name="shorturl" id="shorturl" value="" class="form-control" disabled="disabled">
							</div>
							<a href="javascript:;" id="copy-0" class="btn btn-default disabled" clipboard supported="supported" text="copyLink" on-copied="success('0')">点击复制</a>
						</div>
					</div>
				</div>
			</div>
		</div>
		
	</div>
</div>
<script type="text/javascript">
	angular.module('qrApp').value('config', {
		site_url: "<?php  echo $_W['siteroot']?>",
		img_url: "<?php  echo  url('platform/url2qr/qr')?>",
		transform_url: "<?php  echo url('platform/url2qr/change')?>",
		down_url: "<?php  echo url('platform/url2qr/down_qr')?>",
	});

	angular.bootstrap($('#url-to-qr'), ['qrApp']);
</script>
<?php (!empty($this) && $this instanceof WeModuleSite || 0) ? (include $this->template('common/footer', TEMPLATE_INCLUDEPATH)) : (include template('common/footer', TEMPLATE_INCLUDEPATH));?>
