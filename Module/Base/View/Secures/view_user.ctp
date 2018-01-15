<div class="section">
    <div class="title">
        <span class="title_label"><?php echo __('User information'); ?></span>
    </div>
    <div class="info">
        <?php echo $this->Utilities->fixed_field(__('Group'), $info['Group']['name']); ?>
        <?php echo $this->Utilities->fixed_field(__('User'), $info['User']['username']); ?>
        <?php echo $this->Utilities->fixed_field(__('Name'), $info['User']['name']); ?>
        <?php echo $this->Utilities->fixed_field(__('Email'), $info['User']['email']); ?>
    </div>
</div>