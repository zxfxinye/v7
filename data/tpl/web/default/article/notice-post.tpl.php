<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 0) ? (include $this->template('common/header', TEMPLATE_INCLUDEPATH)) : (include template('common/header', TEMPLATE_INCLUDEPATH));?>
<ol class="breadcrumb we7-breadcrumb">
	<a href="<?php  echo url('article/notice/list');?>"><i class="wi wi-back-circle"></i> </a>
	<li>
		<a href="<?php  echo url('article/notice/list');?>">公告列表</a>
	</li>
	<li>
		添加公告
	</li>
</ol>
<?php  if($do == 'post') { ?>
	<form action="<?php  echo url('article/notice/post');?>" method="post" class="we7-form" role="form" id="form1">
		<input type="hidden" name="id" value="<?php  echo $notice['id'];?>"/>
				<div class="form-group">
					<label class="col-sm-2 control-label">用户组</label>
					<div class="col-sm-8 col-lg-9 col-xs-12">
						<span class="users-group-selected">全部</span><span class="btn btn-link color-default" data-toggle="modal" data-target="#users-group">修改</span>
						<span class="help-block">请选择哪些用户组可见，不设置代表全部用户组可见</span>
					</div>
				</div>
				
				<div class="form-group">
					<label class="col-sm-2 control-label">公告标题</label>
					<div class="col-sm-8 col-lg-9 col-xs-12">
						<input type="text" class="form-control" name="title" value="<?php  echo $notice['title'];?>" placeholder="公告标题"/>
						<div class="help-block">请填写公告标题</div>
					</div>
				</div>
				<div class="form-group">
					<label class="col-md-2 control-label">标题颜色</label>
					<div class="col-sm-8 col-sm-9 col-xs-12">
						<?php  echo tpl_form_field_color('style[color]', $notice['style']['color']);?>
						<span class="help-block">标题颜色，在列表中显示对应颜色，默认随系统</span>
					</div>
				</div>
				<div class="form-group">
					<label class="col-md-2 control-label">标题加粗</label>
					<div class="col-sm-8 col-sm-9 col-xs-12">
						<input type="radio" name="style[bold]" id="is_bold-1" value="1" <?php  if($notice['style']['bold'] == 1) { ?> checked<?php  } ?>> 
						<label class="radio-inline" for="is_bold-1">是</label>
						<input type="radio" name="style[bold]" id="is_bold-0" value="0" <?php  if($notice['style']['bold'] == 0) { ?> checked<?php  } ?>>
						<label class="radio-inline" for="is_bold-0"> 否</label>
						<span class="help-block">标题加粗，在列表中显示，默认不加粗</span>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label">公告分类</label>
					<div class="col-sm-8 col-lg-9 col-xs-12">
						<select name="cateid" id="cateid" class="form-control">
							<option value="">==请选择公告分类==</option>
							<?php  if(is_array($categorys)) { foreach($categorys as $category) { ?>
							<option value="<?php  echo $category['id'];?>" <?php  if($notice['cateid'] == $category['id']) { ?>selected<?php  } ?>><?php  echo $category['title'];?></option>
							<?php  } } ?>
						</select>
						<div class="help-block">还没有分类，点我 <a href="<?php  echo url('article/notice/category_post');?>" target="_blank"><i class="fa fa-plus-circle"></i> 添加分类</a></div>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label">内容</label>
					<div class="col-sm-8 col-lg-9 col-xs-12">
						<?php  echo tpl_ueditor('content', $notice['content']);?>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label">阅读次数</label>
					<div class="col-sm-8 col-lg-9 col-xs-12">
						<input type="text" class="form-control" name="click" value="<?php  echo $notice['click'];?>" placeholder="阅读次数"/>
						<div class="help-block">默认为0。您可以设置一个初始值,阅读次数会在该初始值上增加。</div>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label">排序</label>
					<div class="col-sm-8 col-lg-9 col-xs-12">
						<input type="text" class="form-control" name="displayorder" value="<?php  echo $notice['displayorder'];?>" placeholder="排序"/>
						<div class="help-block">数字越大，越靠前。</div>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label">是否显示</label>
					<div class="col-sm-8 col-lg-9 col-xs-12">
						<input type="radio" id="is_display-1" name="is_display" value="1" <?php  if($notice['is_display'] == 1) { ?> checked<?php  } ?>> 
						<label class="radio-inline" for="is_display-1">显示</label>
						<input type="radio" name="is_display" id="is_display-0" value="0" <?php  if($notice['is_display'] == 0) { ?> checked<?php  } ?>>
						<label class="radio-inline" for="is_display-0"> 不显示</label>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label">显示在首页</label>
					<div class="col-sm-8 col-lg-9 col-xs-12">
						<input type="radio" name="is_show_home" id="is_show_home-1" value="1" <?php  if($notice['is_show_home'] == 1) { ?> checked<?php  } ?>> 
						<label class="radio-inline" for="is_show_home-1">是</label>
						<input type="radio" name="is_show_home" id="is_show_home-0" value="0" <?php  if($notice['is_show_home'] == 0) { ?> checked<?php  } ?>>
						<label class="radio-inline" for="is_show_home-0"> 否</label>
					</div>
				</div>
		<div class="modal" id="users-group">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<h3 class="modal-title">选择用户组</h3>
					</div>
					<div class="modal-body we7-form">
						<div class="form-group">
							<?php  if(!empty($user_groups)) { ?>
							<?php  if(is_array($user_groups)) { foreach($user_groups as $key => $group) { ?>
								<div class="col-sm-4">
									<div class="checkbox">
										<input id="check-child-<?php  echo $key;?>" type="checkbox" value="<?php  echo $group['id'];?>" name="group[]" <?php  if(in_array($group['id'], $notice['group']['normal'])) { ?>checked = "checked"<?php  } ?>>
										<label for="check-child-<?php  echo $key;?>"><?php  echo $group['name'];?></label>
									</div>
								</div>
							<?php  } } ?>
							<?php  } else { ?>
								<div class="text-center">暂无数据</div>
							<?php  } ?>
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-primary confirm-users-group">确认</button>
						<button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
					</div>
				</div>
			</div>
		</div>
		<div class="modal" id="vice-founder-group">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<h3 class="modal-title">选择副创始人组</h3>
					</div>
					<div class="modal-body we7-form">
						<div class="form-group">
							<?php  if(!empty($user_vice_founder_groups)) { ?>
							<?php  if(is_array($user_vice_founder_groups)) { foreach($user_vice_founder_groups as $key => $vice_founder_group) { ?>
								<div class="col-sm-4">
									<div class="checkbox">
										<input id="check-child-<?php  echo $key;?>-<?php  echo $key;?>" type="checkbox" value="<?php  echo $vice_founder_group['id'];?>" name="vice_founder_group[]" <?php  if(in_array($vice_founder_group['id'], $notice['group']['vice_founder'])) { ?>checked<?php  } ?>>
										<label for="check-child-<?php  echo $key;?>-<?php  echo $key;?>"><?php  echo $vice_founder_group['name'];?></label>
									</div>
								</div>
							<?php  } } ?>
							<?php  } else { ?>
								<div class="text-center">暂无数据</div>
							<?php  } ?>
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-primary confirm-vice-founder-group">确认</button>
						<button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
					</div>
				</div>
			</div>
		</div>
		<div class="form-group">
			<div class="">
				<input type="submit" class="btn btn-primary" name="submit" value="提交" />
				<input type="hidden" name="token" value="<?php  echo $_W['token'];?>" />
			</div>
		</div>
	</form>
<?php  } ?>
<script>
	$(function(){
		var initChecked = function(type) {
			var type = type == 'users-group' ? 'users-group' : 'vice-founder-group';
			var inputtag = $('#' + type).find("input[type='checkbox']");
			var html = '';
			for (i in inputtag) {
				if (inputtag[i].checked) {
					html += '<span class="label label-primary">' + $(inputtag[i]).parent().find('label').text() + '</span> ';
				}
			}
			if (html) {
				$("." + type + '-selected').html(html);
			} else {
				$("." + type + '-selected').html('全部');
			}
		};
		initChecked('users-group');
		initChecked('vice-founder-group');

		$('.confirm-users-group').click(function() {
			initChecked('users-group');
			$('#users-group').modal('hide');
		});
		$('.confirm-vice-founder-group').click(function() {
			initChecked('vice-founder-group');
			$('#vice-founder-group').modal('hide');
		});
		$('#form1').submit(function(){
			if(!$.trim($(':text[name="title"]').val())) {
				util.message('请填写公告标题', '', 'error');
				return false;
			}
			if(!$.trim($('#cateid').val())) {
				util.message('请选择公告分类', '', 'error');
				return false;
			}
			if(!$.trim($('textarea[name="content"]').val())) {
				util.message('请填写公告内容', '', 'error');
				return false;
			}
			return true;
		});
	});
</script>
<?php (!empty($this) && $this instanceof WeModuleSite || 0) ? (include $this->template('common/footer', TEMPLATE_INCLUDEPATH)) : (include template('common/footer', TEMPLATE_INCLUDEPATH));?>