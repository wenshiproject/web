<!--右侧-->
	<div class="sdk_right">
		<div class="sdk_rightnav">当前位置：玩家管理  > 玩家列表</div>
		<div class="sdk_righcon">
			<form action="" method="get">
			<div class="sdk_rightsearch">
				<span>电话号码：<input type="text" class="sdk_zhucetext" name="phone" id="name" style="width:80px" value="<?php echo $game_arr['name']?>"/></span>
				<input type="submit" name="" class="sdk_rsbtn" id="" value="查看" />
			</div>
			</form>
			<table cellspacing="0" cellpadding="0" border="0" width="100%" class="sdk_table">
				<tr>
					<th>玩家ID</th>
					<th>玩家号码</th>
					<th>注册时间</th>
					<th>最新登录时间</th>
					<th>管理</th>
				</tr>
				<?php if($rs): ?>
				<?php foreach($rs as $key => $val):?>
				<tr>
					<td><?php echo $val['user_id']?></td>
					<td><?php echo $val['phone']?></td>
					<td><?php echo $val['reg_time']?></td>
					<td><?php echo $val['last_time']?></td>
					<td><a href="/admin/usermg/editpw?id=<?php echo $val['user_id'] ?>">修改密码</a></td>
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