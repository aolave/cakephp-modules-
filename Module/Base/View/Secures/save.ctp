<?php if(!isset($exito)): ?>
    <?php echo $this->Form->create('User');?>
    <?php
    		echo $this->Form->input('User.id');
            
            if(isset($groups))
            {
                echo $this->Form->input('User.group_id', array('label' => 'Grupo'));
            }
            else
            {
                echo $this->Utilities->field_hidden('Grupo', 'User.group_id', 'Group.name');
            }
            
    	    //echo $this->Form->input('username', array('label' => 'User'));
            //echo $this->Form->input('name', array('label' => 'Name'));
            echo $this->Form->input('User.estado', array('label' => 'Active', 'checked' => true));
    		
        
	
		echo $this->Form->input('Registrant.first_name', array('label'=> '', 'placeholder' => __('First Name *')) );
		echo $this->Form->input('Registrant.last_name', array('label'=> '', 'placeholder' => __('Last Name *')));
		echo $this->Form->input('Registrant.email' , array('label'=> '', 'placeholder' => __('Email *')));
		
		
		    if( !isset($this->data['User']['id']) || $this->data['User']['id'] == '' )
            {
                echo $this->Form->input('User.password', array('label' => 'Password'));
                echo $this->Form->input('password2', array('label' => 'Confirm password', 'type' => 'password'));
            }
			
		echo $this->Form->input('Registrant.gender_id', array('options' => $genders, 'empty' => EMPTY_SELECT));
		echo $this->Form->input('Registrant.birthdate');
		echo $this->Form->input('Registrant.affiliate');
		echo $this->Form->input('Registrant_division.division_id', array('options' => $division_reg, 'empty' => EMPTY_SELECT));
		echo $this->Form->input('Registrant.register_code');
		echo $this->Form->input('0_t-shirt');	
			
		echo $this->Form->input('Registrant.address', array('class'=>'input-full'));
        echo $this->Form->input('Registrant.address2', array('class'=>'input-full'));
			
		echo $this->Html->div('info', __('City/State/Zip'));
        echo $this->Form->input('Registrant.city', array('label' => ' '));
        echo $this->Form->input('Registrant.state_id', array('label' => ' ', 'options' => $states, 'empty' => EMPTY_SELECT, 'id' => 'input-state'));
    	echo $this->Form->input('Registrant.zip' , array('label' => ' '));	
			
    	?>
    <?php echo $this->Utilities->ajaxSubmit(ACCEPT, array('update' => '#modalWindow', 'beforeSend' => "return validateForm(event)")); ?>
    <?php echo $this->Form->end();?>
<?php else: ?>
    <?php echo $this->Html->scriptBlock('hideDialog(); ReloadThisPage();'); ?>
<?php endif; ?>