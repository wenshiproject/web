<!--右侧-->
	<div class="sdk_right">
		<div class="sdk_rightnav">当前位置：开发商管理 > 编辑开发商</div>
		<div class="sdk_righcon">
			<form action="" method="post" enctype="multipart/form-data" class="needValidate">
			<table cellspacing="0" cellpadding="0" border="0" width="100%" class="sdk_table1">
              	<tr>
              		<td align="right" width="150"><lable class="colred">*</lable>开发商名称：</td><td><input type="text" class="sdk_zhucetext" size="15" name="name" value="<?php echo $rs['name'];?>" class="{required:true,messages:{required:'不能为空'}}"/>
              		</td>
              </tr>
               <tr>
              		<td align="right" width="150"><lable class="colred">*</lable>身份：</td><td><input type="text" class="sdk_zhucetext" size="15" name="identity" value="<?php echo $rs['identity'];?>" class="{required:true,messages:{required:'不能为空'}}" />
              		</td>
              </tr>
              <tr>
              		<td align="right" width="150"><lable class="colred">*</lable>联系地址：</td><td><input type="text" class="sdk_zhucetext" size="15" name="address" value="<?php echo $rs['address'];?>" class="{required:true,messages:{required:'不能为空'}}" />
              		</td>
              </tr>
              <tr>
              		<td align="right" width="150"><lable class="colred">*</lable>注册邮箱：</td><td><input type="text" class="sdk_zhucetext" size="15" name="email" value="<?php echo $rs['email'];?>" class="{required:true,messages:{required:'不能为空'}}" />
              		</td>
              </tr>
              <tr>
              		<td align="right" width="150"><lable class="colred">*</lable>QQ：</td><td><input type="text" class="sdk_zhucetext" size="15" name="qq" value="<?php echo $rs['qq'];?>" class="{required:true,messages:{required:'不能为空'}}" />
              		</td>
              </tr>
              <tr>
              		<td align="right" width="150"><lable class="colred">*</lable>手机号码：</td><td><input type="text" class="sdk_zhucetext" size="15" name="phone" value="<?php echo $rs['phone'];?>" class="{required:true,messages:{required:'不能为空'}}" />
              		</td>
              </tr>
               <tr>
              		<td align="right" width="150"><lable class="colred">*</lable>联系人：</td><td><input type="text" class="sdk_zhucetext" name="contact" value="<?php echo $rs['contact'];?>" class="{required:true,messages:{required:'不能为空'}}"/>
              		</td>
              </tr>
			  <tr>
				<td align="right" width="150"> <lable class="colred">*</lable>营业执照：</td><td><input type="button" id="add_id" value="增加图片" onclick="addimg()"></td>
			  </tr>
			  <?php if($rs['license_image_path']):?>
						<?php foreach ($rs['license_image_path'] as $key => $val):?>
							<tr id="<?php echo $key;?>">
							<td align="right" width="150">&nbsp;</td>
							<td><img src="<?php echo $val;?>"><input type="button" value="删除" onclick="delimg('<?php echo $rs['license_image'][$key];?>', '<?php echo $rs['id']?>','<?php echo $key?>')"/></td></tr>
						<?php endforeach;?>
					<?php endif;?>
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
function delimg(key, id, index){
	$.ajax({
	    url:'/admin/company/delimg',// 跳转到 action  
	    data:{
	        key : key,
	        id	: id,
	    },
	    type:'POST',    
	    cache:false,    
	    dataType:'json',    
	    success:function(data){   
	        if(data.msg == 1){
		        $("#"+index).remove();
	        }else{
		        alert("操作失败");
		        return false;
	        }
	     },
	     error : function() {    
	         alert("异常！");    
	     }    
	});
}

function addimg(){
	$("#tr_img").after('<tr><td align="right" width="150"> <lable class="colred">&nbsp;</td><td><input type="file" name="image[]"/></td></tr>');
}
</script>