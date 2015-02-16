<?= $this->Form->create('Team');?>
<div class="form-group">
	<label for="formTeamName">Name</label>
	<?php
	echo $this->Form->input('name', array(
		'label' => false,
		'div' => false,
		'id' => 'formTeamName',
		'class' => 'form-control',
		'placeholder' => 'Team name'
	));
	?>
</div>
<div class="form-group">
	<?= $this->Form->input('id'); ?>
	<button type="submit" name="save">Save</button>
</div>
<?= $this->Form->end(); ?>
