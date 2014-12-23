<?php

$user = $this->request->data['User'];

$this->Html->addCrumb(__('My account'), null);

if (false) {
	$disabled = ' data-toggle="tooltip" title="You can only edit your own account"';
	$style = 'default';
}
else {
	$disabled = '';
	$style = 'primary';
}

?><div class="widget">
	<div class="widget-content-white glossed">
		<div class="padded">
			<?php
			echo $this->Form->create('User', array(
				'role' => 'form',
				'class' => 'form-horizontal'
			));
			?>
			<h3 class="form-title form-title-first">
				<!-- <i class="icon-user"></i> -->
				<img src="<?= Me::gravatar(80); ?>&amp;d=mm" alt="<?= $user['firstname'].' '.$user['lastname']; ?>" class="avatar" style="margin-top: -6px; margin-right: 12px;" />
				<?= $user['firstname'].' '.$user['lastname']; ?>
			</h3>
			<div class="form-group">
				<label class="col-md-4 control-label">User name</label>
				<div class="col-md-8">
					<?php
					echo $this->Form->input('username', array(
						'label' => false,
						'class'=>'form-control',
						'placeholder'=>'joedoe3330',
						'autocomplete' => 'off',
						'readonly' => true,
						'required' => true
					));
					?>
				</div>
			</div>
			<div class="form-group">
				<label class="col-md-4 control-label">First Name</label>
				<div class="col-md-8">
					<?php
					echo $this->Form->input('firstname', array(
						'label' => false,
						'class'=>'form-control',
						'placeholder'=>'John',
						'required' => true
					));
					?>
				</div>
			</div>
			<div class="form-group">
				<label class="col-md-4 control-label">Last Name</label>
				<div class="col-md-8">
					<?php
					echo $this->Form->input('lastname', array(
						'label' => false,
						'class'=>'form-control',
						'placeholder'=>'Doe',
						'required' => true
					));
					?>
				</div>
			</div>
			<div class="form-group">
				<label class="col-md-4 control-label">Email</label>
				<div class="col-md-8">
					<?php
					echo $this->Form->input('email', array(
						'label' => false,
						'class'=>'form-control',
						'placeholder'=>'john.doe@example.com',
						'required' => true
					));
					?>
				</div>
			</div>
			<div class="form-group">
				<label class="col-md-4 control-label">Change Password</label>
				<div class="col-md-8">
					<?php
					echo $this->Form->input('password', array(
						'label' => false,
						'class'=>'form-control',
						'placeholder'=>'mySup3rS3cr3tP4ssw0rd',
						'value' => false,
						'autocomplete' => 'off'
					));
					?>
				</div>
			</div>
			<div class="form-group">
				<label class="col-md-4 control-label">Verify Password</label>
				<div class="col-md-8">
					<?php
					echo $this->Form->input('password2', array(
						'label' => false,
						'class'=>'form-control',
						'placeholder'=>'mySup3rS3cr3tP4ssw0rd',
						'type' => 'password',
						'autocomplete' => 'off'
					));
					?>
				</div>
			</div>
			<div class="form-group">
				<label class="col-md-4 control-label">Use dashboard as a home page, home will default to apps if disabled</label>
				<div class="col-md-8">
					<?php
					echo $this->Form->input('usehomepage', array(
						'label' => false,
						'class'=>'form-control',
						'autocomplete' => 'off'
					));
					?>
				</div>
			</div>
			<div class="form-group">
				<div class="col-md-offset-4 col-md-8">
					<a href="<?= $this->Html->url('/', true); ?>" class="btn btn-default">Cancel</a>
					<button type="submit" name="save" class="btn btn-<?= $style; ?> pull-right color-tooltip"<?= $disabled; ?>>Save</button>
				</div>
			</div>
			<?= $this->Form->end(); ?>
		</div>
	</div>
</div>