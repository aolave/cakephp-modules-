<?php if(!isset($exito)): ?>
    <?php echo $this->Form->create('Menu'); ?>
    	<?php
    		echo $this->Utilities->field_hidden('Menu', 'Menu.parent_id', 'ParentMenu.name');
            echo $this->Form->input('id');
    		echo $this->Form->input('name', array('label' => 'Name'));
            echo $this->Form->input('controller', array('label' => 'Controller'));
            echo $this->Form->input('action', array('label' => 'Action'));
            echo $this->Form->input('params', array('label' => 'Parameters'));
            echo $this->Form->input('redirect', array('label' => 'Send to'));
            echo $this->Form->input('smessage', array('label' => 'Message'));
            echo $this->Form->input('class', array('label' => 'Class CSS'));
            echo $this->Form->input('fake', array('label' => 'Menu only crumb'));
    	?>
    	<?php echo $this->Utilities->AjaxSubmit(ACCEPT, array('update' => '#modalWindow')); ?>
    <?php echo $this->Form->end();?>
<?php else: ?>
    <?php echo $this->Html->scriptBlock('ReloadThisPage();'); ?>
<?php endif; ?>