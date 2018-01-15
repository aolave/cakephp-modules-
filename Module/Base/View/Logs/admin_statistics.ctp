<?php echo $this->element('../Logs/submenu'); ?>
<br />
<div class="statistics">
    <div class="name_estadistica"><?php echo __('More visited pages'); ?></div>
    <?php
        /* cabecera */
        $ths = array();
        $ths[]= array("label"=>__("No"));
        $ths[]= array("label"=>__("Controller"));
        $ths[]= array("label"=>__("Action"));
        $ths[]= array("label"=> __("Quantity"));
        
        $ths_table[] = $ths;
        
    	$tds_table= array();
        $params = array();
        $pos = 1;
        
    	foreach($paginasMasVisitadas as $dato)
    	{
    		$td = array();
            //
            $params['filter[Log.controller]'] = $dato['Log']["controller"];
            $params['filter[Log.action]'] = $dato['Log']["action"];
            $link = $this->Utilities->link($dato[0]["cant"], array('action' => 'index', '?' => get_GET($params)));
            
            $td[] = array('data' => $pos++);
            $td[] = array('data' => $dato['Log']["controller"]);
            $td[] = array('data' => $dato['Log']["action"]);
            $td[] = array('data' => $link, 'class' => 'numero');
            
    		$tds_table[] = $td;
        }
        
        echo $this->Tabla->tabla($ths_table, $tds_table, NO_RESULTS, array(), 1);
    ?>
</div>
<div class="statistics">
    <div class="name_estadistica"><?php echo __('Users activity'); ?></div>
    <?php
        /* cabecera */
        $ths = array();
        $ths[]= array("label"=>__("No"));
        $ths[]= array("label"=>__("User"));
        $ths[]= array("label"=> __("Activity"));
        
        $ths_table = array();
        $ths_table[] = $ths;
        $params = array();
        
    	$tds_table= array();
        $pos = 1;
        
    	foreach($usersMasActividad as $dato)
    	{
    		$td = array();
            //		
            $params['filter[Log.user_system]'] = $dato['Log']["user_system"];
            $link = $this->Utilities->link($dato[0]["cant"], array('action' => 'index', '?' => get_GET($params)));
            
            $td[] = array('data' => $pos++);
            $td[] = array('data' => $dato['Log']["user_system"]);
            $td[] = array('data' => $link, 'class' => 'numero');
            
    		$tds_table[] = $td;
        }
        
        echo $this->Tabla->tabla($ths_table, $tds_table, NO_RESULTS, array(), 1);
    ?>
</div>
<div class="statistics">
    <div class="name_estadistica"><?php echo __('More used browser'); ?></div>
    <?php
        /* cabecera */
        $ths = array();
        $ths[]= array("label"=>__("No"));
        $ths[]= array("label"=>__("Browser"));
        $ths[]= array("label"=> __("Quantity"));
        
        $ths_table = array();
        $ths_table[] = $ths;
        
    	$tds_table= array();
        $params = array();
        $pos = 1;
        
    	foreach($navegadorMasUsado as $dato)
    	{
    		$td = array();
            //		
            $params['filter[Log.navegador]'] = $dato['Log']["navegador"];
            $link = $this->Utilities->link($dato[0]["cant"], array('action' => 'index', '?' => get_GET($params)));
            
            $td[] = array('data' => $pos++);
            $td[] = array('data' => $dato['Log']["navegador"]);
            $td[] = array('data' => $link, 'class' => 'numero');
            
    		$tds_table[] = $td;
        }
        
        echo $this->Tabla->tabla($ths_table, $tds_table, NO_RESULTS, array(), 1);
    ?>
</div>
<div class="statistics">
    <div class="name_estadistica"><?php echo __('More used language'); ?></div>
    <?php
        /* cabecera */
        $ths = array();
        $ths[]= array("label"=>__("No"));
        $ths[]= array("label"=>__("Language"));
        $ths[]= array("label"=> __("Quantity"));
        
        $ths_table = array();
        $ths_table[] = $ths;
        
    	$tds_table= array();
        $params = array();
        $pos = 1;
        
    	foreach($idiomaMasUsado as $dato)
    	{
    		$td = array();
            //		
            $params['filter[Log.idioma]'] = $dato['Log']["idioma"];
            //$link = $this->Utilities->link($dato[0]["cant"], array('action' => 'index', '?' => get_GET($params)));
            $link =$dato[0]["cant"];
            
            $td[] = array('data' => $pos++);
            $td[] = array('data' => $dato['Log']["idioma"]);
            $td[] = array('data' => $link, 'class' => 'numero');
            
    		$tds_table[] = $td;
        }
        
        echo $this->Tabla->tabla($ths_table, $tds_table, NO_RESULTS, array(), 1);
    ?>
</div>
<div class="statistics">
    <div class="name_estadistica"><?php echo __('IPs visit'); ?></div>
    <?php
        /* cabecera */
        $ths = array();
        $ths[]= array("label"=>__("No"));
        $ths[]= array("label"=>__("IP"));
        $ths[]= array("label"=> __("Quantity"));
        
        $ths_table = array();
        $ths_table[] = $ths;
        
    	$tds_table= array();
        $params = array();
        $pos = 1;
        
    	foreach($ipMasUsada as $dato)
    	{
    		$td = array();
            //		
            $params['filter[Log.ip]'] = $dato['Log']["ip"];
            $link = $this->Utilities->link($dato[0]["cant"], array('action' => 'index', '?' => get_GET($params)));
            
            $td[] = array('data' => $pos++);
            $td[] = array('data' => $dato['Log']["ip"]);
            $td[] = array('data' => $link, 'class' => 'numero');
            
    		$tds_table[] = $td;
        }
        
        echo $this->Tabla->tabla($ths_table, $tds_table, NO_RESULTS, array(), 1);
    ?>
</div>