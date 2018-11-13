<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/header', TEMPLATE_INCLUDEPATH)) : (include template('common/header', TEMPLATE_INCLUDEPATH));?>
<ul class="nav nav-tabs">
	<li <?php  if($op=='display') { ?>class="active"<?php  } ?>><a href="<?php  echo $this->createWebUrl($filename, array('op'=>'display'));?>">会员列表</a></li>
	<li <?php  if($op=='post' && empty($id)) { ?>class="active"<?php  } ?>><a href="<?php  echo $this->createWebUrl($filename, array('op'=>'post'));?>">添加会员</a></li>
	<?php  if(!empty($id)) { ?>
	<li class="active"><a>编辑会员</a></li>
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
				<label class="col-xs-12 col-sm-2 col-md-2 col-lg-1 control-label">id</label>
				<div class="col-xs-12 col-sm-8 col-lg-9">
					<input class="form-control" placeholder="" 
					name="id"  type="text" value="<?php  echo $_GPC['id'];?>">
				</div>
			</div>
			              
              <div class="form-group">
				<label class="col-xs-12 col-sm-2 col-md-2 col-lg-1 control-label">昵称</label>
				<div class="col-xs-12 col-sm-8 col-lg-9">
					<input class="form-control" placeholder="" 
					name="nickname"  type="text" value="<?php  echo $_GPC['nickname'];?>">
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
	<div class="panel-body table-responsive">
		<table class="table table-hover">
		<thead class="navbar-inner">
	   <tr>
		   <th style="width:5%;">id</th>
		   <th style="width:5%;">pid</th>
	    <th style="width:15%;">头像</th>
		<th style="width:15%;">微信id</th>	
		<th style="width:15%;">unionid</th>			
		<th style="width:15%;">昵称</th>				  
        <th style="width:10%;">是否关注</th>
        <th style="width:18%;">创建时间</th>
        <th style="width:20%;">操作</th>
		</tr>
		</thead>
			<tbody>
		<?php  if(is_array($list)) { foreach($list as $item) { ?>
		<tr>
			<td><?php  echo $item['id'];?></td>
			<td><?php  echo $item['pid'];?></td>
			<td><img alt="" src='<?php  echo tomedia($item["headimgurl"]);?>' width="30px" ></td>
	      <td><?php  echo $item['openid'];?></td> 
	       <td><?php  echo $item['unionid'];?></td> 
          <td><?php  echo $item['nickname'];?></td>        
          <td title=""><?php  if(($item['subscribe']==0)) { ?>否<?php  } else { ?>是<?php  } ?></td>
         
			    <td title="<?php  echo date('Y-m-d H:i:s', $item['createtime'])?>">
					<?php  echo date('Y-m-d H:i:s', $item['createtime'])?></td>	
				<td>
				<div style="padding: 6px 12px;">
					<a  class="btn btn-default" 
					href="<?php  echo $this->createWebUrl($filename, array('op' => 'post', 'id' => $item['id']))?>">
					修改</a>	
			        <a class="btn btn-default" href="<?php  echo $this->createWebUrl($filename, array('op' => 'delete', 'id' => $item['id']))?>"
				     onclick="return confirm('确认删除信息吗？');return false;">删除</a>
				</div>				
				</td>				
				</tr>
				<?php  } } ?>
			</tbody>		
		</table>
		<?php  echo $pager;?>
	</div>
  </div>
</div>

<?php  } else if($op == 'post') { ?>
<div class="panel panel-default">
    <div class="panel-heading">
        用户修改
    </div>
    <div class="panel-body">
	<form action="" method="post" class="form-horizontal" role="form" id="form1">
        <div class="form-group model0">
                <label class="col-xs-12 col-sm-3 col-md-2 control-label">头像</label>
                  <div class="col-sm-9 col-xs-12">            
                    <?php  echo tpl_form_field_image('page_data[headimgurl]',$page_data['headimgurl']);?>
                <div class="help-block">
                      </div>  
                </div>
      </div>


       <div class="form-group">
            <label class="col-xs-12 col-sm-3 col-md-2 control-label">微信id</label>
            <div class="col-sm-9 col-xs-12">
                <input type="text" id="openid" class="form-control span7"
                       placeholder="" name="page_data[openid]" value="<?php  echo $page_data['openid'];?>">
                       <span class="help-block">
      
              </span>
            </div>  
        </div>
		
		<div class="form-group">
			<label class="col-xs-12 col-sm-3 col-md-2 control-label">pid</label>
			<div class="col-sm-9 col-xs-12">
				<input type="text"  class="form-control span7"
				       placeholder="" name="page_data[pid]" value="<?php  echo $page_data['pid'];?>">
				<span class="help-block">
      
              </span>
			</div>
		</div>
      
          <div class="form-group">
            <label class="col-xs-12 col-sm-3 col-md-2 control-label">昵称</label>
            <div class="col-sm-9 col-xs-12">
                <input type="text" id="nickname" class="form-control span7"
                       placeholder="" name="page_data[nickname]" value="<?php  echo $page_data['nickname'];?>">
                       <span class="help-block">
      
              </span>
            </div>  
            </div>
            
      
            <div class="form-group">
                    <label class="col-sm-2 control-label">是否输入报名信息</label>
                    <div class="col-sm-10">
                        <div>
                            <label class="radio-inline">
                                <input type="radio" name="page_data[subscribe]" 
                                ng-model="type" value="0"
                                  <?php  if(($page_data['subscribe']==0)) { ?> checked="checked" <?php  } ?>
                                 class="ng-pristine ng-valid ng-touched"> 否
                            </label>
                            <label class="radio-inline">
                                <input type="radio" name="page_data[subscribe]" ng-model="type" 
                                  <?php  if(($page_data['subscribe']==1)) { ?> checked="checked" <?php  } ?>
                                value="1" class="ng-pristine ng-valid ng-touched"> 是
                            </label>
                           
                           
                        </div>
                      
                    </div>
            </div>
		
		
		<div class="form-group">
			<label class="col-sm-2 control-label">vip</label>
			<div class="col-sm-10">
				<div>
					<label class="radio-inline">
						<input type="radio" name="page_data[vip]"
						       ng-model="type" value="0"
						       <?php  if(($page_data['vip']==0)) { ?> checked="checked" <?php  } ?>
						class="ng-pristine ng-valid ng-touched"> 否
					</label>
					<label class="radio-inline">
						<input type="radio" name="page_data[vip]" ng-model="type"
						       <?php  if(($page_data['vip']==1)) { ?> checked="checked" <?php  } ?>
						value="1" class="ng-pristine ng-valid ng-touched"> 是
					</label>
				
				
				</div>
			
			</div>
		</div>

         
		<div class="form-group">
				<div class="col-sm-8">
					<input type="hidden" name="id" value="<?php  echo $id;?>" />
					<input type="submit" name="submit" value="提交" class="btn btn-primary">
					<input type="hidden" name="token" value="<?php  echo $_W['token'];?>" />
				</div>		
		</div>
		
		</form>
    </div>
</div>
<?php  } ?>

<script type="text/javascript">

function delete_all(){
  if (confirm('确认删除所有信息吗,删除完不可恢复?')){
	  location.href ="<?php  echo $this->createWebUrl($filename, array('op' => 'delete_all'))?>";	
  }
}





</script>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/footer', TEMPLATE_INCLUDEPATH)) : (include template('common/footer', TEMPLATE_INCLUDEPATH));?>
