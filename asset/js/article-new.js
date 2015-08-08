//window.onbeforeunload = function() {
//	return("有内容正在编辑，确定离开？");
//}
$(function(){
	$('#article_content').summernote({
		lang: 'zh-CN',
		height: 300,
		minHeight: null,
		maxHeight: null,
		focus: true ,
		styleTags: ['p', 'blockquote', 'pre', 'h3'],
		toolbar: [
			['style', ['style']],
			['style', ['bold', 'italic', 'underline', 'clear']],
			['insert', ['picture', 'link', 'hr']],
		],
		onImageUpload: function(files, editor, $editable) {
			for(var i=0;i<files.length;i++){
				sendFile(files[i],editor,$editable);
			}
		}
	});
	$('#article_content').code(defaultcontent);
	function sendFile(file, editor, $editable){

		data = new FormData();
		data.append("file", file);
		$.ajax({
			data: data,
			type: "POST",
			url: "index.php?m=upload&do=article-new",
			cache: false,
			async: false,
			contentType: false,
			processData: false,
			success: function(data) {
				res=eval("("+data+")");
				if(res['status']==1){
					var imgwidth=600;
					var imgurl=res['data']['url'];
					var aid=res['data']['aid'];
					editor.insertImage($editable,imgurl,aid,imgwidth);
				}else{
					alert(res['data']);
				}
			},
			error:function(){
				alert('err');
			}
		});
	}
	
	$('button[action-type=article-new]').unbind("click").click(function(){
		var subject=$('#subject').val();
		var content=$('#article_content').code();
		var tmpsub=tmpcontent='';
		tmpsub=subject.replace(/&nbsp;/g, '');
		tmpcontent=strip_tags(content);
		tmpcontent=tmpcontent.replace(/&nbsp;/g, '');
		if(tmpsub=='' || tmpcontent==''){
			alert('标题或内容不能为空');
			return false;
		}
		if(subject.length>80){
			alert('标题不能超过 80 个字符');
			return false;
		}
		var url='index.php?m=article&do=new';
		var data={subject:subject,content:content,type:'new'};
		_ajax(url,data,function(res){
			callback_article_new(res);
		});
	})
	function callback_article_new(res){
		ajaxSending=false;
		res=eval("("+res+")");
		if(res['status']==-1){
			alert('请求失败');
			return false;
		}
		if(res['status']==1){
			alert(res['data']);
		}else{
			alert(res['data']);
		}
	}
});

