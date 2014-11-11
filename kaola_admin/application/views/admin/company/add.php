<!--右侧-->
	<div class="sdk_right">
		<div class="sdk_rightnav">当前位置：开发商管理 > 添加开发商</div>
		<div class="sdk_righcon">
			<form action="" method="post" enctype="multipart/form-data" class="needValidate">
			<table cellspacing="0" cellpadding="0" border="0" width="100%" class="sdk_table1">
              	<tr>
              		<td align="right" width="150"><lable class="colred">*</lable>开发商邮箱：</td><td><input type="text" class="sdk_zhucetext" size="15" name="email" value="" class="{required:true,messages:{required:'不能为空'}}"/>
              		</td>
              </tr>
               <tr>
              		<td align="right" width="150"><lable class="colred">*</lable>开发商身份：</td><td>
              			<input type="radio" name="identity" value="1" checked="checked" onclick="check_identity(1);"/>公司开发者 
						<input type="radio" name="identity" value="2" onclick="check_identity(2);"/>个人开发者
              		</td>
              </tr>
               <tr>
              		<td align="right" width="150"><lable class="colred">*</lable>开发商名称：</td><td><input type="text" class="sdk_zhucetext" size="15" name="name" value="" class="{required:true,messages:{required:'不能为空'}}" />
              		</td>
              </tr>
               <tr>
              		<td align="right" width="150"><lable class="colred">*</lable>联系地址：</td><td><input type="text" class="sdk_zhucetext" size="15" name="address" value="" class="{required:true,messages:{required:'不能为空'}}" />
              		</td>
              </tr>
               <tr>
              		<td align="right" width="150"><lable class="colred">*</lable>手机号码：</td><td><input type="text" class="sdk_zhucetext" size="15" name="phone" value="" class="{required:true,messages:{required:'不能为空'}}" />
              		</td>
              </tr>
               <tr>
              		<td align="right" width="150"><lable class="colred">*</lable>联系人：</td><td><input type="text" class="sdk_zhucetext" size="15" name="contact" value="" class="{required:true,messages:{required:'不能为空'}}" />
              		</td>
              </tr>
               <tr>
              		<td align="right" width="150"><lable class="colred">*</lable>联系QQ：</td><td><input type="text" class="sdk_zhucetext" size="15" name="qq" value="" class="{required:true,messages:{required:'不能为空'}}" />
              		</td>
              </tr>
              <tbody id="license_id">
			  <tr>
				<td align="right" width="150"> <lable class="colred">*</lable> 营业执照：</td><td><input type="button" id="add_id" value="增加图片" onclick="addimg()"></td>
			  </tr>
			  <tr id="tr_img">
				<td align="right" width="150"> <lable class="colred">&nbsp;</td><td><input type="file" name="image[]"/></td>
			  </tr>
			  </tbody>
			  <tr>
				<td align="right" width="150">&nbsp;&nbsp;</td>
			  	<td><input type="submit" class="sdk_queren" id="" value="提交" />
			  	</td>
			  </tr>
			</table>
			
			</form>
		</div>
	</div>
<!--右侧-->
<script>
function check_identity(val){
	if(val == 2){
		$("#license_id").hide();
		return;
	}else{
		$("#license_id").show();
		return;
	}
}

function addimg(){
	$("#tr_img").after('<tr><td align="right" width="150"> <lable class="colred">&nbsp;</td><td><input type="file" name="image[]"/></td></tr>');
}
</script>