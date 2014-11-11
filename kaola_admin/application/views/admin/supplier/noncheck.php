<script type="text/javascript">
$(document).ready(function(){
	$("#name").focus(function(){
		$("#code").val('');
	});
	$("#code").focus(function(){
		$("#name").val('');
	});
})
</script>
<!--右侧-->
	<div class="sdk_right">
		<div class="sdk_rightnav">当前位置 供应商管理  > 未审核供应商</div>
		<div class="sdk_righcon">
			<form action="" method="get">
			<div class="sdk_rightsearch">
				<span>供应商名称：<input type="text" class="sdk_zhucetext" name="name" id="name" style="width:80px" value="<?php echo $serachs['name']?>"/></span>
				<input type="submit" name="" class="sdk_rsbtn" id="" value="查看" />
			</div>
			</form>
			<table cellspacing="0" cellpadding="0" border="0" width="100%" class="sdk_table">
				<tr>
					<th>供应商名称</th>
					<th>地址</th>
					<th>注册邮箱</th>
					<th>手机号码</th>
					<th>联系人</th>
					<th>联系QQ</th>
					<th>操作</th>
				</tr>
				<?php if($rs): ?>
				<?php foreach($rs as $key => $val):?>
				<tr>
					<td><?php echo $val['name']?></td>
					<td><?php echo $val['address']?></td>
					<td><?php echo $val['email']?></td>
					<td><?php echo $val['phone']?></td>
					<td><?php echo $val['contact']?></td>
					<td><?php echo $val['qq']?></td>
					<td><a href="/admin/supplier/edit?id=<?php echo $val['id'] ?>">编辑</a> | <a href="/admin/supplier/delete?id=<?php echo $val['id'] ?>">删除</a> | <a href="/admin/supplier/check?id=<?php echo $val['id'] ?>">通过审核</a></td>
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