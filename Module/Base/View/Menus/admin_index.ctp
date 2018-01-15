<h2>Menus</h2>
<div id="menus_adm">
    <?php	
        echo $this->Html->css('jquery/jquery-treeview');
        echo $this->Html->script('jquery/jquery-treeview');
        echo $this->Html->css('generic');
    ?>
    <?php echo $this->Utilities->ajaxDialog(__('New Menu'), array('controller' => 'menus', 'action' => 'save', 'admin' => true), array('class' => 'link_add')); ?>
    <br clear="all"/>
    <br clear="all"/>
    <br clear="all"/>
    <?php echo $this->Tree->treeview('menues', $menus, '650', true, true); ?>
</div>
<?php echo $this->Html->scriptBlock('menu();'); ?>