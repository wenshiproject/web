<!--右侧-->
	<div class="sdk_right">
		<div class="sdk_rightnav">当前位置：许愿清单  > 许愿列表</div>
		<div class="sdk_righcon">
			<form action="" method="get">
			<div class="sdk_rightsearch">
				<span>名称：<input type="text" class="sdk_zhucetext" name="name" id="name" style="width:80px" value="<?php echo $game_arr['name']?>"/></span>
				<span>ID：<input type="text" class="sdk_zhucetext" name="id" id="id" style="width:80px" value="<?php echo $game_arr['id']?>"/></span>
				<input type="submit" name="" class="sdk_rsbtn" id="" value="查看" />
			</div>
			</form>
			<table cellspacing="0" cellpadding="0" border="0" width="100%" class="sdk_table">
				<tr>
					<th>ID</th>
					<th>产品图片</th>
					<th>标题</th>
					<th>简介</th>
					<th>许愿数量</th>
					<th>发表时间</th>
					<th>管理</th>
				</tr>
				<?php if($rs): ?>
				<?php foreach($rs as $key => $val):?>
				<tr>
					<td><?php echo $val['id']?></td>
					<td>
						<?php if($val['image']):?>
						<img src="<?php echo $val['image']?>" width="200px">
						<?php else:?>
						/
						<?php endif;?>	
					</td>
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