<?php echo $this->Utilities->link_ajax(__('Nuevo'), array('controller' => 'smessages', 'action' => 'save'), array('class' => 'adicionar')); ?>
<?php echo $this->Filter->show( $filters, $this->params['controller'], $this->params['controller'], $this->params['action'], $this->params['pass'] ); ?>
<br />
<?php	
    $ths = array();    
        
    $ths[]= array("label"=>__("Name"), 'ordenar' => 'Smessage.name');
    $ths[]= array("label"=>__("Category"));
    $ths[]= array("label"=>__("Controller"));
    $ths[]= array("label"=>__("Action"));
    $ths[]= array("label"=>__("Modal"));
    $ths[]= array("label"=>__("Status"));
    $ths_table[] = $ths;
    
	$tds_table= array();
    
	if($listing) {
		foreach($listing as $dato)
		{
			$td= array();
            
            $td[] = array('data' => $this->Html->link($dato['Smessage']["name"], array('action' => 'save', $dato['Smessage']["id"])));
            $td[] = array('data' => $dato['Smessage']["categoria"]);
            $td[] = array('data' => $dato['Smessage']["controller"]);
            $td[] = array('data' => $dato['Smessage']["action"]);
            $td[] = array('data' => $dato['Smessage']["popup"]);
            $td[] = array('data' => $dato['Smessage']["estado"]);
			
			$tds_table[] = $td;
		}		
	}
	    
    echo $this->Tabla->tabla($ths_table, $tds_table, 'No se encontraron resultados', array(), 1);
?>