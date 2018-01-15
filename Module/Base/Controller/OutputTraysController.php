<?php
App::uses('AppController', 'Controller');
class OutputTraysController extends AppController
{
    public function admin_index()
    {
        //$this->Filter->addFilter('OutputTray.user_system', "User", 'select', $this->Log->getUsers() ); // note: error loading the log
		$this->Filter->addFilter('OutputTray.de', __("From"), 'textLike');
        $this->Filter->addFilter('OutputTray.para', __("To"), 'textLike');
        $this->Filter->addFilter('OutputTray.template_id', __("Template"), 'select', $this->OutputTray->Template->find('list'));
        
        $this->_paginar( $this->OutputTray->getList( $this->Filter->getValues($this->params), array('paginate' => true)) );
        
        $this->set('listing', $this->paginate());
        $this->set('filters', $this->Filter->getFilters( $this->_getUrlQuery('filter') ));
	}
    
    public function ver($id = null) {
		//
		$this->set('outputTray', $this->OutputTray->get($id));
	} 
}