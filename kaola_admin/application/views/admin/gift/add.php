<!--右侧-->
	<div class="sdk_right">
		<div class="sdk_rightnav">当前位置：奖品管理 > 添加奖品</div>
		<div class="sdk_righcon">
			<form action="" method="post" enctype="multipart/form-data" class="needValidate">
			<table cellspacing="0" cellpadding="0" border="0" width="100%" class="sdk_table1">
              	<tr>
              		<td align="right" width="150"><lable class="colred">*</lable>奖品名称：</td><td><input type="text" class="sdk_zhucetext" size="15" name="name" value="" class="{required:true,messages:{required:'不能为空'}}"/>
              		</td>
              </tr>
               <tr>
              		<td align="right" width="150"><lable class="colred">*</lable>奖品编码：</td><td><input type="text" class="sdk_zhucetext" size="15" name="code" value="" class="{required:true,messages:{required:'不能为空'}}" />
              		</td>
              </tr>
              <tr>
              		<td align="right" width="150"><lable class="colred">*</lable>奖品数量：</td><td><input type="text" class="sdk_zhucetext" size="15" name="num" value="" class="{required:true,messages:{required:'不能为空'}}" />
              		</td>
              </tr>
              <tr>
              		<td align="right" width="150"><lable class="colred">*</lable>奖品价格：</td><td><input type="text" class="sdk_zhucetext" size="15" name="price" value="" class="{required:true,messages:{required:'不能为空'}}" />
              		</td>
              </tr>
               <tr>
              		<td align="right" width="150"><lable class="colred">*</lable>奖品介绍：</td><td><input type="text" class="sdk_zhucetext" name="desc" value="" class="{required:true,messages:{required:'不能为空'}}"/>
              		</td>
              </tr>
			  <tr>
              		<td align="right" width="150"><lable class="colred">*</lable>游戏ID：</td><td><input type="text" class="sdk_zhucetext" name="game_id" value="" class="{required:true,messages:{required:'不能为空'}}"/>
              		</td>
              </tr>
<!--              <tr>-->
<!--              		<td align="right" width="150"><lable class="colred">*</lable>游戏名称：</td><td><input type="text" class="sdk_zhucetext" name="game_name" value="" class="{required:true,messages:{required:'不能为空'}}"/>-->
<!--              		</td>-->
<!--              </tr>-->
              <tr>
              		<td align="right" width="150"><lable class="colred">*</lable>获奖条件：</td><td><input type="text" class="sdk_zhucetext" name="game_cond" value="" class="{required:true,messages:{required:'不能为空'}}"/>
              		</td>
              </tr>
              <?php if($suppliers): ?>
              <tr>
              		<td align="right" width="150"><lable class="colred">*</lable>选择供应商：</td><td>
              			<select name="supplier_id">
              				<?php foreach($suppliers as $key => $val): ?>
              				<option vaule=<?php echo $val['id']?>><?php echo $val['name']?></option>
              				<?php endforeach;?>
              			</select>
              		</td>
              </tr>
              <?php endif;?>
              <tr>
              	<td align="right" width="150"><lable class="colred">*</lable>宣传图：</td>
              	<td>
              		<input type="file" name="broadcast_img"/>
              	</td>
              </tr>
              <tr>
				<td align="right" width="150"> <lable class="colred">*</lable> 奖品图片：</td> <td><input type="button" id="add_id" value="增加图片" onclick="addimg()"></td>
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