<?= $this->Form->create('Account', array('role' => 'form')); ?>
	<div class="form-group">
		<label class="control-label">User name</label>
		<?php
		echo $this->Form->input('username', array(
			'label' => false,
			'div' => false,
			'class'=>'form-control',
			'placeholder'=>'joedoe3330',
			'autocomplete' => 'off',
			'readonly' => true,
			'required' => true
		));
		?>
	</div>
	<div class="form-group">
		<label class="control-label">First Name</label>
		<?php
		echo $this->Form->input('firstname', array(
			'label' => false,
			'div' => false,
			'class'=>'form-control',
			'placeholder'=>'John',
			'required' => true
		));
		?>
	</div>
	<div class="form-group">
		<label class="control-label">Last Name</label>
		<?php
		echo $this->Form->input('lastname', array(
			'label' => false,
			'div' => false,
			'class'=>'form-control',
			'placeholder'=>'Doe',
			'required' => true
		));
		?>
	</div>
	<div class="form-group">
		<label class="control-label">Email</label>
		<?php
		echo $this->Form->input('email', array(
			'label' => false,
			'div' => false,
			'class'=>'form-control',
			'placeholder'=>'john.doe@example.com',
			'required' => true
		));
		?>
	</div>
	<div class="form-group">
		<label class="control-label">Change Password</label>
		<?php
		echo $this->Form->input('password', array(
			'label' => false,
			'div' => false,
			'class'=>'form-control',
			'placeholder'=>'mySup3rS3cr3tP4ssw0rd',
			'value' => false,
			'autocomplete' => 'off'
		));
		?>
	</div>
	<div class="form-group">
		<label class="control-label">Verify Password</label>
		<?php
		echo $this->Form->input('password2', array(
			'label' => false,
			'div' => false,
			'class'=>'form-control',
			'placeholder'=>'mySup3rS3cr3tP4ssw0rd',
			'type' => 'password',
			'autocomplete' => 'off'
		));
		?>
	</div>
	<div class="form-group">
		<a href="<?= $this->Html->url('/', true); ?>" class="btn btn-default">Cancel</a>
		<button type="submit" class="btn btn-primary pull-right">Save</button>
	</div>
<?= $this->Form->end(); ?>
