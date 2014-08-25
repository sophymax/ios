<style type="text/css">
<!--
*{font-size: 14px; color:#999;font-family: Arial, Helvetica, sans-serif;}
.STYLE1 {color: #FF0000}
body {
	background-color: #000;
}
.input,textarea{color:#999;background-color: #222;border:1px solid #999;SCROLLBAR-TRACK-COLOR:#777;SCROLLBAR-FACE-COLOR:#666;SCROLLBAR-3DLIGHT-COLOR:#333;SCROLLBAR-DARKSHADOW-COLOR: :FF3300 }
#input2{color:#999;background-color: #000;SCROLLBAR-TRACK-COLOR:#999;SCROLLBAR-ARROW-COLOR: #FF3300;}
.input1 {color:#999;background-color: #222;border:1px solid #999;SCROLLBAR-TRACK-COLOR:#777;SCROLLBAR-FACE-COLOR:#666;SCROLLBAR-3DLIGHT-COLOR:#333;SCROLLBAR-DARKSHADOW-COLOR: :FF3300 }
-->
</style>

<table width="700">
<form id="form1" name="form1" action="http://www.newgenlites.com/ch/gbook_ad.asp?Action=ok" method="post" onsubmit="return Validator.Validate(this,3)" >
<tbody><tr>
  <td height="46" colspan="2">如果您想了解更多我们的产品或服务, 请花几分钟来填写这张表格, 我们将会对您的信息给予反馈。</td>
</tr>
<tr>
  <td width="48" height="30">姓 名: </td>
    <td width="640"><label><input name="g_name" type="text" class="input" id="g_name" />
        <span class="STYLE1">*</span></label></td></tr>
<tr>
  <td height="30">性 别:</td>
    <td><label><input name="g_xb" type="radio" value="先生" checked="checked" />Mr <input type="radio" name="g_xb" value="女士" />Miss</label></td></tr>
<tr>
  <td height="30">邮 箱: </td>
    <td><input name="g_mail" type="text" class="input" id="g_mail" />
      <span class="STYLE1">*</span></td>
</tr>
<tr>
  <td height="30">地 址:</td>
    <td><input name="g_add" type="text" class="input" id="g_add" size="50" />
      <span class="STYLE1">*</span></td>
</tr>
<tr>
  <td height="30">省 市:</td>
    <td><input name="g_s" type="text" class="input" id="g_s" /></td>
</tr>
<tr>
  <td height="30">国 家</td>
    <td><input name="g_gj" type="text" class="input" id="g_gj" />
      <span class="STYLE1">*</span></td>
</tr>
<tr>
  <td height="30">邮 编: </td>
    <td><input name="g_yb" type="text" class="input" id="g_yb" /></td></tr>
<tr>
  <td height="30">电 话:</td>
    <td><input name="g_tel" type="text" class="input" id="g_tel" />
      <span class="STYLE1">*</span></td>
</tr>
<tr>
  <td height="30">传 真: </td>
    <td><input name="g_fax" type="text" class="input" id="g_fax" />
      <span class="STYLE1">*</span></td>
</tr>
<tr>
  <td height="30">留 言: </td>
    <td><label>
      <textarea name="g_con" cols="50" rows="8" id="g_con"></textarea>    
      <span class="STYLE1">*</span></label></td></tr>
<tr>
  <td height="14" colspan="2"><span class="STYLE1">* </span>必填栏目 </td>
</tr>
<tr><td height="30">&nbsp;</td><td>
  <label>
  <input name="submit" type="submit" class="input1" style="FONT-SIZE: 12px; background-color:#00243C; color:#FFF; cursor :pointer;LINE-HEIGHT: 22px; font-family:Arial, Helvetica, sans-serif; TEXT-DECORATION: none" onclick="return CheckForm();" onmouseover="tst(this,'#0099FF','#00243C')" onmouseout="tst(this,'#999','#00243C')" value=" 提交 "/>
  </label>
  &nbsp;&nbsp;
<label><input name="Submit2" type="reset" class="input" style="FONT-SIZE: 12px;background-color:#00243C; color:#FFF; cursor :pointer;LINE-HEIGHT: 22px; cursor :pointer;font-family:Arial, Helvetica, sans-serif; TEXT-DECORATION: none" onmouseover="tst(this,'#0099FF','#00243C')" onmouseout="tst(this,'#999','#00243C')" value=" 重置 "/>
</label>
</td></tr></tbody></form></table>
<script>
function tst(obj0,obj1,obj2){
obj0.style.border="1 "+obj1+" solid";
obj0.style.background=obj2;
}
</script>
<script language="javascript">
function CheckForm()
{
 if (document.form1.g_name.value.length == 0) {
  alert("*为必填栏目，请填写完整！");
  document.form1.g_name.focus();
  return false;
 }  
  if (document.form1.g_add.value.length == 0) {
  alert("*为必填栏目，请填写完整！");
  document.form1.g_add.focus();
  return false;
 }
 if (document.form1.g_mail.value.length == 0) {
  alert("*为必填栏目，请填写完整！");
  document.form1.g_mail.focus();
  return false;
 }
 if (document.form1.g_tel.value.length == 0) {
  alert("*为必填栏目，请填写完整！");
  document.form1.g_tel.focus();
  return false;
 }
 if (document.form1.g_con.value.length == 0) {
  alert("*为必填栏目，请填写完整！");
  document.form1.g_con.focus();
  return false;
 }
   return true;   
}
 </script>