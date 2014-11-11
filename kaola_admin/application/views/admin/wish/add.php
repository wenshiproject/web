<!--右侧-->
	<div class="sdk_right">
		<div class="sdk_rightnav">当前位置：许愿清单 > 添加信息</div>
		<div class="sdk_righcon">
			<form action="" method="post" enctype="multipart/form-data" class="needValidate">
			<table cellspacing="0" cellpadding="0" border="0" width="100%" class="sdk_table1">
              	<tr>
              		<td align="right" width="150"><lable class="colred">*</lable>信息标题：</td><td><input type="text" class="sdk_zhucetext" size="15" name="title" value="" class="{required:true,messages:{required:'不能为空'}}"/>
              		</td>
              </tr>
               <tr>
              		<td align="right" width="150"><lable class="colred">*</lable>信息全文：</td><td><input type="text" class="sdk_zhucetext" size="15" name="content" value="" class="{required:true,messages:{required:'不能为空'}}" />
              		</td>
              </tr>
			 <tr>
				<td align="right" width="150"> <lable class="colred">*</lable> 图片：</td> <td><input type="button" id="add_id" value="增加图片" onclick="addimg()"></td>
			  </tr>
			  <tr id="tr_img">
				<td align="right" width="150"> <lable class="colred">&nbsp;</td><td><input type="file" name="image[]"/></td>
			  </tr>
			  <tr>
				<td align="right" width="150">  &nbsp;&nbsp;</td>
			  	<td><input type="submit" class="sdk_queren" id="" value="提交" />
			  	</td>
			  </tr>
			</table>
			
			</form>
		</div>
	</div>
<!--右侧-->
<script>
function addimg(){
	$("#tr_img").after('<tr><td align="right" width="150"> <lable class="colred">&nbsp;</td><td><input type="file" name="image[]"/></td></tr>');
}
</script>