<table class="table">
	<thead>
		<tr>
			<th><?= $this->Paginator->sort('name', 'Name', array('direction' => 'desc')); ?></th>
			<th>Role</th>
			<th>&nbsp;</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach ($teams as $team) { ?>
		<tr>
			<td>
				<?= h($team['Team']['name']); ?>
			</td>
			<td class="text-center" style="width: 5%;">
				<span class="label label-success">Admin</span>
			</td>
			<td style="width: 10%;">
				<a href="<?= $this->Html->url(array('plugin' => null, 'controller' => 'users', 'action' => 'delete', $team['Team']['id'], $team['Team']['identifier'])); ?>" onclick="return confirm('Are you sure you want to unlink from' + '<?= h($team['Team']['name']); ?>')" class="table-link danger pull-right">
					<span class="fa-stack">
						<i class="fa fa-square fa-stack-2x"></i>
						<i class="fa fa-trash-o fa-stack-1x fa-inverse"></i>
					</span>
				</a>
				<a href="<?= $this->Html->url(array('plugin' => null, 'controller' => 'users', 'action' => 'edit', $team['Team']['id'], $team['Team']['identifier'])); ?>" class="table-link pull-right">
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

<ul class="pagination pull-right">
<?php
echo $this->Paginator->prev('<i class="fa fa-chevron-left"></i>', array('escape' => false, 'tag'=>'li'), null, array('class' => 'prev disabled', 'escape' => false, 'tag'=>'li'));

echo $this->Paginator->numbers(array('separator' => '', 'tag'=>'li'));

echo $this->Paginator->next('<i class="fa fa-chevron-right"></i>', array('escape' => false, 'tag'=>'li'), null, array('class' => 'next disabled', 'escape' => false, 'tag'=>'li'));
?>
</ul>
