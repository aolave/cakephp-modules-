<?php echo $this->Filter->show( $filters, $this->params['controller'], $this->params['controller'], $this->params['action'], $this->params['pass'] ); ?>
<br clear='all' />
<?php
    /* cabecera */
    $ths = array();    
    $ths[]= array("label"=>__("User", true), 'ordenar' => 'OutputTray.user_system');    
    $ths[]= array("label"=>__("Date", true), 'ordenar' => 'OutputTray.created');
    $ths[]= array("label"=>__("From", true), 'ordenar' => 'OutputTray.from');
    $ths[]= array("label"=>__("To", true), 'ordenar' => 'OutputTray.to');
    $ths[]= array("label"=>__("Template", true), 'ordenar' => 'Template.name');
    $ths[]= array("label"=>__("Subject", true), 'ordenar' => 'Template.asunto');
    $ths[]= array("label"=>__("", true));
    
    $ths_table[0] = $ths;
    
	$tds_table= array();
    
	foreach($listing as $dato)
	{
		$td= array();
        
        $ver = $this->Utilities->ajaxDialog(__('View'), array('action' => 'ver', $dato['OutputTray']['id']));
        
        $td[] = array('data' => $dato['OutputTray']["user_system"]);
		$td[] = array('data' => $this->Time->format('d-m-Y H:i:s', $dato['OutputTray']["created"]));
		$td[] = array('data' => $dato['OutputTray']["de"]);
        $td[] = array('data' => $dato['OutputTray']["para"]);
        $td[] = array('data' => $dato['Template']["name"]);
        $td[] = array('data' => $dato['Template']["asunto"]);
        $td[] = array('data' => $ver);
		
		$tds_table[] = $td;
    }
    
    echo $this->Tabla->tabla($ths_table, $tds_table, 'Don`t no trays from the system.', array(), 1);
?>