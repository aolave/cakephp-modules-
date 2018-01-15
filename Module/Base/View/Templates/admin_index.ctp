<?php echo $this->Session->flash(); ?>
<?php echo $this->Utilities->link_ajax(__('New template'), array('controller' => 'templates', 'action' => 'editar'), array('class' => 'adicionar')); ?>
<?php echo $this->Filter->show( $filters, $this->params['controller'], $this->params['controller'], $this->params['action'], $this->params['pass'] ); ?>
<br />
<?php
    /* cabecera */
    $ths = array();
    $ths[]= array("label"=>__("Name", true), 'ordenar' => 'Template.name');
    $ths[]= array("label"=>__("Subject", true), 'ordenar' => 'Template.asunto');
    $ths[]= array("label"=>__("Module", true), 'ordenar' => 'Template.modulo');
    $ths[]= array("label"=>__("", true));
    
    $ths_table[0] = $ths;
    
	$tds_table= array();
    
	foreach($listing AS $value)
	{
		$td= array();
        
        if($value['Template']["estado"] == 1) {
            $updEstado = __("Deactivate");
            $class = 'activar_table';
            $img = 'arrow_down';
        }
        else {
            $updEstado = __("Activate");
            $class = 'desactivar_table';
            $img = 'arrow_up';
        }
        //
        $update_status = $this->Utilities->ajaxLink($updEstado, array("controller"=>'templates', "action"=>"statusUpdate", $value['Template']["id"]), array('htmlAttributes' => array('name' => $value['Template']["id"], 'class' => $class, 'confirm' => ARE_YOU_SURE), 'complete' => "updateEst(XMLHttpRequest);"));
       	$modifyA= $this->Utilities->link( __("Edit", true), array("controller"=>'templates', "action"=>"editar", $value['Template']["id"]), array('class' => 'editar_table'));
		$test= $this->Utilities->link(__("Test", true), array("controller"=>'templates', "action"=>"test", $value['Template']["id"]));
        	
		$td[] = array('data' => $value['Template']["name"]);
        $td[] = array('data' => $value['Template']["asunto"]);
        $td[] = array('data' => $value['Template']["modulo"]);
        $td[] = array('data' => $modifyA . $test . $update_status);
        
        $tds_table[] = $td;
    }
    
    echo $this->Tabla->tabla($ths_table, $tds_table, NO_RESULTS, array(), 1);
?>        