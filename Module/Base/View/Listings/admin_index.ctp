<div class="index">
    <?php	
        echo $this->Html->css('jquery/jquery-treeview');
        //echo $this->Html->css('tree');
        echo $this->Html->script('jquery/jquery-treeview');
    ?>
    <?php echo $this->Utilities->ajaxDialog(__('New Listing'), array('controller' => 'listings', 'action' => 'save', 'admin' => false), array('class' => 'link_add')); ?>
    <br clear="all"/>
    <br clear="all"/>
    <br clear="all"/>
    <?php echo $this->Tree->treeview('listings', $listings, 750, 'true'); ?>
</div>