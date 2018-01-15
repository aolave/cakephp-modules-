<?php
App::uses('AppController', 'Controller');

class SettingsController extends AppController
{    
    
	public function admin_index($modulo = null)
    {
		if($modulo)
        {
            $this->set('modulos', $this->Setting->getAllPorModulo($modulo));
        }
        
        $this->set('modulos_data', $this->Setting->getModulos());
        $this->set('modulo_id', $modulo);
	}
    
    public function save()
    {
        if($this->_isData()) {
                 
            if($this->Setting->saveRegTodos($this->_postValue('Setting'), array('validate'=>'first')))
            {
                $this->_setMessage(messages('SUCCESS'), SUCCESS);
            }
            else
            {
                $this->_setMessage(messages('ERROR'), ERROR);
            }
            
            $this->index();
            //$this->redirect(array('action' => 'index'));
            $this->redirect( $this->referer() );
        }
    }
    
    public function saveReports()
    {
        $url = $this->params['url_'];
        $reports = $this->params['reports'];
        $url = $this->params['url_'];
        $url = str_replace("|", "&", $url);
        //
        $this->loadModel('User');
        $this->User->recursive = -1;
        $u = $this->User->findById($this->Auth->user('id'));
        $conf = json_decode($u['User']['favoritos'], true);
        $conf[] = array('id' => count($conf)+1, 'url' => $url, 'name' => $reports);
        $u['User']['favoritos'] = json_encode($conf);
        //
        $this->User->save($u);
        //
        $this->autoRender = false;
        //exit;
    }
    
}