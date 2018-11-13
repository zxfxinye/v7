<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/header', TEMPLATE_INCLUDEPATH)) : (include template('common/header', TEMPLATE_INCLUDEPATH));?>
<div class="main">
	<ul class="nav nav-tabs">
		<li<?php  if($_GPC['do'] == 'spmanage' || $_GPC['do'] == '' ) { ?> class="active"<?php  } ?>><a href="<?php  echo $this->createWebUrl('spmanage');?>">商品管理</a></li>
		<li<?php  if($_GPC['do'] == 'jfmanage') { ?> class="active"<?php  } ?>><a href="<?php  echo $this->createWebUrl('jfmanage');?>">积分兑换管理</a></li>
		<li<?php  if($_GPC['do'] == 'admanage') { ?> class="active"<?php  } ?>><a href="<?php  echo $this->createWebUrl('admanage');?>">广告管理</a></li>
		<li<?php  if($_GPC['do'] == 'baseset') { ?> class="active"<?php  } ?>><a href="<?php  echo $this->createWebUrl('baseset');?>">基础设置</a></li>
	</ul>
    
	<div class="panel panel-primary">
		<div class="panel-heading" style="text-align: left;">
			<button class="btn btn-success wzxx" type="button"><i class="fa fa-search"></i> 添加商品</button>
		</div>
		<div class="panel-body table-responsive">
		<table class="table table-hover">
			<thead class="navbar-inner">
				<tr>
					<th style="width:200px;">商品图片</th>
					<th style="width:300px;">商品名称</th>
					<th style="width:250px">商品数量</th>
					<th style="width:150px">商品兑换积分数</th>
					<th style="width:100px">状态</th>
					<th style="width:150px;">操作</th>
				</tr>
			</thead>
			<tbody>
				<?php  if(is_array($list)) { foreach($list as $row) { ?>
				<tr>
	
					<td><img src="<?php  echo tomedia($row['sp_img'])?>" alt="" style="width: 200px;height: auto;"></td>
					<td><?php  echo $row['sp_title'];?></td>
					<td><?php  echo $row['sp_numbers'];?></td>
					<td><?php  echo $row['sp_integrals'];?></td>
					<td><?php  if($row['status']==0) { ?>下架<?php  } else { ?>展示<?php  } ?></td>
					<td>
						<a class="btn btn-default" data-toggle="tooltip" data-placement="top" href="<?php  echo $this->createWebUrl('spupdata',array('id'=>$row['id']))?>" title="编辑"><i class="fa fa-edit"></i></a>
                        <?php  if($row['status']==0) { ?>
                        <a class="btn btn-default" title="展示" data-placement="top" href="#" onclick="drop_confirm('您确定要展示商品吗!', '<?php  echo $this->createWebUrl('setspshow',array('id'=>$row['id'],'status'=>1))?>');"><i class="fa fa-play"></i></a>
                        <?php  } else if($row['status']==1) { ?>
                        <a class="btn btn-default" title="下架" data-placement="top" href="#" onclick="drop_confirm('您确定要下架商品吗!', '<?php  echo $this->createWebUrl('setspshow',array('id'=>$row['id'],'status'=>0))?>');"><i class="fa fa-stop"></i></a>
                        <?php  } ?>
                        <a class="btn btn-default" data-toggle="tooltip" data-placement="top" href="#" onclick="drop_confirm('您确定要删除吗?', '<?php  echo $this->createWebUrl('deletesp',array('id'=>$row['id']))?>');" title="删除"><i class="fa fa-times"></i></a>
                  	</td>
				</tr>
				<?php  } } ?>

			</tbody>
		</table>
	</div>
	</div>
	<?php  echo $pager;?>
</div>




<div class="modal fade" id="wzmodal" tabindex="-1" style="z-index:1021;" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title" id="myModalLabel" style="text-align: center;">添加商品</h4>
			</div>
			<div class="modal-body" style="height: 550px;">


						<div class="col-xs-12 col-sm-12" style="margin-top: 30px;margin-bottom: 15px;">
							<span style='color:red'>*</span> 商品名称
						</div>
						<div class="col-sm-12 col-xs-12" style="margin-bottom: 15px;">
							<input type="text" id="sp_title" class="form-control" placeholder="" name="sp_title" value="">
						</div>

						<div class="col-xs-12 col-sm-12" style="margin-bottom: 15px;">
							<span style='color:red'>*</span> 商品图片
						</div>
						<div class="col-sm-12 col-xs-12" style="margin-bottom: 15px;">
							<?php  echo tpl_form_field_image('sp_img','');?>
						</div>
						<div class="col-sm-12 col-xs-12" style="margin-bottom: 15px;">
						商品图片大小为640*710以内。
						</div>
						<div class="col-xs-12 col-sm-12" style="margin-bottom: 15px;">
							<span style='color:red'>*</span> 商品链接(可不填)
						</div>
						<div class="col-sm-12 col-xs-12" style="margin-bottom: 15px;">
							<input type="text" id="sp_url" class="form-control" placeholder="" name="sp_url" value="">
						</div>

						

				<div class="col-xs-12 col-sm-12" style="margin-bottom: 15px;">
					<span style='color:red'>*</span> 商品数量
				</div>
				<div class="col-sm-12 col-xs-12" style="margin-bottom: 15px;">
					<input type="text" id="sp_numbers" class="form-control" placeholder="" name="sp_numbers" value="">
				</div>

				<div class="col-xs-12 col-sm-12" style="margin-bottom: 15px;">
					<span style='color:red'>*</span> 商品兑换积分数
				</div>
				<div class="col-sm-12 col-xs-12" style="margin-bottom: 15px;">
					<input type="text" id="sp_integrals" class="form-control" placeholder="" name="sp_integrals" value="">
				</div>


			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-primary" id="submit">确定</button>
				<button type="button" class="btn btn-primary" data-dismiss="modal">关闭</button>
			</div>

		</div>
	</div>
</div>




<script>
	require(['bootstrap'],function($){
		$('.btn').tooltip();
	});
$(function(){
   
    $(".check_all").click(function(){
       var checked = $(this).get(0).checked;
		$(':checkbox').each(function(){this.checked = checked});
    });
	$("input[name=deleteall]").click(function(){
 
		var check = $("input:checked");
		if(check.length<1){
			err('请选择要删除的记录!');
			return false;
		}
        if( confirm("确认要删除选择的记录?")){
		var id = new Array();
		check.each(function(i){
			id[i] = $(this).val();
		});
		$.post('<?php  echo $this->createWebUrl('deleteAll')?>', {idArr:id},function(data){
			if (data.errno ==0)
			{
				location.reload();
			} else {
				alert(data.error);
			}


		},'json');
		}

	});
});
</script>
<script>

	$(".wzxx").bind("click", function() {
		$('#wzmodal').modal('show');
	});


	$("#submit").bind("click", function() {
		var sp_title = $('#sp_title').val();
		var sp_img = $("input[name='sp_img']").attr('url');
		var sp_url = $('#sp_url').val();
		var sp_numbers = $('#sp_numbers').val();
		var sp_integrals = $('#sp_integrals').val();


		if (sp_title == '' || sp_title == undefined) {
			alert("商品名称不能为空");
			return
		}

		if (sp_img == '' || sp_img == undefined) {
			alert("商品图片不能为空");
			return
		}

		if (sp_numbers == '' || sp_numbers == undefined) {
			alert("商品数量不能为空");
			return
		}

		if (sp_integrals == '' || sp_integrals == undefined) {
			alert("商品兑换积分数不能为空");
			return
		}
		var submitData = {
			sp_title: sp_title,
			sp_img: sp_img,
			sp_url: sp_url,
			sp_numbers: sp_numbers,
			sp_integrals: sp_integrals,
		};

		$.post('<?php  echo $this->createWebUrl('spnew')?>', submitData, function(data) {
			if (data.success == 1) {
				window.location = "<?php  echo $this->createWebUrl('spmanage')?>";
			} else {
				 alert(data.msg);
			}
		},"json")
	});




function drop_confirm(msg, url){
    if(confirm(msg)){
        window.location = url;
    }
}
</script>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/footer', TEMPLATE_INCLUDEPATH)) : (include template('common/footer', TEMPLATE_INCLUDEPATH));?>