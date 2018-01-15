<?php
App::uses('AppController', 'Controller');

class TemplatesController extends AppController
{
    
    public function admin_index()
    {
        $this->Filter->addFilter('Template.name', __("Name"), 'textLike');
        $this->Filter->addFilter('Template.asunto', __("Subject"), 'textLike');
        $this->Filter->addFilter('Template.modulo', __("Module"), 'select', $this->Template->find('list', array('fields' => array('modulo', 'modulo'))));
        
        $this->_paginar( $this->Template->getList( $this->Filter->getValues($this->params), array('paginate' => true)) );
        
        $this->set('listing', $this->paginate());
        $this->set('filters', $this->Filter->getFilters( $this->_getUrlQuery('filter') ));
	}
    
	public function admin_nuevo() {
		
        if ($this->_isData() ) {

			$data['Template'] = $this->request->data('Template');
            if( $res = $this->Template->nuevo($data) ) {
				$this->redirect(array('action' => 'editar', $res['Template']['id']));
			} else {
				$this->setMessage( __('The template could not be created', true), 3);
                echo "1";
			}
		}
	}
    
    public function admin_editar($id = null) {
		//
        if ($this->_isData())
        {
            if ($this->Template->saveReg($this->request->data))
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
			$this->request->data = $this->Template->read(null, $id);
		}
	}

	public function admin_test($id = null) {
		
        $template = $this->Template->get($id);
        preg_match_all('/\[(.*?)\]/', $template['Template']['smessage'], $labels);
        
        if ($this->_isData())
        {
            $smessage = $template['Template']['smessage'];
            
            if($this->request->data['Template']['para'] != '')
            {
                for($i=0; $i<count($labels[0]);$i++)
                {
                    $values[ $labels[0][$i] ] = $this->request->data['Template'][ $labels[1][$i] ];   
                }
                //send mail 
                $this->Email->sendDataEmail($this->request->data['Template']['para'], $template['Template']['name'], $values, null, false);
                $this->_setMessage(__('Sent mail'), SUCCESS);
            }
            else
            {
                $this->_setMessage(__('To enter'), WARNING);
            }
        }
        else
        {
			$this->request->data = $this->Template->read(null, $id);
		}
        $this->set("labels", $labels);
        $this->set("name", $template['Template']['name']);
	}
    
    public function statusUpdate($id = null)
    {
        $template = $this->Template->get($id);
        $template['Template']['estado'] = !$template['Template']['estado'];
        $this->Template->saveReg($template);
        //
        echo $id;
        $this->autoRender = false;
    }
    
}
?>