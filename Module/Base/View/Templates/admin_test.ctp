<?php echo $this->Utilities->linkRegresar( array('controller' => 'templates', 'action' => 'index') ); ?>
<?php echo $this->Form->Create('Template', array('inputDefaults' => array('label' => false))); ?>
<div class="info_general">
    <div class="section">        
        <div class="title_section"><?php __('Test Template'); ?></div>
    </div>
    <div class="info">
        <table class="table_page">
            <tr>
                <td class="label"><?php echo __('Name'); ?></td>
                <td class="data" style="font-weight: bold;"><?php echo $name; ?></td>
            </tr>
            <tr>
                <td class="label"><?php echo __('To'); ?></td>
                <td class="data"><?php echo $this->Form->text('para'); ?></td>
            </tr>
            <?php foreach($labels[1] AS $label): ?>
                <tr>
                    <td class="label"><?php echo __($label); ?></td>
                    <td class="data"><?php echo $this->Form->text($label); ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>
</div>
<?php echo $this->Form->input('id'); ?>
<?php echo $this->Form->end(ACCEPT); ?>