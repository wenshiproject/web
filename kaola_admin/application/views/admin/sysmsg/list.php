<script type="text/javascript">
$(document).ready(function(){
	$("#user_id").focus(function(){
		$("#user_name").val('');
		$("#account_name").val('');
	});
	$("#user_name").focus(function(){
		$("#user_id").val('');
		$("#account_name").val('');
	});
	$("#account_name").focus(function(){
		$("#user_id").val('');
		$("#user_name").val('');
	});
})
</script>
<!--右侧-->
	<div class="sdk_right">
		<div class="sdk_rightnav">当前位置：系统消息-礼包  > 系统信息列表</div>
		<div class="sdk_righcon">
			<form action="" method="get">
			<div class="sdk_rightsearch">
				<span>关键字：<input type="text" class="sdk_zhucetext" name="name" id="name" style="width:80px" value="<?php echo $game_arr['name']?>"/></span>
				<input type="submit" name="" class="sdk_rsbtn" id="" value="查看" />
			</div>
			</form>
			<table cellspacing="0" cellpadding="0" border="0" width="100%" class="sdk_table">
				<tr>
					<th>ID</th>
					<th>图片</th>
					<th>标题</th>
					<th>消息简介</th>
					<th>发表时间</th>
					<th>管理</th>
				</tr>
				<?php if($rs): ?>
				<?php foreach($rs as $key => $val):?>
				<tr>
					<td><?php echo $val['id']?></td>
					<td><?php echo $val['name']?></td>
					<td><?php echo $val['key']?></td>
					<td><?php echo $val['gift_id']?></td>
					<td><?php echo "10";?></td>
					<td><?php echo "5"?></td>
					<td><?php echo "5";?></td>
					<td><?php echo $val['status'];?></td>
					<td><a href="/admin/game/edit?id=<?php echo $val['id'] ?>">编辑</a></td>
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