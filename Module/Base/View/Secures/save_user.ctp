<?php if(!isset($exito)): ?>
    <?php echo $this->Form->create('User');?>
    <?php
    		echo $this->Form->input('id');
            
            if(isset($groups))
            {
                echo $this->Form->input('group_id', array('label' => __('Group')));
            }
            else
            {
                echo $this->Utilities->field_hidden(__('Grupo'), 'User.group_id', 'Group.name');
            }
            
    		echo $this->Form->input('username', array('label' => __('User')));
            echo $this->Form->input('name', array('label' => __('Name')));
            echo $this->Form->input('estado', array('label' => __('Active'), 'checked' => true));
    		
            if( !isset($this->data['User']['id']) || $this->data['User']['id'] == '' )
            {
                echo $this->Form->input('password', array('label' => __('Password')));
                echo $this->Form->input('password2', array('label' => __('Confirm password'), 'type' => 'password'));
            }
            
    		echo $this->Form->input('email', array('label' => __('Email')));
    	?>
    <?php echo $this->Utilities->ajaxSubmit(ACCEPT, array('update' => '#modalWindow', 'beforeSend' => "return validateForm(event)")); ?>
    <?php echo $this->Form->end();?>
<?php else: ?>
    <?php echo $this->Html->scriptBlock('hideDialog(); ReloadThisPage();'); ?>
<?php endif; ?>