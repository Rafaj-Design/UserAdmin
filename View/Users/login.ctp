<?php /* echo $this->Form->create('UserAdmin.Account', array('role'=>'form')); ?>
	<h3 class="form-title form-title-first"><i class="icon-lock"></i> <?= __('Login'); ?> </h3>
	<div class="form-group">
		<label><?= __('Email'); ?></label>
		
	</div>
	<div class="form-group">
		<label><?= __('Password'); ?></label>
		
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
<?php echo $this->Form->end(); //*/ ?>


<?php echo $this->Form->create('UserAdmin.Account', array('role'=>'form', 'class' => 'login-form')); ?>
	<div class="input-group">
		<span class="input-group-addon"><i class="fa fa-user"></i></span>
		<?= $this->Form->input('email', array(
			'label' => false,
			'div' => false,
			'class' => 'form-control',
			'type' => 'email',
			'placeholder' => 'john.doe@example.com',
			'value' => 'ondrej.rafaj@gmail.com'
		)); ?>
	</div>
	<div class="input-group">
		<span class="input-group-addon"><i class="fa fa-key"></i></span>
		<?= $this->Form->input('password', array(
			'label' => false,
			'div' => false,
			'type' => 'password',
			'class' => 'form-control',
			'placeholder' => 'mySup3rS3cr3tP4ssw0rd',
			'value' => 'exploited3330'
		)); ?>
	</div>
	<div id="remember-me-wrapper" class="remember-me-wrapper">
		<div class="row">
			<div class="col-xs-6">
				<div class="checkbox-nice">
					<input type="checkbox" id="remember-me" checked="checked" />
					<label for="remember-me">
						Remember me
					</label>
				</div>
			</div>
			<a href="<?= $this->Html->url('/'); ?>forgot-password-full.html" id="login-forget-link" class="col-xs-6">
				Forgot password?
			</a>
		</div>
	</div>
	<div class="row">
		<div class="col-xs-12">
			<button type="submit" class="btn btn-primary col-xs-12"><?= __('Login'); ?></button>
		</div>
	</div>
<?php echo $this->Form->end(); ?>
