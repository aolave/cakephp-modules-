<?php
App::uses('AppController', 'Controller');

class MenusController extends AppController
{
    public $helpers = array('Tree');
    
    public function admin_save($id=null,$parent_id=null)
    {
        if ($this->_isData())
        {
			if ($this->Menu->saveReg($this->request->data))
            {
				$this->_setMessage( messages('SUCCESS'), SUCCESS);
                
                if( $this->request->data['Menu']['id'] == '' )
                {
                    $this->ordenar( $this->Menu->id );
                }
                
                $this->set('exito', 1);
			} 
            else
            {
				$this->_setMessage( messages('ERROR'), ERROR);
			}
		}
		elseif($id)
        {
			$this->request->data = $this->Menu->read(null, $id);
		}
        elseif($parent_id)
        {
            $this->request->data['Menu']['parent_id'] = $parent_id;
            $this->Menu->id = $parent_id;
            $this->request->data['ParentMenu']['name'] = $this->Menu->field('name');
        }
    }
    
    public function admin_delete($id)
    {
        if ($this->Menu->deletereg($id, true)) {
			$this->_setMessage( messages('SUCCESS'), SUCCESS);            
		}
        else{
		  $this->_setMessage(__('You can not remove as there are sub-menus'), ERROR);
        }
        //
        $this->redirect(array('action'=>'index'));
    }
    
    public function admin_index()
    {
        $this->set('menus', $this->_treeMenus($this->Menu->getList(false, array('type' => 'threaded', 'order' => 'Menu.orden')), 1));
    }
    
    private function _treeMenus($menus, $root=0, &$result=array())
    {
        if($menus)
        {
            foreach($menus AS $menu)
            {
                if(isset($menu['Menu']))
                {
                    $tmp_result['label'] = $menu['Menu']['name'];
                    $tmp_result['class'] = '';
                    $tmp_result['class_li'] = 'menu';
                    $tmp_result['class_label'] = 'menues'. ( $menu['Menu']['fake'] ? " fake": "" );
                    $tmp_result['class_accions'] = 'acciones';
                    $tmp_result['id'] = $menu['Menu']['id'];
                    //Actios
                    $tmp_result['actions']= array(                        
                        array(
                            'type' => 'ajaxDialog',
                            'label_acc' => 'Modify',
                            'url' => array('controller' => 'menus', 'action' => 'save', $menu['Menu']['id']),
                            'options' => array('class' => 'link_edit')
                        ),
                        array(
                            'type' => 'link',
                            'label_acc' => 'Delete',
                            'url' => array('controller' => 'menus', 'action' => 'delete', $menu['Menu']['id']),
                            'options' => array('class' => 'link_delete', 'confirm' => sprintf(__('Delete the Menu %s?'), $menu['Menu']['name']))
                        ),
                        array(
                            'type' => 'ajaxDialog',
                            'label_acc' => 'Add Submenu',
                            'url' => array('controller' => 'menus', 'action' => 'save', 0, $menu['Menu']['id']),
                            'options' => array('class' => 'link_add')
                        )                        
                    );
                    
                    $tmp_result['children'] = array();
                    
                    if(isset($menu['children']))
                    {
                        $this->_treeMenus($menu['children'], 0, $tmp_result['children']);
                    }
                    
                    $result[] = $tmp_result;
                }
            }
        }
        
        return $result;
    }
    
    public function mover($menu_id, $menu_parent_id, $orden)
    {
        $menu = $this->Menu->get( $menu_id );
        
        if($menu_parent_id == 0)
        {
            $menu_parent_id = NULL;
        }
        
        $menu['Menu']['parent_id'] = $menu_parent_id;
        $menu['Menu']['orden'] = $orden;
                
        $this->Menu->saveReg( $menu );
        
        $this->ordenar($menu_id);
        $this->autoRender = false;
    }
    
    private function ordenar($menu_id)
    {
        $this->Menu->ordenar( $menu_id );
    }

}