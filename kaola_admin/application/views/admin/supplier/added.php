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
		<div class="sdk_rightnav">当前位置：许愿清单  > 许愿列表</div>
		<div class="sdk_righcon">
			<form action="" method="get">
			<div class="sdk_rightsearch">
				<span>奖品名称：<input type="text" class="sdk_zhucetext" name="name" id="name" style="width:80px" value="<?php echo $serachs['name']?>"/></span>
				<span>奖品编码：<input type="text" class="sdk_zhucetext" name="code" id="code" style="width:80px" value="<?php echo $serachs['code']?>"/></span>
				<input type="submit" name="" class="sdk_rsbtn" id="" value="查看" />
			</div>
			</form>
			<table cellspacing="0" cellpadding="0" border="0" width="100%" class="sdk_table">
				<tr>
					<th>奖品图片</th>
					<th>名称</th>
					<th>编码</th>
					<th>游戏信息</th>
					<th>有效订单数</th>
					<th>管理</th>
					<th>上架时间</th>
					<th>收藏数</th>
				</tr>
				<?php if($rs): ?>
				<?php foreach($rs as $key => $val):?>
				<tr>
					<td><?php echo $val['id']?></td>
					<td><?php echo $val['image']?></td>
					<td><?php echo $val['title']?></td>
					<td><?php echo $val['content']?></td>
					<td><?php echo $val['wish_num']?></td>
					<td><?php echo $val['add_time']?></td>
					<td><a href="/admin/wish/edit?id=<?php echo $val['id'] ?>">编辑</a></td>
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