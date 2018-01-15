<?php echo $this->element('../Secures/submenu'); ?>
<?php echo $this->Js->link(__('Nueva'), array('controller' => 'secures', 'action' => 'saveIp'), array('class' => 'adicionar', 'complete' => "newFilaTabla('.table_page', XMLHttpRequest)")); ?>
<?php echo $this->Filter->show( $filters, $this->params['controller'], $this->params['controller'], $this->params['action'], $this->params['pass'] ); ?>
<br />
<?php	
    $ths = array();
    
    $ths[]= array("label"=>__("IP"), 'ordenar' => 'ipAllowed.ip');
    $ths[]= array("label"=>__("Estado"));
    $ths[]= array("label"=>__(""));
    $ths_table[] = $ths;
    
	$tds_table= array();
    $pos = 0;
    
	if($listing) {
		foreach($listing as $dato)
		{
			$td= array();
            
            $td[] = array('data' => $dato['ipAllowed']["ip"]);
            $td[] = array('data' => getStatus( $dato['ipAllowed']["estado"] ));
            $td[] = array('data' => $this->Js->link(__('Editar'), array('controller' => 'secures', 'action' => 'saveIp', $dato['ipAllowed']["id"]), array('update' => '#dato_'. $dato['ipAllowed']["id"])));
						
            $tds_table[ $pos ] = $td;
            $tds_table[ $pos++ ]['id'] = 'dato_'. $dato['ipAllowed']["id"];
		}		
	}
    
    echo $this->Tabla->tabla($ths_table, $tds_table, NO_RESULTS, array(), 1);
?>