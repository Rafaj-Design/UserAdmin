<?php

?><div class="main-box clearfix">
	<header class="main-box-header clearfix">
		<div class="filter-block pull-left">			
			<form method="get" action="" class="form-group pull-left">
				<input type="text" name="search" class="form-control" placeholder="Search..." value="<?= $search; ?>" />
				<i class="fa fa-search search-icon"></i>
			</rorm>
		</div>
		<div class="filter-block pull-right">			
			<a href="<?= $this->Html->url(array('plugin' => null, 'controller' => 'users', 'action' => 'manage')); ?>" class="btn btn-primary pull-right">
				<i class="fa fa-plus-circle fa-lg"></i> Manage users
			</a>
		</div>
	</header>
	
	<div class="main-box-body clearfix">
		<div class="table-responsive">
			<table class="table">
				<thead>
					<tr>
						<th>&nbsp;</th>
						<th><?= $this->Paginator->sort('lastname', '<span>Name</span>', array('direction' => 'desc', 'escape' => false)); ?></th>
						<th class="text-center"><?= $this->Paginator->sort('lastname', '<span>Status</span>', array('direction' => 'desc', 'escape' => false)); ?></th>
						<th>&nbsp;</th>
					</tr>
				</thead>
				<tbody>
					<?php foreach ($accounts as $account) { ?>
					<tr>
						<td style="width: 5%;">
							<img src="http://www.fuerteint.com/img/who/who-ondrej.jpg" class="img-circle" alt="" width="44" />
						</td>
						<td>
							<?= h($account['Account']['lastname']); ?>, <?= h($account['Account']['firstname']); ?>
						</td>
						<td class="text-center" style="width: 5%;">
							<span class="label label-success">Active</span>
						</td>
						<td style="width: 10%;">
							<a href="<?= $this->Html->url(array('plugin' => null, 'controller' => 'users', 'action' => 'delete', $account['Account']['id'], $account['Account']['username'])); ?>" onclick="return confirm('Are you sure you want to unlink ' + '<?= h($account['Account']['firstname']); ?> <?= h($account['Account']['lastname']); ?>')" class="table-link danger pull-right">
								<span class="fa-stack">
									<i class="fa fa-square fa-stack-2x"></i>
									<i class="fa fa-trash-o fa-stack-1x fa-inverse"></i>
								</span>
							</a>
							<a href="<?= $this->Html->url(array('plugin' => null, 'controller' => 'users', 'action' => 'edit', $account['Account']['id'], $account['Account']['username'])); ?>" class="table-link pull-right">
								<span class="fa-stack">
									<i class="fa fa-square fa-stack-2x"></i>
									<i class="fa fa-pencil fa-stack-1x fa-inverse"></i>
								</span>
							</a>
						</td>
					</tr>
					<?php } ?>
				</tbody>
			</table>
		</div>
		
		<ul class="pagination pull-right">
		<?php
		echo $this->Paginator->prev('<i class="fa fa-chevron-left"></i>', array('escape' => false, 'tag'=>'li'), null, array('class' => 'prev disabled', 'escape' => false, 'tag'=>'li'));
		
		echo $this->Paginator->numbers(array('separator' => '', 'tag'=>'li'));
		
		echo $this->Paginator->next('<i class="fa fa-chevron-right"></i>', array('escape' => false, 'tag'=>'li'), null, array('class' => 'next disabled', 'escape' => false, 'tag'=>'li'));
		?>
		</ul>
	</div>
</div>