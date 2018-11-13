<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/header', TEMPLATE_INCLUDEPATH)) : (include template('common/header', TEMPLATE_INCLUDEPATH));?>
<div class="main">
	<form action="" method="post" class="form-horizontal form" enctype="multipart/form-data" id="setting-form">
		<div class="panel panel-default">
			<div class="panel-heading">参数设置</div>
			<div class="panel-body">
				<ul class="nav nav-tabs" id="myTab">
					<li class="active"><a href="#tab_basic">基本设置</a></li>
					<!-- <li><a href="#tab_vip">会员卡设置</a></li>
					<li><a href="#tab_other">其他设置</a></li> -->
				</ul>
				<div class="tab-content">
					<div class="tab-pane active" id="tab_basic">
					
							<div class="form-group">
							<label class="col-xs-12 col-sm-3 col-md-2 col-lg-2 control-label">是否静默模式</label>
							<div class="col-xs-12 col-sm-8">
								<label class="radio-inline"><input type="radio" value="0" name="data[silent_mode]" <?php  if(empty($settings['silent_mode'])) { ?>checked<?php  } ?>/>否</label>
								<label class="radio-inline"><input type="radio" value="1" name="data[silent_mode]" <?php  if($settings['silent_mode']==1) { ?>checked<?php  } ?>/>是</label>
								<span class="help-block">
					   静默授权就是不提示获取用户的昵称和头像。
					  </span>
							</div>
						</div>
					
					
					
					<div class="form-group">
						<label class="col-xs-12 col-sm-3 col-md-2 col-lg-2 control-label">是否调试模式</label>
						<div class="col-xs-12 col-sm-8">
							<label class="radio-inline"><input type="radio" value="0" name="data[debug_mode]" <?php  if(empty($settings['debug_mode'])) { ?>checked<?php  } ?>/>否</label>
							<label class="radio-inline"><input type="radio" value="1" name="data[debug_mode]" <?php  if($settings['debug_mode']==1) { ?>checked<?php  } ?>/>是</label>
							<span class="help-block">
					    如果页面有空白，可以调试模式开起来，调试模式情况下，提现也是默认成功的，运营时候务必此选项选择否。
					  </span>
						</div>
					</div>
					</div>
					
					<div class="tab-pane" id="tab_vip">
						
						<div class="form-group">
							<label class="col-xs-12 col-sm-2 col-md-2 col-lg-2 control-label">会员卡封面</label>
							<div class="col-sm-5">
								<?php  echo tpl_form_field_image('data[cover]', $settings['cover']);?>
							</div>
						</div>
						
						<div class="form-group">
							<label class="col-xs-12 col-sm-3 col-md-2 control-label">会员卡名称</label>
							<div class="col-sm-9 col-xs-12">
								<input type="text" name="data[vip_name]" value="<?php  echo $settings['vip_name'];?>" class="form-control">
								<span class="help-block"></span>
							</div>
						</div>
						
						<div class="form-group">
							<label class="col-xs-12 col-sm-3 col-md-2 control-label">会员卡价格</label>
							<div class="col-sm-9 col-xs-12">
								<input type="text" name="data[vip_fee]" value="<?php  echo $settings['vip_fee'];?>" class="form-control">
								<span class="help-block"></span>
							</div>
						</div>
						
						<div class="form-group">
							<label class="col-xs-12 col-sm-3 col-md-2 control-label">库存</label>
							<div class="col-sm-9 col-xs-12">
								<input type="text" name="data[vip_stock]" value="<?php  echo $settings['vip_stock'];?>" class="form-control">
								<span class="help-block"></span>
							</div>
						</div>
						
						<div class="form-group">
							<label class="col-xs-12 col-sm-3 col-md-2 control-label">特权</label>
							<div class="col-sm-9 col-xs-12">
								<?php  echo tpl_ueditor('data[vip_privilege]', $settings['vip_privilege']);?>
								<span class="help-block"></span>
							</div>
						</div>
						
						<div class="form-group" style='display:none'>
							<label class="col-xs-12 col-sm-3 col-md-2 control-label">使用须知</label>
							<div class="col-sm-9 col-xs-12">
								<?php  echo tpl_ueditor('data[vip_desc]', $settings['vip_desc']);?>
							</div>
						</div>
					</div>
					
					<div class="tab-pane" id="tab_other">
					
					
					
					
						
				
			   </div>
					</div>
				
				<div class="form-group col-sm-12">
					<input type="submit" name="submit" value="提交" class="btn btn-primary col-lg-1"/>
					<input type="hidden" name="token" value="<?php  echo $_W['token'];?>"/>
				</div>
			</div>
		</div>
</div>
</form>
</div>

<script>
    $(function () {
        window.optionchanged = false;
        $('#myTab a').click(function (e) {
            e.preventDefault();//阻止a链接的跳转行为
            $(this).tab('show');//显示当前选中的链接及关联的content
        });
        $('.tpl-district').remove();
    });
</script>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/footer', TEMPLATE_INCLUDEPATH)) : (include template('common/footer', TEMPLATE_INCLUDEPATH));?>