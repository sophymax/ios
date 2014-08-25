                        local qs=ngx.req.get_uri_args()['q']
			local res=ngx.location.capture('/search/select?q=title%3A'..ngx.escape_uri(qs)..'+OR+text%3A'..ngx.escape_uri(qs)..'&wt=json&indent=true')
                        local cjson=require 'cjson'
                        local data=cjson.decode(res.body)
			ngx.say('<html><head><title>ACG宅|'..qs..'|游戏动漫搜索引擎</title><style type="text/css">a:link {color: #458B74} a:visited {color: #8B0A50}</style></head><body>')
                        ngx.say('<input type=text style=\"width:30%;height:35px;\" id=\"box\"><input type=button style="height:35px;width:90px;" value="轻轻地抚摸"  src="btn.png" onclick="window.location.href=\'select?q=\'+document.getElementById(\'box\').value;">')
                        ngx.say('<script>document.getElementById("box").focus();document.getElementById("box").value=\"'..ngx.req.get_uri_args()['q']..'\";document.onkeydown=function(event){var e = event ? event :(window.event ? window.event : null);if(e&&e.keyCode==13){window.location.href=\"http://www.acgzhai.net/select?q=\"+document.getElementById(\"box\").value;}}</script><p>')
                        if data.response==nil then ngx.exit(200) end
                        for i=1,10,1 do
                                if data.response.docs[i]==nil then
                                        break
                                end
                                local endp=''
				local sp,_=string.find(data.response.docs[i].content,qs)
                                local tab={}
				if sp==nil then sp=0 end
                                for uchar in string.gfind(string.sub(data.response.docs[i].content,sp), '[%z\1-\127\194-\244][\128-\191]*') do tab[#tab+1] = uchar end
                                        for j=1,200,1 do
                                                if tab[j]~=nil then
                                                        endp=endp..tab[j]
                                                end
                                        end
                                if data.response.docs[i].title~=nil then
                                        ngx.say('<div style=\"width:50%\"><a  target="_blank"  rel="nofollow external"  href=\"'..data.response.docs[i].url..'\">'..data.response.docs[i].title..'</a><br><span style=\"font-size:12px;\">'..data.response.docs[i].url..'</span><br><span style=\"font-size:14px;\">'..endp..'</span><br><p></div>')
                                end
                        end
 ngx.say('<p><a href="http://www.acgzhai.net/">ACG宅</a></p><script>var _hmt = _hmt || [];(function() {  var hm = document.createElement(\"script\");  hm.src = \"//hm.baidu.com/hm.js?6611821b005e2fca37699d37e831c22e\";  var s = document.getElementsByTagName(\"script\")[0];   s.parentNode.insertBefore(hm, s);})();</script></body></html>')
