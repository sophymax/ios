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
  <td height="46" colspan="2">��������˽�������ǵĲ�Ʒ�����, �뻨����������д���ű��, ���ǽ����������Ϣ���跴����</td>
</tr>
<tr>
  <td width="48" height="30">�� ��: </td>
    <td width="640"><label><input name="g_name" type="text" class="input" id="g_name" />
        <span class="STYLE1">*</span></label></td></tr>
<tr>
  <td height="30">�� ��:</td>
    <td><label><input name="g_xb" type="radio" value="����" checked="checked" />Mr <input type="radio" name="g_xb" value="Ůʿ" />Miss</label></td></tr>
<tr>
  <td height="30">�� ��: </td>
    <td><input name="g_mail" type="text" class="input" id="g_mail" />
      <span class="STYLE1">*</span></td>
</tr>
<tr>
  <td height="30">�� ַ:</td>
    <td><input name="g_add" type="text" class="input" id="g_add" size="50" />
      <span class="STYLE1">*</span></td>
</tr>
<tr>
  <td height="30">ʡ ��:</td>
    <td><input name="g_s" type="text" class="input" id="g_s" /></td>
</tr>
<tr>
  <td height="30">�� ��</td>
    <td><input name="g_gj" type="text" class="input" id="g_gj" />
      <span class="STYLE1">*</span></td>
</tr>
<tr>
  <td height="30">�� ��: </td>
    <td><input name="g_yb" type="text" class="input" id="g_yb" /></td></tr>
<tr>
  <td height="30">�� ��:</td>
    <td><input name="g_tel" type="text" class="input" id="g_tel" />
      <span class="STYLE1">*</span></td>
</tr>
<tr>
  <td height="30">�� ��: </td>
    <td><input name="g_fax" type="text" class="input" id="g_fax" />
      <span class="STYLE1">*</span></td>
</tr>
<tr>
  <td height="30">�� ��: </td>
    <td><label>
      <textarea name="g_con" cols="50" rows="8" id="g_con"></textarea>    
      <span class="STYLE1">*</span></label></td></tr>
<tr>
  <td height="14" colspan="2"><span class="STYLE1">* </span>������Ŀ </td>
</tr>
<tr><td height="30">&nbsp;</td><td>
  <label>
  <input name="submit" type="submit" class="input1" style="FONT-SIZE: 12px; background-color:#00243C; color:#FFF; cursor :pointer;LINE-HEIGHT: 22px; font-family:Arial, Helvetica, sans-serif; TEXT-DECORATION: none" onclick="return CheckForm();" onmouseover="tst(this,'#0099FF','#00243C')" onmouseout="tst(this,'#999','#00243C')" value=" �ύ "/>
  </label>
  &nbsp;&nbsp;
<label><input name="Submit2" type="reset" class="input" style="FONT-SIZE: 12px;background-color:#00243C; color:#FFF; cursor :pointer;LINE-HEIGHT: 22px; cursor :pointer;font-family:Arial, Helvetica, sans-serif; TEXT-DECORATION: none" onmouseover="tst(this,'#0099FF','#00243C')" onmouseout="tst(this,'#999','#00243C')" value=" ���� "/>
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
  alert("*Ϊ������Ŀ������д������");
  document.form1.g_name.focus();
  return false;
 }  
  if (document.form1.g_add.value.length == 0) {
  alert("*Ϊ������Ŀ������д������");
  document.form1.g_add.focus();
  return false;
 }
 if (document.form1.g_mail.value.length == 0) {
  alert("*Ϊ������Ŀ������д������");
  document.form1.g_mail.focus();
  return false;
 }
 if (document.form1.g_tel.value.length == 0) {
  alert("*Ϊ������Ŀ������д������");
  document.form1.g_tel.focus();
  return false;
 }
 if (document.form1.g_con.value.length == 0) {
  alert("*Ϊ������Ŀ������д������");
  document.form1.g_con.focus();
  return false;
 }
   return true;   
}
 </script>