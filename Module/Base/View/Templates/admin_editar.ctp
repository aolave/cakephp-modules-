<?php echo $this->Utilities->linkRegresar( array('controller' => 'templates', 'action' => 'index') ); ?>
<?php echo $this->Html->script('ckeditor/ckeditor.js'); ?>
<?php echo $this->Form->Create('Template', array('inputDefaults' => array('label' => false))); ?>
<div class="info_general">
    <div class="section">        
        <div class="title_section"><?php __('Basic info'); ?></div>
    </div>
    <div class="info">
        <table class="table_page">
            <tr>
                <th class="label"><?php echo __('Module'); ?></th>
                <td class="data"><?php echo $this->Form->input('modulo'); ?></td>
            </tr>
            <tr>
                <th class="label"><?php echo __('Name'); ?></th>
                <td class="data"><?php echo $this->Form->input('name'); ?></td>
            </tr>
            <tr>
                <th class="label"><?php echo __('Subject'); ?></th>
                <td class="data"><?php echo $this->Form->input('asunto', array('style' => 'width:500px')); ?></td>
            </tr>
            <tr>
                <th class="label"><?php echo __('Description'); ?></th>
                <td class="data"><?php echo $this->Form->input('description'); ?></td>
            </tr>
            <!--
            <tr>
                <th class="label"><?php echo __('Title'); ?></th>
                <td class="data"><?php echo $this->Form->input('header'); ?></td>
            </tr>
            -->
            <tr>
                <th class="label"><?php echo __('Message'); ?></th>
                <td class="data"><?php echo $this->Form->input('smessage'); ?></td>
            </tr>
        </table>
    </div>
</div>
<?php echo $this->Form->input('id'); ?>
<?php echo $this->Form->end('Aceptar'); ?>
<script>
    $(document).ready(function() {
        CKEDITOR.replace( 'TemplateSmessage', {toolbar : 'Full'});
        CKEDITOR.replace( 'TemplateDescription', {toolbar : 'Full'});
    });
</script>