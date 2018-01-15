<?php
App::uses('AppModel', 'Model');

class Smessage extends AppModel
{
	public $validate = array(
		'name' => array(
			'notBlank' => array(
				'rule' => array('notBlank')
			),
		),
	);
    
    public function getPorNombre($name)
    {
	   return $this->findByName( $name );
    }
    
    
    public function getListSmessages( $filters = array(), $params = array() )
    {
        //$filters['Smessage.estado'] = 1;
        return $this->getList($filters, $params);
    }
    
    public function getPorControladorAccion($controller, $action)
    {
        return $this->findByControllerAndActionAndEstado($controller, $action, 1);
    }

}