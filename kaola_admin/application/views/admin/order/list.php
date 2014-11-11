<script type="text/javascript">
$(document).ready(function(){
	$("#order_id").focus(function(){
		$("#gift_id").val('');
		$("#phone").val('');
		$("#game_id").val('');
	});
	$("#gift_id").focus(function(){
		$("#order_id").val('');
		$("#phone").val('');
		$("#game_id").val('');
	});
	$("#phone").focus(function(){
		$("#order_id").val('');
		$("#gift_id").val('');
		$("#game_id").val('');
	});
	$("#game_id").focus(function(){
		$("#order_id").val('');
		$("#phone").val('');
		$("#gift_id").val('');
	});
})
</script>
<!--右侧-->
	<div class="sdk_right">
		<div class="sdk_rightnav">当前位置 订单管理  > 所有订单</div>
		<div class="sdk_righcon">
			<form action="" method="get">
			<div class="sdk_rightsearch">
				<span>订单号：<input type="text" class="sdk_zhucetext" name="order_id" id="order_id" style="width:80px" value="<?php echo $get['order_id']?>"/></span>
				<span>手机号：<input type="text" class="sdk_zhucetext" name="phone" id="phone" style="width:80px" value="<?php echo $get['phone']?>"/></span>
				<span>奖品ID：<input type="text" class="sdk_zhucetext" name="gift_id" id="gift_id" style="width:80px" value="<?php echo $get['gift_id']?>"/></span>
				<span>游戏ID：<input type="text" class="sdk_zhucetext" name="game_id" id="game_id" style="width:80px" value="<?php echo $get['game_id']?>"/></span>
				<input type="submit" name="" class="sdk_rsbtn" id="" value="查看" />
			</div>
			</form>
			<table cellspacing="0" cellpadding="0" border="0" width="100%" class="sdk_table">
				<tr>
					<th>订单编号</th>
					<th>验证码</th>
					<th>收货手机号码</th>
					<th>收货地址</th>
					<th>奖品ID</th>
					<th>游戏ID</th>
					<th>审核状态</th>
					<th>生产时间</th>
					<th>物流信息</th>
				</tr>
				<?php if($rs): ?>
				<?php foreach($rs as $key => $val):?>
				<tr>
					<td><?php echo $val['id']?></td>
					<td><?php echo $val['captcha']?></td>
					<td><?php  echo $val['address_id'] ? $addressinfo[$val['address_id']]['phone'] : '--';?></td>
					<td><?php echo $val['address_id'] ? $addressinfo[$val['address_id']]['address'] : '--'?></td>
					<td><?php echo $val['gift_id']?></td>
					<td><?php echo $val['game_id']?></td>
					<td><?php echo $order_status[$val['status']]?></td>
					<td><?php echo $val['order_time']?></td>
					<td>--</td>
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