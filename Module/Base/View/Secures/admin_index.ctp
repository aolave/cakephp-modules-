<?php echo $this->element('../Secures/submenu'); ?>
<div id="secure">
    <?php	
        echo $this->Html->css('jquery/jquery-treeview');
        echo $this->Html->script('jquery/jquery-treeview');
        echo $this->Html->css('generic');
    ?>
    <?php echo $this->Utilities->ajaxDialog('New Group', array('controller' => 'secures', 'action' => 'saveGroup'), array('class' => 'g_add')); ?>
    <br clear="all"/>
    <br clear="all"/>
    <?php echo $this->Html->tag('label', 'Search'); ?>
    <?php echo $this->Form->text('search', array('onkeyup' => "searchInTree(this, 'aros');")); ?>
    <br clear="all"/>
    <br clear="all"/>
    <?php echo $this->Tree->treeview('aros', $aros, 850, "650", true); ?>
</div>
<br />
<br />
<?php echo $this->Html->link(__('Execute secure'), array('action' => 'run', GENERIC_PASSWORD)); ?>
<?php echo $this->Html->scriptBlock('secure();'); ?>