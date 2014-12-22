<?php echo $this->Form->create('User', array('role'=>'form')); ?>
	<h3 class="form-title form-title-first"><i class="icon-lock"></i> <?= __('Login'); ?> </h3>
	<div class="form-group">
		<label><?= __('Email'); ?></label>
		<?= $this->Form->input('username', array(
			'label' => false,
			'class' => 'form-control',
			'placeholder' => 'john.doe@example.com',
			'value' => 'admin@example.com'
		)); ?>
	</div>
	<div class="form-group">
		<label><?= __('Password'); ?></label>
		<?= $this->Form->input('password', array(
			'label' => false,
			'class' => 'form-control',
			'placeholder' => 'mySup3rS3cr3tP4ssw0rd',
			'value' => 'password123'
		)); ?>
	</div>
	<!--<div class="form-group">
		<div class="checkbox">
			<label>
				<?= $this->Form->checkbox('remember_me'); ?> Remember me for 1 day
			</label>
		</div>
	</div>-->
	<div class="form-group">
		<button type="submit" class="btn btn-primary"><?= __('Sign in'); ?></button>
		<?php if (!isset($disableRegistration) || !$disableRegistration) { ?>
		<a href="<?= $this->Html->url('/users/register', true); ?>" class="btn pull-right"><?= __('Register'); ?></a>
		<?php } ?>
	</div>
 	<div class="form-group">
		<a href="<?= $this->Html->url('/users/resetpasswd', true); ?>" class="btn btn-default btn-xs"<?= ((isset($disableReset) && $disableReset) ? ' disabled="disabled"' : ''); ?>><?= __('Forgotten password?'); ?></a>
	</div>
<?php echo $this->Form->end(); ?>
