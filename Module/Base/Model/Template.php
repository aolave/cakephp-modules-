<?php
App::uses('AppModel', 'Model');

class Template extends AppModel {
    
    public $order = 'Template.name';
    
	public $validate = array(
		'name' => array(
			'notBlank' => array(
				'rule' => array('notBlank'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'asunto' => array(
			'notBlank' => array(
				'rule' => array('notBlank'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'modulo' => array(
			'notBlank' => array(
				'rule' => array('notBlank'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
	);

	public $hasMany = array(
		'OutputTray' => array(
			'className' => 'OutputTray',
			'foreignKey' => 'template_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		)

	);
    
    public function getPorNombre($name)
    {
        return $this->findByName($name);
    }
	
	public function procesarTemplate($idTemplate, $values) {

		if($infoTemplate = $this->findById($idTemplate)) {
			$arr['body'] 	= str_replace( array_keys($values), $values, $infoTemplate['Template']['smessage']);
			$arr['header'] 	= str_replace( array_keys($values), $values, $infoTemplate['Template']['header']);
			return $arr;
		} else {
			return false;
		}

	}
	
	public function nuevo($Data) {
		$Data['Template']['asunto'] = $Data['Template']['name'];
		$Data['Template']['modulo'] = 'LETTERS';
		return $this->saveReg( $Data );
	}
	
}