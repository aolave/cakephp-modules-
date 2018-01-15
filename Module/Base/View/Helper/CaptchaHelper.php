<?php

App::uses('AppHelper', 'View/Helper');

class CaptchaHelper extends AppHelper
{
	public $helpers = array('Html', 'Form');
	private $captchaerror;	
	private $view;
    
	public function __construct(View $view, $settings = array())
	{
		parent::__construct($view, $settings);
		$this->view = $view;
		@$this->captchaerror = $view->viewVars['captchaerror'];
	}
	function input($controller=null)
    {
		if(is_null($controller))
        { 
            $controller = $this->view->params['controller']; 			
        } 
        
		$output=$this->writeCaptcha($controller);
		return $output;
	}
	protected function writeCaptcha($controller){
		
        echo $this->Form->input('cakecaptcha', array(
                'before' => $this->Html->image($this->Html->url(array('controller'=>$controller,'action'=>'captcha'),true),array('id'=>'cakecaptcha')), 
                'after' => "<a class='remember_passwd' href='javascript:void(0)' onclick=\"document.getElementById('captcha-form').value=''; document.getElementById('cakecaptcha').src='". $this->Html->url(array('controller'=>$controller,'action'=>'captcha')) ."?'+Math.random(); document.getElementById('captcha-form').focus();\" id='change-image'>UpdateReg código</a>", 
                'id'=>'captcha-form',
                'name'=>'data[cakecaptcha][captcha]',
                'label'=>'Código de secure')
        );
    }

}