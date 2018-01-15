<?php echo $this->Html->script('ckeditor/ckeditor.js'); ?>
<?php echo $this->Form->Create('Smessage', array('inputDefaults' => array('label' => false))); ?>

<div class="info_general">
    <div class="section">        
        <div class="title_section"><?php __('Información'); ?></div>
    </div>
    <div class="info">
        <table class="table_page">
            <tr>
                <th class="label"><?php echo __('Name'); ?></th>
                <td class="data"><?php echo $this->Form->input('name'); ?></td>
            </tr>
            <tr>
                <th class="label"><?php echo __('Category'); ?></th>
                <td class="data"><?php echo $this->Form->input('categoria'); ?></td>
            </tr>
            <tr>
                <th class="label"><?php echo __('Controller'); ?></th>
                <td class="data"><?php echo $this->Form->input('controller'); ?></td>
            </tr>
            <tr>
                <th class="label"><?php echo __('Action'); ?></th>
                <td class="data"><?php echo $this->Form->input('action'); ?></td>
            </tr>
            <tr>
                <th class="label"><?php echo __('Popup'); ?></th>
                <td class="data"><?php echo $this->Form->input('popup'); ?></td>
            </tr>
            <tr>
                <th class="label"><?php echo __('Status'); ?></th>
                <td class="data"><?php echo $this->Utilities->estado('Smessage.estado'); ?></td>
            </tr>
            <tr>
                <th class="label"><?php echo __('Message'); ?></th>
                <td class="data"><?php echo $this->Form->input('smessage'); ?></td>
            </tr>            
        </table>
    </div>

</div>
<?php echo $this->Form->input('id'); ?>
<?php echo $this->Form->end('Accept'); ?>
<script>
    $(document).ready(function() {
        CKEDITOR.replace( 'SmessageSmessage', {toolbar : 'Full'});
    });
</script>