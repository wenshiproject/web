<p class="pagination">

	<?php  if ($first_page !== FALSE): ?>
		<a href="<?php echo HTML::chars($page->url($first_page)) ?>" rel="first"><?php echo __('First') ?></a>
	<?php else: ?>
		<a href="javascript:void(0);" ><?php echo __('First') ?></a>
	<?php endif ?>

	<?php if ($previous_page !== FALSE): ?>
		<a href="<?php echo HTML::chars($page->url($previous_page)) ?>" rel="prev"><?php echo __('Previous') ?></a>
	<?php else: ?>
		<a href="javascript:void(0);" ><?php echo __('Previous') ?></a>
	<?php endif ?>

	<?php
	$maxpage = 5;
	$half = (int)($maxpage/2);
	if($total_pages > $maxpage && $current_page <= $half){
		$start = 1;
		$end = $maxpage;
	}elseif($total_pages > $maxpage && $current_page > $half && ($current_page + $half) < $total_pages){
		$start = $current_page - $half;
		$end = $current_page + $half;
	}elseif($total_pages > $maxpage && $current_page > $half && ($current_page + $half) >= $total_pages){
		$start = $total_pages - $maxpage + 1;
		$end = $total_pages;
	}else{
		$start = 1;
		$end = $total_pages;
	}
	for ($i = $start; $i <= $end; $i++): ?>

		<?php if ($i == $current_page): ?>
			<a href="javascript:void(0);" ><strong><?php echo $i ?></strong></a>
		<?php else: ?>
			<a href="<?php echo HTML::chars($page->url($i)) ?>"><?php echo $i ?></a>
		<?php endif ?>

	<?php endfor;?>
    	

	<?php if ($next_page !== FALSE): ?>
		<a href="<?php echo HTML::chars($page->url($next_page)) ?>" rel="next"><?php echo __('Next') ?></a>
	<?php else: ?>
		<a href="javascript:void(0);" ><?php echo __('Next') ?></a>
	<?php endif ?>

	<?php if ($last_page !== FALSE): ?>
		<a href="<?php echo HTML::chars($page->url($last_page)) ?>" rel="last"><?php echo __('Last') ?></a>
	<?php else: ?>
		<a href="javascript:void(0);" ><?php echo __('Last') ?></a>
	<?php endif ?>

</p><!-- .pagination -->