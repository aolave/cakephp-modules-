<?php
App::uses('AppModel', 'Model');

class Menu extends AppModel
{
    //public $actsAs = array('Tree');
    
	public $validate = array(
		'name' => array(
			'notBlank' => array(
				'rule' => array('notBlank'),
				'message' => FIELD_REQUIRED,
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
        /*
        'controller' => array(
			'notBlank' => array(
				'rule' => array('notBlank'),
				'message' => FIELD_REQUIRED,
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
        'action' => array(
			'notBlank' => array(
				'rule' => array('notBlank'),
				'message' => FIELD_REQUIRED,
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		)	
        */
	);


	public $belongsTo = array(
		'ParentMenu' => array(
			'className' => 'Menu',
			'foreignKey' => 'parent_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

	public $hasMany = array(
		'ChildMenu' => array(
			'className' => 'Menu',
			'foreignKey' => 'parent_id',
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
    
    public function ordenar($id)
    {
        $this->recursive = -1;
        $menu = $this->get($id);
        
        if( $menu['Menu']['orden'] != '' )
        {
            $menus = $this->find('all', array('order' => 'Menu.orden', 'conditions' => array('Menu.parent_id' => $menu['Menu']['parent_id'], 'Menu.id !=' => $id, 'Menu.orden >=' => $menu['Menu']['orden'])));
            $orden = $menu['Menu']['orden'];
            
            foreach($menus AS $m)
            {
                $this->id = $m['Menu']['id'];
                $this->saveField( 'orden', ++$orden );
            }
        }
        else
        {
            $menus = $this->find('all', array('conditions' => array('Menu.parent_id' => $menu['Menu']['parent_id'])));
            
            $this->id = $id;
            $this->saveField( 'orden', count($menus) );
        }
    }
    
    public function getMenusActivos()
    {
        return $this->find('threaded', array('recursive' => -1, 'order' => 'Menu.orden', 'conditions' => array('Menu.estado' => 1)));
    }

}