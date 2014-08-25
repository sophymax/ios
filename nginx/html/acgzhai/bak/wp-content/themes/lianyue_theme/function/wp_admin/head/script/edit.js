// 可视化编辑器js

//翻页代码
(function() {
    tinymce.create('tinymce.plugins.nextpage', {
        init : function(ed, url) {
            ed.addButton('nextpage', {
                title : '插入翻页代码',
                //image : url+'/images/nextpage.png',
                onclick : function() {
                     ed.selection.setContent('<img class="mceWPnextpage mceItemNoResize" title="下一页..." src="../wp-includes/js/tinymce/plugins/wordpress/img/trans.gif" alt="" data-mce-src="../wp-includes/js/tinymce/plugins/wordpress/img/trans.gif">');

                }
            });
        },
        createControl : function(n, cm) {
            return null;
        },
    });
    tinymce.PluginManager.add('nextpage', tinymce.plugins.nextpage);
})();

//警告框
(function() {
    tinymce.create('tinymce.plugins.warning', {
        init : function(ed, url) {
            ed.addButton('warning', {
                title : '添加警告框',
				image : url+'/../image/warning.png',
                onclick : function() {
                     ed.selection.setContent('<div class="warning">' + ed.selection.getContent() + '</div>');

                }
            });
        },
        createControl : function(n, cm) {
            return null;
        },
    });
    tinymce.PluginManager.add('warning', tinymce.plugins.warning);
})();

//允许框
(function() {
    tinymce.create('tinymce.plugins.accepted', {
        init : function(ed, url) {
            ed.addButton('accepted', {
				image : url+'/../image/accepted.png',
                title : '添加允许框',
                onclick : function() {
                     ed.selection.setContent('<div class="accepted">' + ed.selection.getContent() + '</div>');

                }
            });
        },
        createControl : function(n, cm) {
            return null;
        },
    });
    tinymce.PluginManager.add('accepted', tinymce.plugins.accepted);
})();


//禁止框
(function() {
    tinymce.create('tinymce.plugins.cancel', {
        init : function(ed, url) {
            ed.addButton('cancel', {
				image : url+'/../image/cancel.png',
                title : '添加禁止框',
                onclick : function() {
                     ed.selection.setContent('<div class="cancel">' + ed.selection.getContent() + '</div>');

                }
            });
        },
        createControl : function(n, cm) {
            return null;
        },
    });
    tinymce.PluginManager.add('cancel', tinymce.plugins.cancel);
})();


//箭头框
(function() {
    tinymce.create('tinymce.plugins.arrow', {
        init : function(ed, url) {
            ed.addButton('arrow', {
				image : url+'/../image/arrow.png',
                title : '添加箭头框',
                onclick : function() {
                     ed.selection.setContent('<div class="arrow">' + ed.selection.getContent() + '</div>');

                }
            });
        },
        createControl : function(n, cm) {
            return null;
        },
    });
    tinymce.PluginManager.add('arrow', tinymce.plugins.arrow);
})();

//下载框
(function() {
    tinymce.create('tinymce.plugins.download', {
        init : function(ed, url) {
            ed.addButton('download', {
				image : url+'/../image/download.png',
                title : '添加下载框',
                onclick : function() {
                     ed.selection.setContent('<div class="download">' + ed.selection.getContent() + '</div>');

                }
            });
        },
        createControl : function(n, cm) {
            return null;
        },
    });
    tinymce.PluginManager.add('download', tinymce.plugins.download);
})();

//下载框
(function() {
    tinymce.create('tinymce.plugins.down', {
        init : function(ed, url) {
            ed.addButton('down', {
				image : url+'/../image/down.png',
                title : '添加下载按钮',
                onclick :function lianyue_down() {
					var url = prompt('下载地址', 'http://');
					var title = prompt('下载名称', '下载地址');
					if ( url && title ){
						tinyMCE.execCommand('mceInsertContent', false, '<div class="down"><a href="'+url+'" rel="attachment download"  target="_blank" title="'+title+'"><span>'+title+'</span></a></div>');
					}
				}
            });
        },
        createControl : function(n, cm) {
            return null;
        },
    });
    tinymce.PluginManager.add('down', tinymce.plugins.down);
})();
