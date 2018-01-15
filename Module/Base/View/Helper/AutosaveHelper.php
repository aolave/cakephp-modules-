<?php

/* <?php echo $autosave->saveData(); ?> */
class AutosaveHelper extends AppHelper {
        
    var $helpers = array('Ajax', 'Javascript', 'Html', 'Session');    
    
    function saveData($autosaveName, $is_autosave=false)
    {
        $html = "<div id='guardando'>". __('Guardando...', true) ."</div>";
        
        if($is_autosave)
        {
            $html .= $this->Html->scriptBlock("
                if(confirm('Se ha detectado información no guardada, desea cargarla?'))
                { 
                    //window.location.reload( true );
                    loadDataAutosave('$autosaveName');
                }
            ");
            //else { $.ajax({ url: $('#webroot').val() +'autosaves/delete/$autosaveName', }); }
        }
        
        return $html . $this->Html->scriptBlock("autosave('$autosaveName', '". $this->Session->read('frecuencia_autosave') ."');");
        
        //$html = $this->Html->scriptBlock("$(window).bind('beforeunload',function(event) { return 'Va a abandonar la página, los datos se perderan'; }); ");
        /*
        return $html . $this->Ajax->remoteTimer(
            array('url' => array( 'controller' => 'autosaves', 'action' => 'save', $autosaveName), 
                  'frequency' => $this->Session->read('frecuencia_autosave'), 'data' => "$('form').serialize()",
                  'before' => " $('#guardando').show(); ",
                  //'complete' => " setTimeout(\" $('#guardando').fadeOut(3000) \", 3000 ); ",
                  'complete' => " $('#guardando').show().delay(2000).fadeOut(3000); "
            )
        );
        */
    }
}
?>