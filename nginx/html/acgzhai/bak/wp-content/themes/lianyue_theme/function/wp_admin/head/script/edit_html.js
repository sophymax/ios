QTags.addButton( 'nextpage', '分页代码', '<!--nextpage-->');
QTags.addButton( 'warning', '警告框', '<div class="warning">','</div>');
QTags.addButton( 'accepted', '允许框', '<div class="accepted">','</div>');
QTags.addButton( 'cancel', '禁止框', '<div class="cancel">','</div>');
QTags.addButton( 'arrow', '箭头框', '<div class="arrow">','</div>');
QTags.addButton( 'download', '下载框', '<div class="download">','</div>');
QTags.addButton( 'down', '下载按钮', lianyue_down );


function lianyue_down() {
	var url = prompt('下载地址', 'http://');
	var title = prompt('下载名称', '下载地址');
	if ( url && title ){
		document.getElementById('content').value = document.getElementById('content').value + '<div class="down"><a href="'+url+'" rel="attachment download"  target="_blank" title="'+title+'"><span>'+title+'</span></a></div>';
	}
}

/*
QTags.addButton( 'id_1', '短代码', '[shortcode]','[/shortcode]');
QTags.addButton( 'id_2', '消息框', my_callback );
function my_callback(){ alert("我是一个消息框！")}
*/