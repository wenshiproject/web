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
		<div class="sdk_rightnav">当前位置：奖品管理  > 下架奖品</div>
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
					<th>奖品名称</th>
					<th>奖品编码</th>
					<th>游戏信息</th>
					<th>奖品数量</th>
					<th>有效订单数</th>
					<th>状态</th>
					<th>下架时间</th>
					<th>收藏数</th>
				</tr>
				<?php if($rs): ?>
				<?php foreach($rs as $key => $val):?>
				<tr>
					<td>
						<?php if($val['image_path']):?>
						<img src="<?php echo $val['image_path']?>" width="200px">
						<?php else:?>
						/
						<?php endif;?>	
					</td>
					<td><?php echo $val['name']?></td>
					<td><?php echo $val['code']?></td>
					<td><?php echo $val['game_id']?></td>
					<td><?php echo $val['number']?></td>
					<td><?php echo $val['order_num']?></td>
					<td>下架</td>
					<td><?php echo $val['down_time']?></td>
					<td><?php echo $val['favorites']?></td>
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