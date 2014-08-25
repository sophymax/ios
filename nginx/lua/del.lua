local res=ngx.location.capture('/search/select?q=moe.fm/ajax&rows=100&wt=json&indent=true')
                        local cjson=require 'cjson'
                        local data=cjson.decode(res.body)
                        local reqs = {}
                        for i=1,100,1 do
                                local solr_id=data.response.docs[i].id
                                if string.find(solr_id,'moe.fm/ajax') ~= nil then
                                        table.insert(reqs,{'/search/update?stream.body=%3Cdelete%3E%3Cid%3E'..solr_id..'%3C/id%3E%3C/delete%3E&stream.contentType=text/xml;charset=utf-8&commit=true'})
                                        --ngx.location.capture('/search/update?stream.body=%3Cdelete%3E%3Cid%3E'..solr_id..'%3C/id%3E%3C/delete%3E&stream.contentType=text/xml;charset=utf-8&commit=true')
                                        ngx.say(solr_id..'_ok<br>')
                                else
                                        --ngx.print(solr_id..'_hehe<br>')
                                end
                        end
                        local resps = { 
			ngx.location.capture_multi(reqs)
			 }
                        for i, resp in ipairs(resps) do
                              ngx.say(resp.body..'del success<br>')
                        end
