<!--右侧-->
	<div class="sdk_right">
		<div class="sdk_rightnav">当前位置：奖品管理 > 编辑奖品</div>
		<div class="sdk_righcon">
			<form action="" method="post" enctype="multipart/form-data" class="needValidate">
			<table cellspacing="0" cellpadding="0" border="0" width="100%" class="sdk_table1">
              	<tr>
              		<td align="right" width="150"><lable class="colred">*</lable>奖品名称：</td><td><input type="text" class="sdk_zhucetext" size="15" name="name" value="<?php echo $rs['name']?>" class="{required:true,messages:{required:'不能为空'}}"/>
              		</td>
              </tr>
               <tr>
              		<td align="right" width="150"><lable class="colred">*</lable>奖品编码：</td><td><input readonly="readonly" type="text" class="sdk_zhucetext" size="15" name="code" value="<?php echo $rs['code']?>" class="{required:true,messages:{required:'不能为空'}}" />
              		</td>
              </tr>
              <tr>
              		<td align="right" width="150"><lable class="colred">*</lable>奖品数量：</td><td><input readonly="readonly" type="text" class="sdk_zhucetext" size="15" name="number" value="<?php echo $rs['number']?>" class="{required:true,messages:{required:'不能为空'}}" />
              		</td>
              </tr>
              <tr>
              		<td align="right" width="150"><lable class="colred">*</lable>游戏ID：</td><td><input readonly="readonly" type="text" class="sdk_zhucetext" name="game_id" value="<?php echo $rs['game_id']?>" class="{required:true,messages:{required:'不能为空'}}"/>
              		</td>
              </tr>
              
              <tr>
              		<td align="right" width="150"><lable class="colred">*</lable>宣传图：</td>
              		<td>
						<?php if($rs['broadcast_img']):?>              			
              			<img src="<?php echo $rs['broadcast_img_url'];?>">
              			<?php endif;?>
              			<input type="file" name="broadcast_img"/>
              		</td>
              </tr>
              
			  <tr><td align="right" width="150"> <lable class="colred">*</lable> 奖品图片：</td><td><input type="button" id="add_id" value="增加图片" onclick="addimg()"></td></tr>
			  <?php if($rs['image_path_url']):?>
					<?php foreach ($rs['image_path_url'] as $key => $val):?>
					<tr id="<?php echo $key;?>">
						<td align="right" width="150">&nbsp;</td>
						<td>
							<img src="<?php echo $val;?>"><input type="button" value="删除" onclick="delimg('<?php echo $rs['image_path'][$key];?>', '<?php echo $rs['id']?>','<?php echo $key?>')"/>
						</td>
			  		</tr>
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
	    url:'/admin/gift/delimg',// 跳转到 action  
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