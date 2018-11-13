<?php defined('IN_IA') or exit('Access Denied');?><div class="panel we7-panel">
	<div class="panel-heading">
		<?php  if($_GPC['a'] == 'qr') { ?>二维码触发的关键字
		<?php  } else if($_GPC['a'] == 'mass') { ?>群发内容
		<?php  } else { ?>
			<?php  if($_GPC['c'] == 'mc' && $_GPC['a'] == 'chats') { ?>发送聊天内容<?php  } else { ?>触发后回复内容<?php  } ?>
			<?php  if($_GPC['a'] == 'reply' && $_GPC['m'] == 'keyword') { ?><span class="pull-right color-gray">添加多条回复内容时, 随机回复其中一条</span><?php  } ?>
		<?php  } ?>
	</div>
	<div class="panel-body we7-padding">
	<input type="hidden" name="reply[reply_basic]" value="">
	<input type="hidden" name="reply[reply_news]" value="">
	<input type="hidden" name="reply[reply_image]" value="">
	<input type="hidden" name="reply[reply_music]" value="">
	<input type="hidden" name="reply[reply_voice]" value="">
	<input type="hidden" name="reply[reply_video]" value="">
	<input type="hidden" name="reply[reply_wxcard]" value="">
	<input type="hidden" name="reply[reply_keyword]" value="">
	<input type="hidden" name="reply[reply_module]" value="">
		<ul class="keywords-list">
		</ul>
		<div class="we7-select-msg">
			<ul class="tab-navs">
				<li class="tab-nav tab-appmsg active <?php  if($options['news']) { ?>hidden<?php  } ?>">
					<a href="javascript:void(0);"<?php  if($_GPC['a'] == 'mass') { ?> onclick="select_mediaid('news', 'wx')"<?php  } else { ?> onclick="select_mediaid('news')"<?php  } ?>>&nbsp;<i class="wi wi-appmsg"></i><span class="msg-tab-title">图文</span></a>
				</li>
				<li class="tab-nav tab-text <?php  if($options['basic']) { ?>hidden<?php  } ?>">
					<a href="javascript:void(0);" onclick="select_mediaid('basic');">&nbsp;<i class="wi wi-text"></i><span class="msg-tab-title">文字</span></a>
				</li>
				<li class="tab-nav tab-img <?php  if($options['image']) { ?>hidden<?php  } ?>">
					<a href="javascript:void(0);" onclick="select_mediaid('image');">&nbsp;<i class="wi wi-img"></i><span class="msg-tab-title"><?php  if(in_array($_W['account']['type'], array(ACCOUNT_TYPE_XZAPP_NORMAL, ACCOUNT_TYPE_XZAPP_AUTH))) { ?>熊掌号<?php  } else { ?>微信<?php  } ?>图片</span></a>
				</li>
				<li class="tab-nav tab-audio <?php  if($options['music']) { ?>hidden<?php  } ?>">
					<a href="javascript:void(0);" onclick="select_mediaid('music');">&nbsp;<i class="wi wi-notice"></i><span class="msg-tab-title">音乐</span></a>
				</li>
				<li class="tab-nav tab-audio <?php  if($options['voice']) { ?>hidden<?php  } ?>">
					<a href="javascript:void(0);" onclick="select_mediaid('voice');">&nbsp;<i class="wi wi-radio"></i><span class="msg-tab-title">语音</span></a>
				</li>
				<li class="tab-nav tab-video <?php  if($options['video']) { ?>hidden<?php  } ?>">
					<a href="javascript:void(0);" onclick="select_mediaid('video');">&nbsp;<i class="wi wi-video "></i><span class="msg-tab-title">视频</span></a>
				</li>
				<li class="tab-nav tab-cardmsg <?php  if($options['wxcard']) { ?>hidden<?php  } ?>">
					<a href="javascript:void(0);" onclick="select_mediaid('wxcard');">&nbsp;<i class="wi wi-card"></i><span class="msg-tab-title">卡劵</span></a>
				</li>
				<li class="tab-nav tab-cardmsg <?php  if($options['keyword']) { ?>hidden<?php  } ?>">
					<a href="javascript:void(0);" onclick="select_mediaid('keyword');">&nbsp;<i class="wi wi-keyword"></i><span class="msg-tab-title"><?php  if($_GPC['m'] == 'welcome') { ?>匹配<?php  } else { ?>触发<?php  } ?>关键字</span></a>
				</li>
				<li class="tab-nav tab-cardmsg <?php  if($options['module']) { ?>hidden<?php  } ?>">
					<a href="javascript:void(0);" onclick="select_mediaid('module');">&nbsp;<i class="wi wi-keyword"></i><span class="msg-tab-title">模块</span></a>
				</li>
			</ul>
		</div>
	</div>
</div>
<script>
	var action = "<?php  echo $_GPC['a']?>";
	var m = "<?php  echo $_GPC['m']?>";

	//删除已选素材
	var delmedia = function(type, ele) {
		var oldVal = $(':hidden[name="reply[reply_'+type+']"]').val();
		var newVal;
		var media = $(ele).attr('data-media');
		switch(type) {
			case 'basic':
				var middleVal = oldVal.split(',');
				newVal = angular.copy(middleVal);
				angular.forEach(middleVal, function(val, key) {
					middleVal[key] = htmlEncode(angular.toJson(val));
				});
				var index = _.indexOf(middleVal, htmlEncode(angular.toJson(media)));
				newVal = _.without(newVal, newVal[index]);
				$(':hidden[name="reply[reply_'+type+']"]').val(newVal);
				break;
			case 'image':
				var middleVal = oldVal.split(',');
				newVal = angular.copy(middleVal);
				angular.forEach(middleVal, function(val, key) {
					if(val.match(media)) {
						newVal = _.without(newVal, middleVal[key]);
					}
				});
				$(':hidden[name="reply[reply_'+type+']"]').val(newVal);
				break;
			case 'news':
				var middleVal = oldVal.slice(1, -1).split('},{');
				newVal = angular.copy(middleVal);
				angular.forEach(middleVal, function(val, key){
					if(val.match('"mediaid":"'+media)) {
						newVal = _.without(newVal, middleVal[key]);
					}
				});
				angular.forEach(newVal, function(val, key) {
					newVal[key] = '{'+val+'}';
				});
				$(':hidden[name="reply[reply_'+type+']"]').val(newVal);
				break;
			case 'music':
				var middleVal = oldVal.slice(1, -1).split('},{');
				newVal = angular.copy(middleVal);
				angular.forEach(middleVal, function(val, key){
					if(val.match(media)) {
						newVal = _.without(newVal, middleVal[key]);
					}
				});
				angular.forEach(newVal, function(val, key) {
					newVal[key] = '{'+val+'}';
				});
				$(':hidden[name="reply[reply_'+type+']"]').val(newVal);
				break;
			case 'voice':
				var middleVal = oldVal.split(',');
				newVal = angular.copy(middleVal);
				angular.forEach(middleVal, function(val, key) {
					if(val.match(media)) {
						newVal = _.without(newVal, middleVal[key]);
					}
				});
				$(':hidden[name="reply[reply_'+type+']"]').val(newVal);
				break;
			case 'video':
				var middleVal = oldVal.slice(1, -1).split('},{');
				newVal = angular.copy(middleVal);
				angular.forEach(middleVal, function(val, key){
					if(val.match(media)) {
						newVal = _.without(newVal, middleVal[key]);
					}
				});
				angular.forEach(newVal, function(val, key) {
					newVal[key] = '{'+val+'}';
				});
				$(':hidden[name="reply[reply_'+type+']"]').val(newVal);
				break;
			case 'wxcard':
				var middleVal = oldVal.slice(1, -1).split('},{');
				newVal = angular.copy(middleVal);
				angular.forEach(middleVal, function(val, key){
					if(val.match(media)) {
						newVal = _.without(newVal, middleVal[key]);
					}
				});
				angular.forEach(newVal, function(val, key) {
					newVal[key] = '{'+val+'}';
				});
				$(':hidden[name="reply[reply_'+type+']"]').val(newVal);
				break;
			case 'keyword':
				oldVal = oldVal.split(',');
				index = _.indexOf(oldVal, media);
				oldVal.splice(index, 1);
				$(':hidden[name="reply[reply_'+type+']"]').val(oldVal);
				break;
			case 'module':
				oldVal = oldVal.split(',');
				index = _.indexOf(oldVal, media);
				oldVal.splice(index, 1);
				$(':hidden[name="reply[reply_'+type+']"]').val(oldVal);
				break;
		}
		//显示隐藏-start
		if((action == 'qr' || action == 'mass' || m == 'special' || m == 'welcome' || m == 'default') && $(':hidden[name="reply[reply_'+type+']"]').val().length == 0) {
			$('.we7-select-msg').removeClass('hide');
		}
		//显示隐藏-end
		$(ele).parent().parent('.del-'+type+'-media').parent('li').remove();
	};

	window.select_mediaid = function(type, otherVal){
		var option = {
			type: type,
			isWechat : true, // 默认显示微信
			needType : 3, //  除了图文 其他只能微信
			otherVal : otherVal,//
			others: {
				image: {
					needType : 1
				},
				video : {
					needType : 1
				},
				voice : {
					needType : 3
				}
			}
		};
		if (type == 'module'){
			document.cookie = "special_reply_type=<?php  echo $_GPC['type'];?>";
		}
		util.material(function(material){
			var replyVal = [];
			$(':hidden[name="reply[reply_'+type+']"]').val() == '' ? '' : replyVal.push($(':hidden[name="reply[reply_'+type+']"]').val());
			if (type == 'basic') {
				if (angular.isDefined(otherVal)) {
					var editmedia = $(".del-basic-media");
					for (var i = 0; i < editmedia.length; i++) {
						if (htmlEncode($(editmedia.get(i)).find('.edit-gray').data('media')) == htmlEncode(angular.toJson(otherVal))) {
							var inputVal = $(':hidden[name="reply[reply_'+type+']"]').val();
							var inputValArr = inputVal.split(',');
							var middleVal = angular.copy(inputValArr);
							angular.forEach(inputValArr, function(val, key) {
								inputValArr[key] = htmlEncode(val);
							});
							var index = _.indexOf(inputValArr, htmlEncode(angular.toJson(otherVal)));
							material.content = material.content.replace(/,/g, '，');
							middleVal[index] = angular.toJson(material.content);
							replyVal = middleVal.join(',');
							$(':hidden[name="reply[reply_'+type+']"]').val(replyVal);
							$(editmedia.get(i)).html(
								'	<div class="desc">'+
								'		<div class="media-content">'+
								'			<span data-toggle="tooltip" data-placement="bottom" title="'+htmlEncode(material.content)+'">'+htmlEncode(cutStr(material.content,60))+
								'			</span>'+
								'		</div>'+
								'	</div>'+
								'	<div class="opr">'+
								'		<a href="javascript:;" data-media="'+htmlEncode(angular.toJson(material.content))+'" class="edit-gray" onclick="select_mediaid(\'basic\', '+htmlEncode(angular.toJson(material.content))+')">编辑</a>'+
								'		<a href="javascript:;" data-media="'+htmlEncode(angular.toJson(material.content))+'" class="del-gray" onclick="delmedia(\''+type+'\', this)">删除</a>'+
								'	</div>'
							);
							break;
						}
					}
				} else {
					if($.trim(material.content).length == 0) {
						return false;
					}
					material.content = material.content.replace(/,/g, '，');
					replyVal.push(angular.toJson(material.content));
					$(':hidden[name="reply[reply_'+type+']"]').val(replyVal);
					$('.keywords-list').append(
						'<li>'+
						'<div class="del-'+type+'-media">'+
						'	<div class="desc">'+
						'		<div class="media-content">'+
						'			<span data-toggle="tooltip" data-placement="bottom" title="'+htmlEncode(material.content)+'">'+htmlEncode(cutStr(material.content,60))+'</span>'+
						'		</div>'+
						'	</div>'+
						'	<div class="opr">'+
						'		<a href="javascript:;" data-media="'+htmlEncode(angular.toJson(material.content))+'" class="edit-gray" onclick="select_mediaid(\'basic\', '+htmlEncode(angular.toJson(material.content))+')">编辑</a>'+
						'		<a href="javascript:;" data-media="'+htmlEncode(angular.toJson(material.content))+'" class="del-gray" onclick="delmedia(\''+type+'\', this)">删除</a>'+
						'	</div>'+
						'</div>'+
						'</li>'
					);
				}
			} else if(type == 'keyword') {
				if($.trim(material.id).length == 0) {
					return false;
				}
				replyVal.push(angular.toJson(material.id));
				$(':hidden[name="reply[reply_'+type+']"]').val(replyVal);
				var keywords = [];
				for(var i = 0; i < material.length; i++) {
					keywords += '&nbsp;&nbsp;' + material.content;
				}
				$('.keywords-list').append(
					'<li>'+
					'<div class="del-'+type+'-media">'+
					'	<div class="desc">'+
					'		<div class="media-content">'+
					'				<a class="title-wrp" href="javascript:;">'+
					'					<span class="title">[关键字]'+material.content+'</span>'+
					'				</a>'+
					'				<p class="desc"><a href="javascript:;" class="appmsg-desc">'+keywords+'</a></p>'+
					'		</div>'+
					'	</div>'+
					'	<div class="opr">'+
					'<a href="./index.php?c=platform&a=reply&do=post&m=keyword&rid=' + material.rid + '" target="_blank" class="del-gray">编辑</a> '  +
					'		<a href="javascript:;" data-media="'+material.content+'" class="del-gray" onclick="delmedia(\''+type+'\', this)">删除</a>'+
					'	</div>'+
					'</div>'+
					'</li>'
				);

			} else if(type == 'module') {
				if($.trim(material.name).length == 0) {
					return false;
				}
				replyVal.push(angular.toJson(material.name));
				$(':hidden[name="reply[reply_'+type+']"]').val(replyVal);
				$('.keywords-list').append(
						'<li>'+
						'<div class="del-'+type+'-media">'+
						'	<div class="desc">'+
						'		<div class="media-content">'+
						'			<div class="appmsgSendedItem">'+
						'				<a class="title-wrp" href="javascript:;">'+
						'					 <span class="icon cover" style="background-image:url('+material.icon+');"></span>'+
						'					<span class="title">[模块]'+material.title+'</span>'+
						'				</a>'+
						'			</div>'+
						'		</div>'+
						'	</div>'+
						'	<div class="opr">'+
						'		<a href="javascript:;" data-media="'+material.name+'" class="del-gray" onclick="delmedia(\''+type+'\', this)">删除</a>'+
						'	</div>'+
						'</div>'+
						'</li>'
				);
			} else {
				if(type != 'music' && $.trim(material.media_id).length == 0 && !(type == 'news' && material.model == 'local')) {
					return false;
				};
				switch(type) {
					case 'image':
						replyVal.push(angular.toJson(material.media_id));

						$('.keywords-list').append(
							'<li>'+
							'<div class="del-'+type+'-media">'+
							'	<div class="desc">'+
							'		<div class="media-content">'+
							'			<div class="appmsgSendedItem">'+
							'				<a class="title-wrp" href="javascript:;">'+
							'					 <span class="icon cover" style="background-image:url('+material.url+');"></span>'+
							'					<span class="title">[图片]</span>'+
							'				</a>'+
							'			</div>'+
							'		</div>'+
							'	</div>'+
							'	<div class="opr">'+
							'		<a href="javascript:;" data-media="'+material.media_id+'" class="del-gray" onclick="delmedia(\''+type+'\', this)">删除</a>'+
							'	</div>'+
							'</div>'+
							'</li>'
						);
						break;
					case 'news':
						angular.forEach(material.items, function(newsV, newsK){
							replyVal.push(angular.toJson({
								title: newsV.title,
								author: newsV.author,
								description: newsV.digest,
								thumb: newsV.thumb_url,
								url: newsV.content_source_url ? newsV.content_source_url : newsV.url,
								createtime: material.createtime,
								displayorder: newsV.displayorder ? newsV.displayorder : 0,
								mediaid: material.media_id,
								model: material.model,
								attach_id: newsV.attach_id
							}));
						});
						$('.keywords-list').append(
							'<li>'+
							'<div class="del-'+type+'-media">'+
							'	<div class="desc">'+
							'		<div class="media-content">'+
							'			<div class="appmsgSendedItem">'+
							'				<a class="title-wrp" href="javascript:;">'+
							'					<span class="icon cover" style="background-image:url('+material.items[0].thumb_url+');"></span>'+
							'					<span class="title">[图文消息]'+material.items[0].title+'<span class="color-red">（多条图文只显示一条,不影响实际回复效果）</span></span>'+
							'				</a>'+
							'				<p class="desc"><a href="javascript:;" class="appmsg-desc">'+material.items[0].digest+'</a></p>'+
							'			</div>'+
							'		</div>'+
							'	</div>'+
							'	<div class="opr">'+
							'		<a href="./index.php?c=platform&a=material-post&type=reply&newsid='+material.id+'" target="_blank" class="del-gray">编辑</a>'+
							'		<a href="javascript:;" data-media="'+material.media_id+'" class="del-gray" onclick="delmedia(\''+type+'\', this)">删除</a>'+
							'	</div>'+
							'</div>'+
							'</li>'
						);
						break;
					case 'voice':
						replyVal.push(angular.toJson(material.media_id));
						$('.keywords-list').append(
							'<li>'+
							'<div class="del-'+type+'-media">'+
							'	<div class="desc">'+
							'		<div class="media-content">'+
							'			<div class="audio-msg">'+
							'				<div class="icon-audio-wrp">'+
							'					<span class="icon-audio-msg"></span>'+
							'				</div>'+
							'				<div class="audio-content">'+
							'					<div class="audio-title">[语音]'+material.filename+'</div>'+
							'				</div>'+
							'			</div>'+
							'		</div>'+
							'	</div>'+
							'	<div class="opr">'+
							'		<a href="javascript:;" data-media="'+material.media_id+'" class="del-gray" onclick="delmedia(\''+type+'\', this)">删除</a>'+
							'	</div>'+
							'</div>'+
							'</li>'
						);
						break;
					case 'video':
						replyVal.push(angular.toJson({
							mediaid: material.media_id,
							title: material.tag.title,
							description: material.tag.description
						}));

						$('.keywords-list').append(
							'<li>'+
							'<div class="del-'+type+'-media">'+
							'	<div class="desc">'+
							'		<div class="media-content">'+
							'			<div class="appmsgSendedItem">'+
							'				<a class="title-wrp" href="javascript:;">'+
							'					 <span class="icon cover" data-contenturl="'+material.tag.down_url+'"></span>'+
							'					<span class="title">[视频]'+material.filename+'</span>'+
							'				<p class="desc"><a href="javascript:;" class="appmsg-desc">'+(material.tag.description ? material.tag.description : '--')+'</a></p>'+
							'				</a>'+
							'			</div>'+
							'		</div>'+
							'	</div>'+
							'	<div class="opr">'+
							'		<a href="javascript:;" data-media="'+material.media_id+'" class="del-gray" onclick="delmedia(\''+type+'\', this)">删除</a>'+
							'	</div>'+
							'</div>'+
							'</li>'
						);
						break;
					case 'music':
						replyVal.push(angular.toJson({
							title: material.title,
							url: material.url,
							hqurl: material.HQUrl,
							description: material.description,
						}));
						$('.keywords-list').append(
							'<li>'+
							'<div class="del-'+type+'-media">'+
							'	<div class="desc">'+
							'		<div class="media-content">'+
							'			<div class="appmsgSendedItem">'+
							'				<a class="title-wrp" href="javascript:;">'+
							'					 <span class="icon cover" style="background-image:'+material.url+';"></span>'+
							'					<span class="title">[音乐]'+material.title+'</span>'+
							'				</a>'+
							'				<p class="desc"><a href="javascript:;" class="appmsg-desc">'+material.description+'</a></p>'+
							'			</div>'+
							'		</div>'+
							'	</div>'+
							'	<div class="opr">'+
							'		<a href="javascript:;" data-media="'+material.url+'" class="del-gray" onclick="delmedia(\''+type+'\', this)">删除</a>'+
							'	</div>'+
							'</div>'+
							'</li>'
						);
						break;
					case 'wxcard':
						replyVal.push(angular.toJson({
							mediaid: material.card_id,
							title: material.title,
							cid: material.id,
							brandname: material.brand_name,
							logo_url: material.logo_url,
							success: '成功',
							error: '失败'
						}));
						$('.keywords-list').append(
							'<li>'+
							'<div class="del-'+type+'-media">'+
							'	<div class="desc">'+
							'		<div class="media-content">'+
							'			<div class="appmsgSendedItem">'+
							'				<a class="title-wrp" href="javascript:;">'+
							'					 <span class="icon cover" style="background-image:url('+material.logo_url+');"></span>'+
							'					<span class="title">[卡券]'+material.title+'</span>'+
							'				<p class="desc"><a href="javascript:;" class="appmsg-desc">'+(material.brand_name ? material.brand_name : '--')+'</a></p>'+
							'				</a>'+
							'			</div>'+
							'		</div>'+
							'	</div>'+
							'	<div class="opr">'+
							'		<a href="javascript:;" data-media="'+material.card_id+'" class="del-gray" onclick="delmedia(\''+type+'\', this)">删除</a>'+
							'	</div>'+
							'</div>'+
							'</li>'
						);
						break;
				}
				$(':hidden[name="reply[reply_'+type+']"]').val(replyVal);
			}
			//显示隐藏-start
			if((action == 'qr' || action == 'mass' || m == 'special' || m == 'welcome' || m == 'default') && replyVal.length > 0) {
				$('.we7-select-msg').addClass('hide');
			}
			//显示隐藏-end
		}, option);
	};

	window.initReplyController = function($scope) {
		$scope.context = {};
		$scope.context.items = <?php  echo json_encode($replies)?>;
		var newsMediaIds = [];
		angular.forEach($scope.context.items, function(val, key){
			var replyVal = [];
			var type = key;
			switch(type) {
				case 'basic':
					angular.forEach(val, function(basicVal, basicKey) {
						replyVal.push(angular.toJson(basicVal.content));
						$('.keywords-list').append(
							'<li>'+
							'<div class="del-'+type+'-media">'+
							'	<div class="desc">'+
							'		<div class="media-content">'+
							'			<span data-toggle="tooltip" data-placement="bottom"  title="'+htmlEncode(basicVal.content)+'">'+htmlEncode(cutStr(basicVal.content,60))+'</span>'+
							'		</div>'+
							'	</div>'+
							'	<div class="opr">'+
							'		<a href="javascript:;" data-media="'+htmlEncode(angular.toJson(basicVal.content))+'" class="edit-gray" onclick="select_mediaid(\'basic\', '+htmlEncode(angular.toJson(basicVal.content))+')">编辑</a>'+
							'		<a href="javascript:;" data-media="'+htmlEncode(angular.toJson(basicVal.content))+'" class="del-gray" onclick="delmedia(\''+type+'\', this)">删除</a>'+
							'	</div>'+
							'</div>'+
							'</li>'
						);
					});
					$(':hidden[name="reply[reply_'+type+']"]').val(replyVal);
					break;
				case 'news':
					angular.forEach(val, function(newsVal, newsKey) {
						var index = _.indexOf(newsMediaIds, newsVal.media_id);
						replyVal.push(angular.toJson({
							title: newsVal.title,
							author: newsVal.author,
							description: newsVal.description ? newsVal.description : newsVal.digest,
							thumb: newsVal.thumb ? newsVal.thumb : newsVal.thumb_url,
							url: newsVal.url,
							createtime: newsVal.createtime,
							displayorder: newsVal.displayorder ? newsVal.displayorder : 0,
							incontent: newsVal.incontent ? newsVal.incontent : 0,
							parent_id: newsVal.parent_id ? newsVal.parent_id : 0,
							mediaid: newsVal.media_id,
							attach_id: newsVal.attach_id,
							model: newsVal.model
						}));
						if (index == -1) {
							$('.keywords-list').append(
								'<li>'+
								'<div class="del-'+type+'-media">'+
								'	<div class="desc">'+
								'		<div class="media-content">'+
								'			<div class="appmsgSendedItem">'+
								'				<a class="title-wrp" href="javascript:;">'+
								'					<span class="icon cover" style="background-image:url('+(newsVal.thumb ? newsVal.thumb : newsVal.thumb_url)+');"></span>'+
								'					<span class="title">[图文消息]'+newsVal.title+(!newsVal.attach_id ? '<span class="color-red">（素材不存在或已被删除）</span>' : '')+
								'					</span>'+
								'				</a>'+
								'				<p class="desc"><a href="javascript:;" class="appmsg-desc">'+(newsVal.description ? newsVal.description : '')+'</a></p>'+
								'			</div>'+
								'		</div>'+
								'	</div>'+
								'	<div class="opr">'+
										'<a href="./index.php?c=platform&a=material-post&type=reply&newsid='+(newsVal.attach_id ? newsVal.attach_id : '')+'&reply_news_id='+newsVal.id+'" target="_blank" class="del-gray">编辑</a>'  +
								'		<a href="javascript:;" data-media="'+newsVal.media_id+'" class="del-gray" onclick="delmedia(\''+type+'\', this)">删除</a>'+
								'	</div>'+
								'</div>'+
								'</li>'
							);
							newsMediaIds.push(newsVal.media_id);
						}
					});
					$(':hidden[name="reply[reply_'+type+']"]').val(replyVal);
					break;
				case 'image':
					angular.forEach(val, function(imageVal, imageKey) {
						replyVal.push(angular.toJson(imageVal.mediaid));
						$('.keywords-list').append(
							'<li>'+
							'<div class="del-'+type+'-media">'+
							'	<div class="desc">'+
							'		<div class="media-content">'+
							'			<div class="appmsgSendedItem">'+
							'				<a class="title-wrp" href="javascript:;">'+
							'					 <span class="icon cover" style="background-image:url('+imageVal.img_url+');"></span>'+
							'					<span class="title">[图片]</span>'+
							'				</a>'+
							'			</div>'+
							'		</div>'+
							'	</div>'+
							'	<div class="opr">'+
							'		<a href="javascript:;" data-media="'+imageVal.mediaid+'" class="del-gray" onclick="delmedia(\''+type+'\', this)">删除</a>'+
							'	</div>'+
							'</div>'+
							'</li>'
						);
					});
					$(':hidden[name="reply[reply_'+type+']"]').val(replyVal);
					break;
				case 'voice':
					angular.forEach(val, function(voiceVal, voiceKey) {
						replyVal.push(angular.toJson(voiceVal.mediaid));
						$('.keywords-list').append(
							'<li>'+
							'<div class="del-'+type+'-media">'+
							'	<div class="desc">'+
							'		<div class="media-content">'+
							'			<div class="audio-msg">'+
							'				<div class="icon-audio-wrp">'+
							'					<span class="icon-audio-msg"></span>'+
							'				</div>'+
							'				<div class="audio-content">'+
							'					<div class="audio-title">[语音]'+voiceVal.title+'</div>'+
							'				</div>'+
							'			</div>'+
							'		</div>'+
							'	</div>'+
							'	<div class="opr">'+
							'		<a href="javascript:;" data-media="'+voiceVal.mediaid+'" class="del-gray" onclick="delmedia(\''+type+'\', this)">删除</a>'+
							'	</div>'+
							'</div>'+
							'</li>'
						);
					});
					$(':hidden[name="reply[reply_'+type+']"]').val(replyVal);
					break;	
				case 'video':
					angular.forEach(val, function(videoVal, videoKey) {
						replyVal.push(angular.toJson({
							mediaid: videoVal.mediaid,
							title: videoVal.title,
							description: videoVal.description
						}));
						$('.keywords-list').append(
							'<li>'+
							'<div class="del-'+type+'-media">'+
							'	<div class="desc">'+
							'		<div class="media-content">'+
							'			<div class="appmsgSendedItem">'+
							'				<a class="title-wrp" href="javascript:;">'+
							'					 <span class="icon cover" data-contenturl="'+videoVal.down_url+'"></span>'+
							'					<span class="title">[视频]'+(videoVal.filename ? videoVal.filename : '--')+'</span>'+
							'				<p class="desc"><a href="javascript:;" class="appmsg-desc">'+(videoVal.description ? videoVal.description : '--')+'</a></p>'+
							'				</a>'+
							'			</div>'+
							'		</div>'+
							'	</div>'+
							'	<div class="opr">'+
							'		<a href="javascript:;" data-media="'+videoVal.mediaid+'" class="del-gray" onclick="delmedia(\''+type+'\', this)">删除</a>'+
							'	</div>'+
							'</div>'+
							'</li>'
						);
					});
					$(':hidden[name="reply[reply_'+type+']"]').val(replyVal);
					break;
				case 'wxcard':
					angular.forEach(val, function(wxcardVal, wxcardKey) {
						replyVal.push(angular.toJson({
							mediaid: wxcardVal.card_id,
							title: wxcardVal.title,
							cid: wxcardVal.cid,
							brandname: wxcardVal.brand_name,
							logo_url: wxcardVal.logo_url,
							success: wxcardVal.success,
							error: wxcardVal.error
						}));
						$('.keywords-list').append(
							'<li>'+
							'<div class="del-'+type+'-media">'+
							'	<div class="desc">'+
							'		<div class="media-content">'+
							'			<div class="appmsgSendedItem">'+
							'				<a class="title-wrp" href="javascript:;">'+
							'					 <span class="icon cover" style="background-image:url('+wxcardVal.logo_url+');"></span>'+
							'					<span class="title">[卡券]'+(wxcardVal.title ? wxcardVal.title : '--')+'</span>'+
							'				<p class="desc"><a href="javascript:;" class="appmsg-desc">'+(wxcardVal.brand_name ? wxcardVal.brand_name : '--')+'</a></p>'+
							'				</a>'+
							'			</div>'+
							'		</div>'+
							'	</div>'+
							'	<div class="opr">'+
							'		<a href="javascript:;" data-media="'+wxcardVal.card_id+'" class="del-gray" onclick="delmedia(\''+type+'\', this)">删除</a>'+
							'	</div>'+
							'</div>'+
							'</li>'
						);
					});
					$(':hidden[name="reply[reply_'+type+']"]').val(replyVal);
					break;
				case 'keyword':
					angular.forEach(val, function(keywordVal, keywordKey) {
						replyVal.push(angular.toJson(keywordVal.id));
						var keywords = '&nbsp;&nbsp;' + keywordVal.content;
						$('.keywords-list').append(
								'<li>'+
								'<div class="del-'+type+'-media">'+
								'	<div class="desc">'+
								'		<div class="media-content">'+
								'				<a class="title-wrp" href="javascript:;">'+
								'					<span class="title">[关键字]'+keywordVal.name+'</span>'+
								'				</a>'+
								'				<p class="desc"><a href="javascript:;" class="appmsg-desc">'+keywords+'</a></p>'+
								'		</div>'+
								'	</div>'+
								'	<div class="opr">'+
								'<a href="./index.php?c=platform&a=reply&do=post&m=keyword&rid=' + keywordVal.rid + '" target="_blank" class="del-gray">编辑</a> '  +
								'<a href="javascript:;" data-media="'+keywordVal.name+'" class="del-gray" onclick="delmedia(\''+type+'\', this)">删除</a>'+
								'	</div>'+
								'</div>'+
								'</li>'
						);
					});
					$(':hidden[name="reply[reply_'+type+']"]').val(replyVal[0]);
					break;
				case 'module':
					angular.forEach(val, function(keywordVal, keywordKey) {
						replyVal.push(angular.toJson(keywordVal.rid));
						var keywords = '&nbsp;&nbsp;' + keywordVal.content;
						$('.keywords-list').append(
								'<li>'+
								'<div class="del-'+type+'-media">'+
								'	<div class="desc">'+
								'		<div class="media-content">'+
								'			<div class="appmsgSendedItem">'+
								'				<a class="title-wrp" href="javascript:;">'+
								'					 <span class="icon cover" style="background-image:url('+keywordVal.icon+');"></span>'+
								'					<span class="title">[模块]'+keywordVal.title+'</span>'+
								'				</a>'+
								'			</div>'+
								'		</div>'+
								'	</div>'+
								'	<div class="opr">'+
								'		<a href="javascript:;" data-media="'+keywordVal.name+'" class="del-gray" onclick="delmedia(\''+type+'\', this)">删除</a>'+
								'	</div>'+
								'</div>'+
								'</li>'
						);
					});
					$(':hidden[name="reply[reply_'+type+']"]').val(val[0]['name']);
					break;
				case 'music':
					angular.forEach(val, function(musicVal, musicKey) {
						replyVal.push(angular.toJson({
							title: musicVal.title,
							url: musicVal.url,
							hqurl: musicVal.hqurl,
							description: musicVal.description,
						}));
						$('.keywords-list').append(
							'<li>'+
							'<div class="del-'+type+'-media">'+
							'	<div class="desc">'+
							'		<div class="media-content">'+
							'			<div class="appmsgSendedItem">'+
							'				<a class="title-wrp" href="javascript:;">'+
							'					 <span class="icon cover" style="background-image:'+musicVal.url+';"></span>'+
							'					<span class="title">[音乐]'+musicVal.title+'</span>'+
							'				</a>'+
							'				<p class="desc"><a href="javascript:;" class="appmsg-desc">'+musicVal.description+'</a></p>'+
							'			</div>'+
							'		</div>'+
							'	</div>'+
							'	<div class="opr">'+
							'		<a href="javascript:;" data-media="'+musicVal.url+'" class="del-gray" onclick="delmedia(\''+type+'\', this)">删除</a>'+
							'	</div>'+
							'</div>'+
							'</li>'
						);
					});
					$(':hidden[name="reply[reply_'+type+']"]').val(replyVal);
					break;
			}
			//显示隐藏-start
			if((action == 'qr' || action == 'mass' || m == 'special' || m == 'welcome' || m == 'default') && replyVal.length > 0) {
				$('.we7-select-msg').addClass('hide');
			}
			//显示隐藏-end
		});
	};

	window.validateReplyForm = function(form, $, _, util, $scope) {
		var allEmpty = true;
		var modules = ['basic', 'news', 'image', 'music', 'voice', 'video', 'wxcard', 'keyword', 'module'];
		if($scope.reply.entry.module == 'reply') {
			angular.forEach(modules, function(val, key){
				if($(':hidden[name="reply[reply_'+val+']"]').val() != '') {
					allEmpty = false;
				};
			});
		}else {
			if($(':hidden[name="reply[reply_'+$scope.reply.entry.module+']"]').val() != ''){
				allEmpty = false;
			};
		}
		if(allEmpty) {
			util.message('请添加有效的回复内容。');
			return false;
		}
		return true;
	};
	function htmlEncode(str) {
		var s = "";
		if(str.length == 0) return "";
		s = str.replace(/&/g,"&amp;");
		s = s.replace(/</g,"&lt;");
		s = s.replace(/>/g,"&gt;");
		s = s.replace(/\'/g,"&#039;");
		s = s.replace(/\"/g,"&quot;");
		s = s.replace(/\n/g, "\\n");
		return s;
	}
	function htmlDecode(str) {
		var s = "";
		if(str.length == 0) return "";
		s = str.replace(/&amp;/g,"&");
		s = s.replace(/&lt;/g,"<");
		s = s.replace(/&gt;/g,">");
		s = s.replace(/&#039;/g,"'");
		s = s.replace(/&quot;/g,'"');
		s = s.replace(/\\n/g,'\n');
		return s;
	}
    function cutStr(str, len) {
        var str_length = 0;
        var str_len = 0;
        str_cut = new String();
        str_len = str.length;
        for (var i = 0; i < str_len; i++) {
            a = str.charAt(i);
            str_length++;
            if (escape(a).length > 4) {
                //中文字符的长度经编码之后大于4  
                str_length++;
            }
            str_cut = str_cut.concat(a);
            if (str_length >= len) {
                str_cut = str_cut.concat("...");
                return str_cut;
            }
        }
        //如果给定字符串小于指定长度，则返回源字符串；  
        if (str_length < len) {
            return str;
        }
    }
	$(document).on("mouseover","body",function(){
	 	$("[data-toggle='tooltip']").tooltip();
	});
</script>