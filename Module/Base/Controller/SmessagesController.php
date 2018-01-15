<?php
App::uses('AppController', 'Controller');

class SmessagesController extends AppController
{
    public function beforeFilter(){
        parent::beforeFilter();
        $this->Auth->allow();
    }
    public function admin_index()
    {
		$this->Filter->addFilter('Smessage.name', __("Name"), 'text');
        $this->Filter->addFilter('Smessage.categoria', __("Modulo"), 'text');
        $this->Filter->addFilter('Smessage.controller', __("controller"), 'text');
        $this->Filter->addFilter('Smessage.action', __("Action"), 'text');        
        
        //$this->paginate = array('limit' => $this->limit_pag);
        $this->paginateOptions = array_merge($this->paginateOptions, $this->Smessage->getListSmessages( $this->Filter->getValues($this->params), array('paginate' => true) ));
	    $this->paginate = $this->paginateOptions;
        
        $this->set('listing', $this->paginate());
        $this->set('filters', $this->Filter->getFilters( $this->_getUrlQuery('filter') ));
	}
    
    public function admin_save($id=NULL)
    {
        if ($this->_isData())
        {
            if ($this->Smessage->saveReg($this->request->data))
            {
				$this->_setMessage(messages('SUCCESS'), SUCCESS);
				$this->redirect(array('action' => 'index'));
			}
            else
            {
				$this->_setMessage(messages('ERROR'), ERROR);
			}
		}
		else
        {
			$this->request->data = $this->Smessage->read(null, $id);
		}
    }
    
    public function smessage($smessage_name)
    {
        return $this->Smessage->getPorNombre($smessage_name); 
    }
    
    public function getSmessage($smessage_name)
    {
        $msj = $this->Smessage->getPorNombre($smessage_name);
        echo $msj['Smessage']['smessage'];
        exit; 
    }

}