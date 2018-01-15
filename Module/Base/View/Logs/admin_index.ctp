<?php echo $this->element('../Logs/submenu'); ?>
<?php echo $this->Filter->show( $filters, $this->params['controller'], $this->params['controller'], $this->params['action'], $this->params['pass'] ); ?>
<br />
<?php
    /* cabecera */
    $ths = array();    
    $ths[]= array("label"=>__("User", true), 'ordenar' => 'Log.user_system');    
    $ths[]= array("label"=>__("Date", true), 'ordenar' => 'Log.created');
    $ths[]= array("label"=>__("IP", true), 'ordenar' => 'Log.ip');
    $ths[]= array("label"=>__("Module", true), 'ordenar' => 'Log.controller');
    $ths[]= array("label"=>__("Page", true), 'ordenar' => 'Log.action');
    $ths[]= array("label"=>__("Browser", true), 'ordenar' => 'Log.navegador');
    $ths[]= array("label"=>__("Language", true), 'ordenar' => 'Log.idioma');
    $ths[]= array("label"=>__("It has data?", true));
    $ths[]= array("label"=>__("Detail", true));
    $ths[]= array("label"=> "");
    $ths_table[0] = $ths;
    
	$tds_table= array();
    
	foreach($lstLogs as $dato)
	{
		$td = array();
        
        $ver = $this->Utilities->link_ajax(__('View content'), array('action' => 'contents', $dato['Log']['id']));
        //		
        $td[] = array('data' => $dato['Log']["user_system"]);
        $td[] = array('data' => $dato['Log']["created"]);
        $td[] = array('data' => $dato['Log']["ip"]);
        $td[] = array('data' => $dato['Log']["controller"]);
        $td[] = array('data' => $dato['Log']["action"]);
        $td[] = array('data' => $dato['Log']["navegador"]);
        $td[] = array('data' => $dato['Log']["idioma"]);
        $td[] = array('data' => ( $dato['Log']["is_data"] == 1 ? 'X' : '' ));
        $td[] = array('data' => $dato['Log']["detalle"]);
		$td[] = array('data' => $ver);
        
		$tds_table[] = $td;
    }
    
    echo $this->Tabla->tabla($ths_table, $tds_table, NO_RESULTS, array(), 1);
?>