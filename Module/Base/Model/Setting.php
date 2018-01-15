<?php
App::uses('AppModel', 'Model');

class Setting extends AppModel {
    
    public $order = 'Setting.nombre';
    
	public $validate = array(
		'variable' => array(
			'notBlank' => array(
				'rule' => array('notBlank'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'valor' => array(
			'notBlank' => array(
				'rule' => array('notBlank')
			),
		),
		'modulo' => array(
			'notBlank' => array(
				'rule' => array('notBlank')
			),
		),
		'tipo' => array(
			'numeric' => array(
				'rule' => array('numeric')
			),
		),
		'nombre' => array(
			'notBlank' => array(
				'rule' => array('notBlank')
			),
		),
	);
    
    public function getModulos()
    {
        return $this->find('list', array('fields' => array('modulo', 'modulo')));
    }
    
    public function getAllPorModulo($modulo)
    {
        return $this->getList(array('Setting.modulo' => $modulo));
    }
}