<?php
App::uses('AppController', 'Controller');

class AutosavesController extends AppController
{

    public function save($controller, $action)
    {
        $this->loadModel("Autosave");
        $autosave = $this->Autosave->get_Per_User_Action_Controller( $this->Auth->user("username"), $controller, $action );
        
        $autosave['Autosave']['user_system'] = $this->Auth->user("username");
        $autosave['Autosave']['controller'] = $controller;
        $autosave['Autosave']['action'] = $action;
        $autosave['Autosave']['datos'] = json_encode( $this->params['data'] );  
        $this->Autosave->saveReg( $autosave );
        
        $this->autoRender = false;
    }
    
    function delete()
    {
        $params = $this->params['parametros'];
        
        $this->loadModel("Autosave");
        $autosave = $this->Autosave->get_Per_User_Action_Controller( $this->Auth->user("username"), $params['controller'], $params['action'] );
        $this->Autosave->deletereg( $autosave['Autosave']['id'] );
    }
    
    function load()
    {
        $params = $this->params['parametros'];
        
        $this->loadModel("Autosave");
        $autosave = $this->Autosave->get_Per_User_Action_Controller( $this->Auth->user("username"), $params['controller'], $params['action'] );
        
        if($autosave)
        {
            $this->Autosave->deletereg( $autosave['Autosave']['id'] );
            $this->_setMessage(__('t is loaded successfully unsaved information'), 1);
            return json_decode( $autosave['Autosave']['datos'], true );
        }
        
        return 0;
    }
}
?>