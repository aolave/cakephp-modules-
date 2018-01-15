<?php if(!isset($exito)): ?>
    <?php echo $this->Form->create('User');?>
    <?php
    		echo $this->Form->input('id');
            
            echo $this->Utilities->field_hidden(__('Group'), 'User.group_id', 'Group.name');            
            echo $this->Utilities->field_hidden(__('User'), $this->data['User']['username'], 'User.username');
            
            echo $this->Form->input('password', array('label' => __('Password')));
            echo $this->Form->input('password2', array('label' => __('Confirm password'), 'type' => 'password'));
    	?>
    <?php echo $this->Utilities->ajaxSubmit(ACCEPT, array('update' => '#modalWindow', 'beforeSend' => "return validateForm(event)")); ?>
    <?php echo $this->Form->end();?>
<?php else: ?>
    <?php echo $this->Html->scriptBlock('hideDialog(); ReloadThisPage();'); ?>
<?php endif; ?>