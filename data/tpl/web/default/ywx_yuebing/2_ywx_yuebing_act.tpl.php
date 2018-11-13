<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/header', TEMPLATE_INCLUDEPATH)) : (include template('common/header', TEMPLATE_INCLUDEPATH));?>
<ul class="nav nav-tabs">
	<li <?php  if($op=='display') { ?>class="active"<?php  } ?>><a href="<?php  echo $this->createWebUrl($filename, array('op'=>'display'));?>">活动列表</a></li>
	<li <?php  if($op=='post' && empty($id)) { ?>class="active"<?php  } ?>><a href="<?php  echo $this->createWebUrl($filename, array('op'=>'post'));?>">添加活动</a></li>
	<?php  if(!empty($id)) { ?>
	<li class="active"><a>编辑活动</a></li>
	<?php  } ?>
</ul>

<?php  if($op== 'display') { ?>
<div class="main">
<div class="panel panel-info">
	<div class="panel-heading">筛选</div>
	<div class="panel-body">
		<form action="./index.php" method="get" class="form-horizontal" role="form">
			<input type="hidden" name="c" value="site" />
			<input type="hidden" name="a" value="entry" />
			<input type="hidden" name="m" value="<?php  echo $this->modulename?>" />
			<input type="hidden" name="do" value="<?php  echo $filename;?>" />
			<input type="hidden" name="op" value="<?php  echo $op;?>">
			
			<div class="form-group">
				<label class="col-xs-12 col-sm-2 col-md-2 col-lg-1 control-label">名称</label>
				<div class="col-xs-12 col-sm-8 col-lg-9">
					<input class="form-control" name="act_name"  type="text" value="<?php  echo $_GPC['act_name'];?>">
				</div>
			</div>
			

		
			
	       <div class="form-group">
				<div class=" col-xs-12 col-sm-2 col-lg-2" style="width:9%">
					<button class="btn btn-default"><i class="fa fa-search"></i>搜索</button>
				</div>					
			</div>			
		</form>
	</div>
</div>



<div class="panel panel-info">

  <button  type="button" class="btn btn-default" onclick="delete_all()">删除所有记录</button>
  <label><strong>全部记录:<?php  echo $total;?></strong></label>
</div>
 

<div class="panel panel-default">
	<div class="panel-body table-responsive" style="overflow:visible;">
		<table class="table table-hover">
		<thead class="navbar-inner">
		   	<tr>
			   	<th style="width:20%;">活动名称</th>
				<th style="width:15%;">活动时间</th>						
		        <th style="width:10%;">状态</th>
		        <th style="width:10%;">已报名人数</th>
		        <th style="width:15%;">创建时间</th>
		        <th style="width:20%;">操作</th>
			</tr>
		</thead>
		<tbody>
		<?php  if(is_array($list)) { foreach($list as $item) { ?>
			<tr>
			  <td style="white-space: normal; word-break: break-all;"><?php  echo $item['act_name'];?></td> 
		      <td style="white-space: normal; word-break: break-all;"><?php  echo date('Y-m-d H:i', $item['start_time']);?><br>至<br><?php  echo date('Y-m-d H:i', $item['end_time']);?></td> 	       
	          <td style="white-space: normal; word-break: break-all;">
				<?php  if($item['status'] == '0') { ?>
				   上架
				<?php  } else if($item['status'] == '1') { ?>
				  下架
				<?php  } ?>
			  </td>    
			  <td style="white-space: normal; word-break: break-all;"><?php  echo $item['baoming_numed'];?></td>
			  <td style="white-space: normal; word-break: break-all;">
					<?php  echo date('Y-m-d H:i:s', $item['createtime'])?>
			  </td>	
		  	  <td style="overflow:visible;">
				<div class="btn-group btn-group-sm">
					<a class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-expanded="false" href="javascript:;">入口 <span class="caret"></span></a>
					<ul class="dropdown-menu dropdown-menu-right" role="menu">
						<li>
							<a href="<?php  echo $item['url'];?>" target="_blank"><i class="fa fa-external-link fa-fw"></i> 直接访问</a>
						</li>
						<li role="presentation">
							<a href="javascript:;" onclick="displayUrl('<?php  echo $item['url'];?>');"><i class="fa fa-link fa-fw"></i> 查看链接</a>
						</li>
						<li role="presentation">
							<a href="javascript:;" onclick="displayQr('<?php  echo $_W['siteroot'] . 'web/'.substr($this->createWebUrl('qr', array('raw' => base64_encode($item['url']))),2)?>');"><i class="fa fa-qrcode fa-fw"></i> 查看二维码</a>
						</li>
					</ul>
				</div>
			    
				<a href="<?php  echo $this->createWebUrl($filename, array('op'=>'post','id'=>$item['id']));?>" 
				class="btn btn-default" data-toggle="tooltip">修改</a>
				
				<a href="<?php  echo $this->createWebUrl('ywx_yuebing_rec', array('act_id'=>$item['id']));?>" 
				class="btn btn-default" data-toggle="tooltip">参与记录</a>
				<a onclick="if(!confirm('删除后将不可恢复,确定删除吗?')) return false;" href="<?php  echo $this->createWebUrl($filename, array('op'=>'delete', 'id'=>$item['id']));?>" class="btn btn-default btn-danger" data-toggle="tooltip" data-placement="top" title="" data-original-title="删除">删除</a>
			      
				
			  </td>
		    </tr>
		<?php  } } ?>
			</tbody>		
		</table>
		<?php  echo $pager;?>
	</div>
  </div>
</div>

<script type="text/javascript">

	require(['bootstrap'],function($){

		$('.btn').hover(function(){

			$(this).tooltip('show');

		},function(){

			$(this).tooltip('hide');

		});

	});
	
	
	function displayUrl(url) {
		<?php  $guanzhu_code=md5($_W['config']['setting']['authkey']);?>
		var guanzhu_url=url+"&token_code=<?php  echo $guanzhu_code;?>";
		require(['jquery', 'util'], function($, u) {
			var content = '<p class="form-control-static" style="word-break:break-all">入口链接: <br>' + url + '</p>';
		
			var footer =
					'<button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>' +
					'<button type="button" class="btn btn-primary">复制入口链接</button>';
			var diaobj = u.dialog('查看URL', content, footer);
			diaobj.find('.btn-default').click(function() {
				diaobj.modal('hide');
			});
			diaobj.on('shown.bs.modal', function(){
				u.clip(diaobj.find('.btn-primary')[0], url);
				u.clip(diaobj.find('.btn_guanzhu')[0], guanzhu_url);
			});
			diaobj.modal('show');
		});
	}
	function displayQr(url) {
		require(['jquery', 'util'], function($, u) {
			var content = '<div class="panel panel-default text-center"><img src="' + url + '" alt="活动地址二维码" class="img-rounded"></div>';
			var footer =
					'<button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>';
			var diaobj = u.dialog('查看URL二维码', content, footer);
			diaobj.find('.btn-default').click(function() {
				diaobj.modal('hide');
			});
			diaobj.modal('show');
		});
	}
	
	function delete_all(){
	  if (confirm('确认删除所有信息吗,删除完不可恢复?')){
		  location.href ="<?php  echo $this->createWebUrl($filename, array('op' => 'delete_all'))?>";	
	  }
	}


</script>

<?php  } else if($op == 'post') { ?>
<div class="main">
	<form action="" method="post" class="form-horizontal form" id="form">
		<div class="panel panel-default">
			<div class="panel-heading">活动信息</div>
			<div class="panel-body">			
				
				<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-2 col-lg-2 control-label">活动名称</label>
					<div class="col-xs-12 col-sm-8">
						<input type="text"  class="form-control" name="data[act_name]" value="<?php  echo $page_data['act_name'];?>" />
					</div>
				</div>
				
				<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-2 col-lg-2 control-label">血量</label>
					<div class="col-xs-12 col-sm-8">
						<input type="text"  class="form-control" name="data[blood]" value="<?php  echo $page_data['blood'];?>" />
					</div>
				</div>
				
				<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-2 col-lg-2 control-label">吃月饼1分数</label>
					<div class="col-xs-12 col-sm-8">
						<input type="text"  class="form-control" name="data[c1_score]" value="<?php  echo $page_data['c1_score'];?>" />
					</div>
				</div>
				
					<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-2 col-lg-2 control-label">吃月饼2分数</label>
					<div class="col-xs-12 col-sm-8">
						<input type="text"  class="form-control" name="data[c2_score]" value="<?php  echo $page_data['c2_score'];?>" />
					</div>
				</div>
				
				<?php  $module_url=MODULE_URL.'/template/mobile/resource/assets/';?>
				
			
				<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-2 col-lg-2 control-label">背景图片</label>
					<div class="col-xs-12 col-sm-8">
						<?php  echo tpl_form_field_image('data[bg_img]', $page_data['bg_img'],"$module_url/bg.jpg");?>
					</div>
				</div>
				
			
				<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-2 col-lg-2 control-label">背景音乐地址</label>
					<div class="col-xs-12 col-sm-8">
						<?php  echo tpl_form_field_audio('data[bg_mp3]', $page_data['bg_mp3'])?>
						<span class="help-block">
	                                                           以http结尾必须为mp3文件,不填则为默认的。
	                       </span>
					</div>
				</div>




				
				<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-2 col-lg-2 control-label">已报名人数</label>
					<div class="col-xs-12 col-sm-4">
						<input type="text"  class="form-control" name="data[baoming_numed]" value="<?php  echo $page_data['baoming_numed'];?>" />
						<span class="help-block"></span>
					</div>
				</div>
				
	
			
				
				
				<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label">报名时间</label>
                    <div class="col-xs-12 col-sm-6">
                    	<div class="input-group">
							<?php  echo tpl_form_field_date('data[start_time]', $page_data['start_time'], true);?>
							<span class="input-group-addon">至</span>
							<?php  echo tpl_form_field_date('data[end_time]', $page_data['end_time'], true);?>
					    </div>
                    </div>
				</div>
				
			
				
		
												
				<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-2 col-lg-2 control-label">状态</label>
					<div class="col-xs-12 col-sm-4">
						<select name="data[status]" class="form-control">
							<option value="0" <?php  if($page_data['status'] == '0') { ?>selected<?php  } ?>>上架</option>
							<option value="1" <?php  if($page_data['status'] == '1') { ?>selected<?php  } ?>>下架</option>						
						</select>
					</div>
				</div>
				
													
			
						
					<div class="form-group">
						<label class="col-xs-12 col-sm-3 col-md-2 control-label">活动规则</label>
						<div class="col-xs-12 col-sm-9">
						<textarea id="hx_openid" name="data[act_desc]" class="form-control" rows="10" cols="60"><?php  echo $page_data['act_desc'];?></textarea>
							
							<span class="help-block"></span>
						</div>
					</div>
				
					
				<div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">分享标题</label>
                    <div class="col-xs-12 col-sm-9">
                        <input type="text" name="data[sharetitle]" value="<?php  echo $page_data['sharetitle'];?>" class="form-control">
                        <span class="help-block">输入{fromuser}可以显示粉丝名称，输入{act_name}可以显示活动名称！</span>
                    </div>
                </div>
                
                    
                 <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">分享描述</label>
                    <div class="col-xs-12 col-sm-9">
                        <input type="text" name="data[sharedescription]" value="<?php  echo $page_data['sharedescription'];?>" class="form-control">
                        <span class="help-block">输入{fromuser}可以显示粉丝名称，输入{act_name}可以显示活动名称！</span>
                    </div>
                </div>
                
                    
                 <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">分享图片</label>
                       <div class="col-xs-12 col-sm-9">
                         <?php  echo tpl_form_field_image('data[shareimage]',$page_data['shareimage']);?>
	       				<span class="help-block">分享图片</span>
                    </div>

                </div>
                
           
				
				<div class="form-group">
					<div class="col-xs-12 col-sm-9 col-md-10 col-lg-10 col-sm-offset-3 col-md-offset-2 col-lg-offset-2">
						<input type="hidden" name="id" value="<?php  echo $id;?>" />
						<input name="submit" type="submit" value="提交" class="btn btn-primary" />
						<input type="hidden" name="token" value="<?php  echo $_W['token'];?>" />
					</div>
				</div>
			</div>
		</div>
	</form>
</div>
<script>
    function removeRuleItem(obj) {
        $(obj).parent().parent().remove();
    }
</script>
<?php  } ?>

<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/footer', TEMPLATE_INCLUDEPATH)) : (include template('common/footer', TEMPLATE_INCLUDEPATH));?>
