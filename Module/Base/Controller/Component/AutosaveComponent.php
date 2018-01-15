<?php

class AutosaveComponent extends Component
{    
    var $Autosave_class;
    
    function __construct()
    {
        $this->Autosave_class = ClassRegistry::init('Autosave');    
    }
    
    function get($session_name, $user_id)
    {
        //$autosave = $Autosave_class->findByUserIdAndControllerAndAction( $user_id, $params['controller'], $params['action'] );
        return $this->Autosave_class->findBySessionNameAndUserSistemaAndEstado( $session_name, $user_id, 1 );
    }

    function crear($autosave)
    {
        $this->Autosave_class->save( $autosave );
    }
    
    function isAutosave($session_name, $user_id)
    {
        //$autosave = $Autosave_class->findByUserIdAndControllerAndAction( $user_id, $params['controller'], $params['action'] );
        return is_array( $this->Autosave_class->findBySessionNameAndUserSistemaAndEstado( $session_name, $user_id, 1 ) );
    }
    
    function load($session_name, $user_id)//$params
    {
        //$autosave = $Autosave_class->findByUserIdAndControllerAndAction( $user_id, $params['controller'], $params['action'] );
        $autosave = $this->Autosave_class->findBySessionNameAndUserSistemaAndEstado( $session_name, $user_id, 1 );
        //pr($autosave);
        if($autosave)
        {
            //$Autosave_class->delete( $autosave['Autosave']['id'] );
            $this->Autosave_class->id =  $autosave['Autosave']['id'];
            $this->Autosave_class->saveField('estado', 0); 
            return json_decode( $autosave['Autosave']['datos'], true );
        }
        
        return 0;
    }
    
    function remove($session_name, $user_id)//$params
    {
        //$autosave = $Autosave_class->findByUserIdAndControllerAndAction( $user_id, $params['controller'], $params['action'] );
        $autosave = $this->Autosave_class->findBySessionNameAndsuarioSistemaAndEstado( $session_name, $user_id, 1);
        //$Autosave_class->delete( $autosave['Autosave']['id'] );
        if($autosave)
        {
            $this->Autosave_class->id =  $autosave['Autosave']['id'];
            $this->Autosave_class->saveField('estado', 0);
        } 
    }
    
}
?>