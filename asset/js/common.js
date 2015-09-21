
var ajaxSending=false;
$(function(){
	
	$('[data-toggle="tooltip"]').tooltip({container: 'body'});
	//注册
	$('#regfrom').unbind("submit").submit(function(){
		var username=$('#username').val();
		var email=$('#email').val();
		var pwd=$('#pwd').val();
		var pwd2=$('#pwd2').val();
		var autologin=$('#autologin').is(':checked');
		var regbtn=1;
		if(username=='' || email=='' || pwd=='' || pwd2==''){
			alert('请填写完整的资料');
			return false;
		}
		$(this).find('span').each(function() {
			if($(this).text()!=''){
				alert('请填写正确的资料');
				$(this).prev('input').focus();
				return false;
			}
		});
		var data={username:username,email:email,pwd:pwd,pwd2:pwd2,autologin:autologin,regbtn:regbtn};
		var url='index.php?m=user&do=reg';
		_ajax(url,data,function(res){
			callback_reg(res);
		});
		return false;
	})
	function callback_reg(res){
		ajaxSending=false;
		res=eval("("+res+")");
		if(res['status']==-1){
			alert('请求失败');
			return false;
		}
		if(res['status']==2){
			if(res['data']['id']!='error'){
				var id=res['data']['id'];
				errormessage(id,res['data']['msg']);
				$('#'+id).focus();
			}else{
				alert(res['data']['msg']);
			}
			return false;
		}
		if(res['status']==1){
			var url=$('#referer').val();
			window.location.href=url;
		}
	}
	$('#regfrom .form-control').unbind("blur").blur(function(){
		var id=$(this).attr('id');
		var value=$.trim($(this).val());
		//防止相同值重复提交
		var authval=$('#auth'+id).val();
		if(authval==value){
			return false;
		}
		switch(id){
			case "username":
				errormessage(id,'');
				if(value.match(/<|"/ig)) {
					errormessage(id, '用户名包含敏感字符');
					return false;
				}
				var unlen = value.replace(/[^\x00-\xff]/g, "**").length;
				if(unlen < 3 || unlen > 15) {
					errormessage(id, unlen < 3 ? '用户名不得小于 3 个字符' : '用户名不得超过 15 个字符');
					return false;
				}
				break;
			case "email":
				errormessage(id,'');
				if(value.match(/<|"/ig)) {
					errormessage(id, 'Email 包含敏感字符');
					return false;
				}
				if(!value.match(/^([a-z0-9\-_.+]+)@([a-z0-9\-]+[.][a-z0-9\-.]+)$/ig)) {
					errormessage(id, '不是有效的 Email');
					return false;
				}
				break;
			case "pwd":
				errormessage(id,'');
				if(value.length < 6) {
					errormessage(id, '密码太短，不得少于 6 个字符');
					return false;
				}
				break;
			case "pwd2":
				errormessage(id,'');
				var pwd=$.trim($('#pwd').val());
				if(value != pwd) {
					errormessage(id, '两次输入的密码不一致');
					return false;
				}
				break;
		}
		var checkarr=['username','email'];
		if(in_array(id,checkarr) && value!=''){
			var url='index.php?m=user&do=check';
			var data={type:id,data:value};
			_ajax(url,data,function(res){
				callback_check(res);
			});
		}
	})
	//验证用户名或邮箱
	function callback_check(res){
		ajaxSending=false;
		res=eval("("+res+")");
		if(res['status']==-1){
			alert('请求失败');
			return false;
		}
		var id='';
		id=res['data']['type'];
		//防止相同值重复提交
		$('#auth'+id).val(res['data']['val']);
		if(res['status']==1){
			$('#'+id).parent("div").parent("div").addClass('has-success');
		}else{
			errormessage(id,res['data']['msg']);
		}
		
	}
	function errormessage(id,msg){
		if(msg==''){
			$('#'+id).parent("div").parent("div").removeClass('has-success');
			$('#'+id).next('span').text('');
		}else{
			$('#'+id).next('span').text(msg);
		}
		
	}
	//登录
	//获取登录框视图模版

	$('#btn_login').unbind("click").click(function(){
		var l_name=$.trim($('#li_username').val());
		var l_pwd=$.trim($('#li_pwd').val());
		var l_autologin=$('#li_autologin').is(':checked');
		var loginbtn=1;
		if(l_name=='' || l_pwd==''){
			alert('用户名或密码不能为空');
			$('#li_username').focus();
			return false;
		}
		var data={username:l_name,pwd:l_pwd,autologin:l_autologin,loginbtn:loginbtn};
		var url='index.php?m=user&do=login';
		_ajax(url,data,function(res){
			callback_login(res);
		});
		return false;
	})
	function callback_login(res){
		ajaxSending=false;
		res=eval("("+res+")");
		if(res['status']==-1){
			alert('请求失败');
			return false;
		}
		if(res['status']==1){
			window.location.reload();
		}else{
			$('#li_error').text(res['data']);
		}
		
	}
	
	//dropdown
	$('.dropdown').unbind("mouseover").mouseover(function(){
		$(this).addClass('open');
	})
	$('.dropdown').unbind("mouseout").mouseout(function(){
		$(this).removeClass('open');
	})

	//add comment
	$('#addcomment').unbind("click").click(function(){
		var aid=$('#article_subject').attr('data');
		var content=$('#comment_edit').val();
		content=strip_tags(content);
		content=content.replace(/&nbsp;/g, '');
		if(content==''){
			alert('评论内容不能为空');
			return false;
		}
		var rcid=$(this).attr('data');
		var data={aid:aid,content:content,rcid:rcid};
		var url='index.php?m=comment&do=add';
		_ajax(url,data,function(res){
			callback_addcomment(res);
		});
		return false;
	})
	function callback_addcomment(res){
		ajaxSending=false;
		res=eval("("+res+")");
		if(res['status']==-1){
			alert('请求失败');
			return false;
		}
		if(res['status']==1){
			$('#comment_edit').val('');
			$('.no-conmment').remove();
			$('.comments-list').append(res['data']);
		}else{
			$('.editor-notice').text(res['data']);
		}
	}
	//load more
	$('.loadmore').unbind("click").click(function(){
		var dom=$(this);
		var url=dom.attr('data');
		if(url==''){
			alert('请求失败');
			return false;
		}
		dom.text('正在加载...');
		dom.attr('disabled',true);

		_ajax(url,'',function(res){
			callback_getcomment(res);
		});

	})
	function callback_getcomment(res){
		var dom=$('.loadmore');
		ajaxSending=false;
		res=eval("("+res+")");
		if(res['status']==-1){
			alert('请求失败');
			return false;
		}
		if(res['status']==1){
			$('.comments-list').append(res['data']['content']);
			//reset bind
			$('.com-tip-recom').unbind("click").click(function(){
				reply_comment($(this));
			})
			$('.com-tip-like').unbind("click").click(function(){
				zan_comment($(this));
			})
			if(res['data']['next']==''){
				dom.remove();
				return true;
			}
		}else{
			alert(res['data']);
		}
		dom.text('加载更多');
		dom.attr('data',res['data']['next']);
		dom.attr('disabled',false);
	}
	//reply comment
	$('.com-tip-recom').unbind("click").click(function(){
		reply_comment($(this));
	})
	//zan comment
	$('.com-tip-like').unbind("click").click(function(){
		zan_comment($(this));
	})
	function zan_comment(dom){
		var cid=dom.attr('data');
		var data={cid:cid};
		var url='index.php?m=comment&do=zan';
		_ajax(url,data,function(res){
			ajaxSending=false;
			res=eval("("+res+")");
			if(res['status']==-1){
				alert('请求失败');
				return false;
			}
			if(res['status']==1){
				var num=dom.find('span').text();
				if(num==''){
					num = 1;
				}else{
					if(res['data']==1){
						num = parseInt(num)+1;
					}else if(res['data']==-1){
						if(num!=0){
							num = parseInt(num)-1;
						}
					}
				}
				dom.find('span').text(num);
			}else{
				alert(res['data']);
			}
		});
	}
	
})
function reply_comment(dom){
	var cid=dom.attr('data');
	var author=dom.parents('.media-body').find('.com-author').text();
	$('#addcomment').attr('data',cid);
	var html='<span style="color:#c1c1c1;">回复<span style="margin:0px 10px;">'+author+'</span><a href="javascript:;" onclick="removereply(this);">X</a></span>';
	$('.edit-bottom-left').html(html);
}

function removereply(dom){
	$('#addcomment').attr('data','');
	$(dom).parents('.edit-bottom-left').html('');
}
//仿php in_array
function in_array(needle, haystack) {
	if(typeof needle == 'string' || typeof needle == 'number') {
		for(var i in haystack) {
			if(haystack[i] == needle) {
				return true;
			}
		}
	}
	return false;
}
//ajax 
function _ajax(url,data,callback){
	if(ajaxSending==true){
		alert('有请求正在执行...');
		return false;
	}
	$.ajax({
		type:'post',
		url:url,
		data:data,
		beforeSend:function(){
			ajaxSending=true;
		},
		success:callback,
		error:function(){
			ajaxSending=false;
		}
	});
}
function _ajax_return(res){
	ajaxSending=false;
	res=eval("("+res+")");
	if(res['status']==-1){
		return 0;
	}
	return res;
}
function isUndefined(variable) {
	return typeof variable == 'undefined' ? true : false;
}
function mb_strlen(str) {
	var len = 0;
	for(var i = 0; i < str.length; i++) {
		len += str.charCodeAt(i) < 0 || str.charCodeAt(i) > 255 ? 3 : 1;
	}
	return len;
}
//js strip_tags
function strip_tags(input, allowed) {
  allowed = (((allowed || '') + '')
    .toLowerCase()
    .match(/<[a-z][a-z0-9]*>/g) || [])
    .join(''); // making sure the allowed arg is a string containing only tags in lowercase (<a><b><c>)
  var tags = /<\/?([a-z][a-z0-9]*)\b[^>]*>/gi,
    commentsAndPhpTags = /<!--[\s\S]*?-->|<\?(?:php)?[\s\S]*?\?>/gi;
  return input.replace(commentsAndPhpTags, '')
    .replace(tags, function($0, $1) {
      return allowed.indexOf('<' + $1.toLowerCase() + '>') > -1 ? $0 : '';
    });
}
//延迟加载
$(function(){
	$("img.lazy").lazyload({
		effect : "fadeIn"
	});
})