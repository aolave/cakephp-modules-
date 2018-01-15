<div id="background-logo">
    <div id="fondologin">
        <?php
            echo $this->Form->create('User');
				echo $this->Form->input('username', array('label' => '', 'autocomplete' => 'off', 'placeholder' => 'Email', 'div' => array('id' => 'txt_user')));
				echo $this->Form->input('password',array('label'=>"", 'autocomplete' => 'off', 'placeholder' => 'Password', 'div' => array('id' => 'txt_password'), "after"=> "&nbsp;" ));
				echo ( CAPTCHA ? $this->Captcha->input() : "" );
				
				$buttons = "";
				$buttons .= $this->Utilities->submit_ajax(__('Sign in'), 'validateForm', array('div' => false));
				//$buttons .= $this->Html->link('Register', array('controller' => 'registrants', 'action' => 'register'), array('id' => 'register-link'));
				
				echo $this->Html->div('buttons', $buttons);
            echo $this->Form->end();
            
        ?>
    </div>
    <?php 
        echo $this->Html->link(__("forgot your password"), array('controller' => 'secures', "action"=>"remember"), array("class"=>"remember_passwd"))
    ?>
    <br><br>
    <?php 
        $email = "amikol@gmail.com";
        $mailto = "<a href='mailto:$email'> " .__("here") ." </a>";
        $contactus = __("Please email us at") ." ". $mailto ." ". __("if you're having problems with your login");
        echo $this->Html->div('', $contactus, array('id' => 'contactus')); 
    ?>
