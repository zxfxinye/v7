<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/header', TEMPLATE_INCLUDEPATH)) : (include template('common/header', TEMPLATE_INCLUDEPATH));?>
<ul class="nav nav-tabs">
  <li <?php  if($op== 'display') { ?>class="active"<?php  } ?>><a href="<?php  echo $this->createWebUrl($filename)?>">报名管理</a></li>
  <li <?php  if($op== 'post' && empty($id)) { ?>class="active"<?php  } ?>><a href="<?php  echo $this->createWebUrl($filename,array('op'=>'post','act_id'=>$_GPC['act_id']))?>">新建报名</a></li>
  <?php  if(!empty($id)) { ?><li class="active"><a>编辑报名</a></li> <?php  } ?>
</ul>
<?php  if($op=='display') { ?>
<form action="./index.php" id="form1" method="get" class="form-horizontal" role="form">
<div class="panel panel-info">
  <div class="panel-heading">筛选</div>
  <div class="panel-body">
      <input type="hidden" name="c" value="site" />
      <input type="hidden" name="a" value="entry" />
      <input type="hidden" name="m" value="<?php  echo $this->modulename?>" />
      <input type="hidden" name="do" value="<?php  echo $filename;?>" />
      
      <div class="form-group">
				<label class="col-xs-12 col-sm-2 col-md-2 col-lg-1 control-label">活动</label>
				<div class="col-xs-12 col-sm-8 col-lg-9">
					<select id="act_id" name="act_id" class="form-control">
						<option value="">请选择活动</option>
						<?php  if(is_array($act_list)) { foreach($act_list as $i) { ?>
							<option value="<?php  echo $i['id'];?>" <?php  if($_GPC['act_id'] == $i['id']) { ?>selected<?php  } ?>><?php  echo $i['act_name'];?></option>
						<?php  } } ?>
					</select>
				</div>
			</div>
			
				
				
      
      <div class="form-group">
        <label class="col-xs-12 col-sm-2 col-md-2 col-lg-1 control-label">昵称</label>
        <div class="col-xs-12 col-sm-2 col-md-2 col-lg-4">
          <input class="form-control" name="nickname" id="" type="text" value="<?php  echo $_GPC['nickname'];?>" placeholder="">
        </div>
      </div>
          <div class="form-group">
        <label class="col-xs-12 col-sm-2 col-md-2 col-lg-1 control-label">openid</label>
        <div class="col-xs-12 col-sm-2 col-md-2 col-lg-4">
          <input class="form-control" name="openid" id="" type="text" value="<?php  echo $_GPC['openid'];?>" placeholder="">
        </div>
      </div>
      <div class="form-group">
        <div class="col-xs-12 col-sm-3 col-md-2 control-label">
        	<input class="btn btn-default" type="submit" name="export" value="导出" style="margin-right: 10px;" />
          <button class="btn btn-default"><i class="fa fa-search"></i>搜索</button>
        </div>
      </div>
  </div>
</div>
<div class="panel panel-default">
  <div class="panel-heading">报名列表    (共<i style="color:red"><?php  echo $total;?></i>条记录)</div>
  <div class="panel-body table-responsive" style="overflow: visible;">
    <table class="table table-hover">
      <thead class="navbar-inner">
        <tr>
          <th style="width: 5%;">选择</th>
          <th style="width: 7%;">会员id</th>
          <th style="width: 10%;">活动名称</th>
          <th style="width: 10%;">openid</th>
          <th style="width: 10%;">昵称</th>
          <th style="width: 10%;">头像</th>

          <th style="width: 10%;">分数</th>
          <th style="width: 10%;">时间</th>
          <th style="width: 20%;">操作</th>
        </tr>
      <tbody id="main">
        <?php  if(is_array($list)) { foreach($list as $row) { ?>
        <tr>
          <td><input type="checkbox" name="id[]" value="<?php  echo $row['id'];?>" class=""></td>
          <td style="white-space: normal; word-break: break-all"><?php  echo $row['mid'];?></td>
          <td style="white-space: normal; word-break: break-all">(<?php  echo $row['act_id'];?>)<?php  echo $row['act_name'];?></td>
          <td style="white-space: normal; word-break: break-all"><?php  echo $row['openid'];?></td>
          <td style="white-space: normal; word-break: break-all"><?php  echo $row['nickname'];?></td>
          <td style="white-space: normal; word-break: break-all"><?php  if(($row['headimgurl'])) { ?><img style="width:80px" src="<?php  echo tomedia($row['headimgurl'])?>"><?php  } ?></td>
  
          <td style="white-space: normal; word-break: break-all"><?php  echo $row['score'];?></td>
          <td style="white-space: normal; word-break: break-all"><?php  echo date('Y-m-d H:i', $row['createtime'])?></td>
          <td style="white-space: normal; word-break: break-all; overflow: visible;">
            <a href="<?php  echo $this->CreateWebUrl($filename,array('op'=>'post','id'=>$row['id']))?>" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="编辑"><i class="fa fa-edit" ></i></a>
            <a onclick="if(!confirm('确定删除，删除后数据不可恢复?')) return false;" href="<?php  echo $this->CreateWebUrl($filename,array('op'=>'delete','id'=>$row['id']))?>" class="btn btn-danger" data-toggle="tooltip" data-placement="top" title="删除"><i class="fa fa-times"></i></a>
          </td>
        </tr>
        <?php  } } ?>
        <tr>
          <td>
            <input type="checkbox" name="" onclick="var ck = this.checked;$(':checkbox').each(function(){this.checked = ck});">
          </td>
          <td colspan="16">
            <input type="hidden" id="op" name="op"/>
            <a href="javascript:batch_del();" class="btn btn-default 
btn-primary" data-toggle="tooltip" data-placement="top" title="批量删除"><i class="fa fa-times"></i>批量删除</a>
          </td>
        </tr>
      </tbody>
    </table>
    </form>
  </div>
  <?php  echo $pager;?>
</div>
</form>
<script type="text/javascript">
require(['bootstrap' ], function($) {
  $('.btn').hover(function() {$(this).tooltip('show');},
  function() {$(this).tooltip('hide');});
});
function displayUrl(url) {
  require(['jquery', 'util' ],function($, u) {
    var content = '<p class="form-control-static" style="word-break:break-all">直达链接: <br>'+ url + '</p>';
    var footer = '<button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>' + '<button type="button" class="btn btn-primary">复制直达链接</button>';
    var diaobj = u.dialog('查看URL', content, footer);
    diaobj.find('.btn-default').click(function() {diaobj.modal('hide');});
    diaobj.on('shown.bs.modal', function() {u.clip(diaobj.find('.btn-primary')[0], url);});
  diaobj.modal('show');
  });
}
function displayQr(url) {
  require(['jquery', 'util' ],function($, u) {
    var content = '<div class="panel panel-default text-center"><img src="' + url + '" alt="二维码" class="img-rounded"></div>';
    var footer = '<button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>';
    var diaobj = u.dialog('查看URL二维码', content, footer);
    diaobj.find('.btn-default').click(function() {diaobj.modal('hide');});
    diaobj.modal('show');
  });
}
function delete_all() {
  if (confirm('确认删除所有信息吗,删除完不可恢复?')) {
    location.href = "<?php  echo $this->createWebUrl($filename, array('op' => 'delete_all'))?>";
  }
}
function batch_del() {
  if (!confirm('确定批量删除吗?')){
    return false;
  }else {
    $('#op').val('batch_del');
    $('#form1').submit();
  }
}
</script>
<?php  } ?>
<?php  if($op=='post') { ?>
<div class="main">
  <form action="" method="post" class="form-horizontal form" id="form">
    <div class="panel panel-default">
      <div class="panel-heading">报名信息</div>
      <div class="panel-body">
      	<div class="form-group">
		 <label class="col-xs-12 col-sm-3 col-md-2 control-label">活动id</label>
		 <div class="col-sm-9 col-xs-12">
			<input type="text" id="" class="form-control span7"
				   placeholder="" name="page_data[act_id]" <?php  if($id) { ?>  readonly value="<?php  echo $page_data['act_id'];?>" <?php  } else { ?>  readonly value="<?php  echo $_GPC['act_id'];?>" <?php  } ?>">
			<span class="help-block">
                  
            </span>
		</div>
		</div>
      
        <div class="form-group">
          <label class="col-xs-12 col-sm-3 col-md-2 col-lg-2 control-label">活动名称</label>
          <div class="col-xs-12 col-sm-8">
            <input type="text" class="form-control" name="page_data[act_name]" value="<?php  echo $page_data['act_name'];?>" />
          </div>
        </div>
    
        <div class="form-group">
          <label class="col-xs-12 col-sm-3 col-md-2 col-lg-2 control-label"><span style="color:red">*</span>openid</label>
          <div class="col-xs-12 col-sm-8">
            <input type="text" class="form-control" name="page_data[openid]" value="<?php  echo $page_data['openid'];?>" />
          </div>
        </div>
        <div class="form-group">
          <label class="col-xs-12 col-sm-3 col-md-2 col-lg-2 control-label"><span style="color:red">*</span>昵称</label>
          <div class="col-xs-12 col-sm-8">
            <input type="text" class="form-control" name="page_data[nickname]" value="<?php  echo $page_data['nickname'];?>" />
          </div>
        </div>
        <div class="form-group">
          <label class="col-xs-12 col-sm-3 col-md-2 col-lg-2 control-label"><span style="color:red">*</span>头像</label>
          <div class="col-xs-12 col-sm-8">
            <?php  echo tpl_form_field_image("page_data[headimgurl]", $page_data['headimgurl']);?>
          </div>
        </div>
        

        <div class="form-group">
          <label class="col-xs-12 col-sm-3 col-md-2 col-lg-2 control-label">分数</label>
          <div class="col-xs-12 col-sm-8">
            <input type="text" class="form-control" name="page_data[score]" value="<?php  echo $page_data['score'];?>" />
          </div>
        </div>
     
        <div class="form-group">
          <label class="col-xs-12 col-sm-3 col-md-2 col-lg-2 control-label">备注</label>
          <div class="col-xs-12 col-sm-8">
            <input type="text" class="form-control" name="page_data[remark]" value="<?php  echo $page_data['remark'];?>" />
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
<?php  } ?>
