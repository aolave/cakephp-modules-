<?php echo $this->Utilities->linkRegresar( array('action' => 'index') ); ?>
<div class="index">
    <?php	
        echo $this->Html->css('jquery/jquery-treeview');
        //echo $this->Html->css('tree');
        echo $this->Html->script('jquery/jquery-treeview');
    ?>
    <u>Grupo: <?php echo $aro_name; ?></u>
    <br clear="all"/>
    <br clear="all"/>
    <br clear="all"/>
    <?php echo $this->Tree->treeview('acos', $acos, 500, true); ?>
</div>
<script type="text/javascript">
	$('.hitarea').eq(0).click();
    
    function updatereg(id_, tipo){
        //
        a=id_;
        pers = $('#'+ id_ +' a img');
        //
        if(tipo == 1){
            pers.eq(0).addClass('permitido');
            pers.eq(1).removeClass('denegado');
            pers.eq(2).removeClass('heredado');
        }
        else if(tipo == 2){
            pers.eq(0).removeClass('permitido');
            pers.eq(1).addClass('denegado');
            pers.eq(2).removeClass('heredado');
        } 
        else{
            pers.eq(0).removeClass('permitido');
            pers.eq(1).removeClass('denegado');
            pers.eq(2).addClass('heredado');
        }       
    }
</script>