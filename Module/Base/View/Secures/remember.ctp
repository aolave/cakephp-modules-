<div id="background-logo">
    <div class="rememberText"> 
    <?php echo __("Please enter the email you used when registering below. We will send you an email with instructions to reset your password"); ?>
    </div>
    <div id="fondologin">
        <?php echo $this->Form->create(); ?>
        <?php echo $this->Form->input('User.email', array('type' => 'text', 'size' => 46, 'autocomplete' => 'off', 'label'=>false, "before"=>"<label>". __("Enter your user name or email."). "</label>")); ?>
        <?php echo $this->Form->end(__('Send Email')); ?>
    </div>
</div>
<script>
    $("#UserRememberForm").find('input[type="submit"]').bind("click", function(){
        $(this).unbind("click");
    });
</script>