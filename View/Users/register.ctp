<?= $this->Form->create('UserAdmin.Account', array('role'=>'form', 'class' => 'login-form')); ?>
	<div class="input-group">
		<span class="input-group-addon"><i class="fa fa-user"></i></span>
		<?= $this->Form->input('username', array(
			'label' => false,
			'div' => false,
			'class' => 'form-control',
			'type' => 'email',
			'placeholder' => 'Username'
		)); ?>
	</div>
	<div class="input-group">
		<span class="input-group-addon"><i class="fa fa-user"></i></span>
		<?= $this->Form->input('firstname', array(
			'label' => false,
			'div' => false,
			'class' => 'form-control',
			'type' => 'email',
			'placeholder' => 'Firstname'
		)); ?>
	</div>
	<div class="input-group">
		<span class="input-group-addon"><i class="fa fa-user"></i></span>
		<?= $this->Form->input('lastname', array(
			'label' => false,
			'div' => false,
			'class' => 'form-control',
			'type' => 'email',
			'placeholder' => 'Lastname'
		)); ?>
	</div>
	<div class="input-group">
		<span class="input-group-addon"><i class="fa fa-envelope-o"></i></span>
		<?= $this->Form->input('email', array(
			'label' => false,
			'div' => false,
			'class' => 'form-control',
			'type' => 'email',
			'placeholder' => 'john.doe@example.com'
		)); ?>
	</div>
	<div class="input-group">
		<span class="input-group-addon"><i class="fa fa-key"></i></span>
		<?= $this->Form->input('password', array(
			'label' => false,
			'div' => false,
			'type' => 'password',
			'class' => 'form-control',
			'placeholder' => 'mySup3rS3cr3tP4ssw0rd'
		)); ?>
	</div>
	<div class="input-group">
		<span class="input-group-addon"><i class="fa fa-key"></i></span>
		<?= $this->Form->input('password2', array(
			'label' => false,
			'div' => false,
			'type' => 'password',
			'class' => 'form-control',
			'placeholder' => 'mySup3rS3cr3tP4ssw0rd again for verification'
		)); ?>
	</div>
	<div id="remember-me-wrapper" class="remember-me-wrapper">
		<div class="row">
			<div class="col-xs-6">
				
			</div>
			<a href="<?= $this->Html->url('/users/forgot-password'); ?>" id="login-forget-link" class="col-xs-6">
				Forgot password?
			</a>
		</div>
	</div>
	<div class="row">
		<div class="col-xs-12">
			<a href="<?= $this->Html->url('/users/login'); ?>" class="btn btn-default col-xs-5"><?= __('Login'); ?></a>
			<button type="submit" class="btn btn-primary col-xs-5 col-xs-offset-2"><?= __('Register'); ?></button>
		</div>
	</div>
<?= $this->Form->end(); ?>
