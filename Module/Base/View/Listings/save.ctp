<?php if(!isset($success)): ?>
    <?php echo $this->Form->create('Listing'); ?>
    	<?php
    		echo $this->Utilities->field_hidden('Listing', 'Listing.parent_id', 'ParentListing.name');
            echo $this->Form->input('id');
    		echo $this->Form->input('name', array('label' => 'Name'));
            echo $this->Form->input('key', array('label' => 'Key'));
            echo $this->Form->input('estado', array('default' => 1));
            echo $this->Form->input('datos', array('label' => 'Additional Information'));
    	?>    	
        <?php if(@isset($this->params['pass'][0]) && @isset($this->params['pass'][1])): ?>
            <?php echo $this->Utilities->submit_ajax_url( array('action' => 'save', $this->params['pass'][0], $this->params['pass'][1]), ACCEPT ); ?>
            <?php echo $this->Utilities->submit_ajax_url( array('action' => 'save', $this->params['pass'][0], $this->params['pass'][1], 1), ACCEPT_CONTINUE ); ?>
        <?php else: ?>
            <?php echo $this->Utilities->submit_ajax_url( array('action' => 'save'), ACCEPT ); ?>
        <?php endif; ?>
        <?php //echo $this->Utilities->AjaxSubmit(ACCEPT, array('update' => '#modalWindow')); ?>
    <?php echo $this->Form->end();?>
<?php else: ?>
    <?php echo $this->Html->scriptBlock('ReloadThisPage();'); ?>
<?php endif; ?>