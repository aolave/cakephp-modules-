<?php if(!isset($exito)): ?>
    <?php echo $this->Form->create('Group'); ?>
    	<?php
    		echo $this->Form->input('id');
            echo $this->Utilities->field_hidden(__('Grupo'), 'Group.parent_id', 'ParentGroup.name');
    		echo $this->Form->input('name', array('label' => __('Name')));
            echo $this->Form->input('description', array('label' => __('Description')));
    	?>
    	<?php echo $this->Utilities->AjaxSubmit(ACCEPT, array('update' => '#modalWindow')); ?>
    <?php echo $this->Form->end();?>
<?php else: ?>
    <?php echo $this->Html->scriptBlock('ReloadThisPage();'); ?>
<?php endif; ?>