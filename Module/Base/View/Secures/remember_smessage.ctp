<div id="background-logo">
    <div id="fondologin">
        <?php if($msj == 1): ?>
            <div class="smessageLogin"><?php echo __("We have sent a message to your email with instructions to recover your password. Please make sure to check your spam folder"); ?></div>
        <?php elseif($msj == 2): ?>
            <div class="smessageLogin"><?php echo __("Data entered not registered in your system. Please check them and try again"); ?></div>
                <br />
                <br />
            <?php echo $this->Html->link(__('Back'), array('action' => 'remember')); ?>
        <?php elseif($msj == 3): ?>
            <div class="smessageLogin"><?php echo __("It has successfully changed the password"); ?></div>
                <br />
                <br />
            <?php echo $this->Html->link(__('Back'), array('action' => 'logout')); ?>
        <?php elseif($msj == 4): ?>
            <div class="smessageLogin"><?php echo __("You have been blocked for 24 hours"); ?></div>
                <br />
                <br />
        <?php endif; ?>
    </div>
</div>
<script>
window.setTimeout(function(){
	window.location = '../login';
},10000);	
</script>