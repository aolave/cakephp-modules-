<?php
$this->Html->script('Registrant/save-form', array('block' => 'scriptBottom')); ?>
<?php $this->Html->script('Registrant/register', array('block' => 'scriptBottom')); ?>
<?php $this->Html->css('colorbox', null, array('inline' => false));?>
<?php echo $this->Html->meta('icon'); ?>
<div id="background-logo" class="home-login users form-new">
    <div id="fondologin">
        <?php $label = 'Temporary'; ?>
        <?php if($msj == 1): ?>
            <?php echo $this->Utilities->smessages('contrasena'); ?>
        <script>
            $("#msj").dialog('open').html("For your safety, it is time to change your password. then type a new one.");
        </script>
            <?php $label = 'Current'; ?>
        <?php endif; ?>

        <?php echo $this->Form->create('User'/*, array('url' => array('controller' => 'secures', 'action' => 'recover', $pass))*/);?>

        <?php 
            if($passTemp){
                  echo $this->Form->hidden('passwd_tmp', array('label'=> false, 'value' => $passTemp, 'type' => 'password'));
            }else{
                  echo $this->Form->input('passwd_tmp',array('label'=> false, 'placeholder' => __($label . " password"), 'type' => 'password', 'autocomplete' => 'off'));
            }
        ?>

            <?php echo $this->Form->input('password',array('label'=> false, 'placeholder'=> __("New password"), 'autocomplete' => 'off'));?>
            <?php echo $this->Form->input('password2',array('label'=> false, 'placeholder'=> __("Confirm password") , 'type' => 'password', 'autocomplete' => 'off'));?>

        <?php echo $this->Form->end( __("Reset password") );?>

        <div id="messagesErros">  </div> 
    </div>
</div>

