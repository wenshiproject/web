<!--右侧-->
	<div class="sdk_right">
		<div class="sdk_rightnav">当前位置：开发商管理  > 未审核开发商</div>
		<div class="sdk_righcon">
			<form action="" method="get">
			<div class="sdk_rightsearch">
				<span>开发商名称：<input type="text" class="sdk_zhucetext" name="name" id="name" style="width:80px" value="<?php echo $search['name']?>"/></span>
				<input type="submit" name="" class="sdk_rsbtn" id="" value="查看" />
			</div>
			</form>
			<table cellspacing="0" cellpadding="0" border="0" width="100%" class="sdk_table">
				<tr>
					<th>名称</th>
					<th>身份</th>
					<th>联系地址</th>
					<th>注册邮箱</th>
					<th>联系QQ</th>
					<th>手机号码</th>
					<th>联系人</th>
					<th>营业执照</th>
					<th>操作</th>
				</tr>
				<?php if($rs): ?>
				<?php foreach($rs as $key => $val):?>
				<tr>
					<td><?php echo $val['name']?></td>
					<td><?php echo $identity[$val['identity']]?></td>
					<td><?php echo $val['address']?></td>
					<td><?php echo $val['email']?></td>
					<td><?php echo $val['qq']?></td>
					<td><?php echo $val['phone']?></td>
					<td><?php echo $val['contact']?></td>
					<td><?php if($val['license_image']):?>
						<img src="<?php echo $val['license_image']?>" width="200px">
						<?php else:?>
						/
						<?php endif;?>
					</td>
					<td>
					<a href="/admin/company/edit?id=<?php echo $val['id'] ?>">编辑</a><br>
					<a href="javascript:void(0);" onclick="op('<?php echo $val['id']?>','del')">删除</a><br>
					<a href="javascript:void(0);" onclick="op('<?php echo $val['id']?>','check')">通过审核</a><br>
					</td>
				</tr>
				<?php endforeach;?>
				<?php endif;?>
			</table>
			<table width="100%">
			<tr align="center">
			<td width="16%" align="center" valign="top">总共有 <b><?php echo $total;?></b> 条数据</td>
			<td align="left" valign="top"><?php echo $pageview;?>&nbsp;</td>
			</tr>
			</table>
			</div>
		</div>
		<div id="code_background"></div>
<!--右侧-->
<script>
function op(id,op){
	$.ajax({
	    url:'/admin/company/op',// 跳转到 action  
	    data:{
	        id : id,
	        op : op
	    },
	    type:'POST',    
	    cache:false,    
	    dataType:'json',    
	    success:function(data){   
	        if(data.msg == 1){
		        window.location.reload();
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
</script>