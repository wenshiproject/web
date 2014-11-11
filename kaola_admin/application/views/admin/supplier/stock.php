<!--右侧-->
	<div class="sdk_right">
		<div class="sdk_rightnav">当前位置：游戏管理 >添加游戏</div>
		<div class="sdk_righcon">
			<form action="" method="post" enctype="multipart/form-data" class="needValidate">
			<table cellspacing="0" cellpadding="0" border="0" width="100%" class="sdk_table1">
              	<tr>
              		<td align="right" width="150"><lable class="colred">*</lable>游戏名称：</td><td><input type="text" class="sdk_zhucetext" size="15" name="name" value="" class="{required:true,messages:{required:'不能为空'}}"/>
              		</td>
              </tr>
               <tr>
              		<td align="right" width="150"><lable class="colred">*</lable>开发商：</td><td><input type="text" class="sdk_zhucetext" size="15" name="company" value="" class="{required:true,messages:{required:'不能为空'}}" />
              		</td>
              </tr>
               <tr>
              		<td align="right" width="150"><lable class="colred">*</lable>游戏简介：</td><td><input type="text" class="sdk_zhucetext" name="desc" value="" class="{required:true,messages:{required:'不能为空'}}"/>
              		</td>
              </tr>
			  <tr>
				<td align="right" width="150"> <lable class="colred">*</lable> 游戏icon：</td>
				<td>
					<input type="file"/>
                </td>
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
<script language="javascript" type="text/javascript">  
        $(function () {  
            $("#selectall").click(function () {
                if($(this).attr("checked") == 'checked'){
                	$("#checklist :checkbox").attr("checked", true); 
                }else{
                	$("#checklist :checkbox").attr("checked", false); 
                }
            });
        });  
    </script>  