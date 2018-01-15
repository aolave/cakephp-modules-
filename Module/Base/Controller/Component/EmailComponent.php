<?php
App::uses('CakeEmail', 'Network/Email');

class EmailComponent extends Component
{
    public function sendDataEmail($to, $template_name, $values, $attachments=null, $options=array(), $outbox=true, $from=MAIL_SENDER, $template='default', $sendAs='html')
    {
        if($template_name !== false)
        {
            $template = ClassRegistry::init('Template');
            
            $template_data = $template->getPorNombre($template_name);
            
            $template_id = $template_data['Template']['id'];
            $estado = ( $template_data['Template']['estado'] == 1 );
            $asunto = $template_data['Template']['asunto'];
            $smessage = $template_data['Template']['smessage'];
            
            foreach($values AS $val => $valor)
            {
                $smessage = str_replace( $val, $valor, $smessage);
            }
        }
        else
        {
            $template_id = NULL;
            $estado = true;
            $asunto = $values['asunto'];
            $smessage = $values['smessage'];
        }
        //validated mail
        if($to != '' && SEND_MAIL && $estado)
        {
            /** Send mail */
            $email = new CakeEmail();
            //$email->config( $template );
            $email->emailFormat( $sendAs );
    		$email->from( array($from => MAIL_NAME) );
            
            if(is_array($to))
            {
                $email->to( $to['to'] );
                
                if($to['cc'])
                {
                    $email->cc( $to['cc'] );
                }
                
                if($to['cc'])
                {
                    $email->cc( $to['cc'] );
                }
                
                if($to['bcc'])
                {
                    $email->bcc( $to['bcc'] );
                }
                
                if($to['replyTo'])
                {
                    $email->replyTo( $to['replyTo'] );
                }
            }
            else
            {
                $email->to( $to );
            }
            
    		$email->subject( $asunto );
            
            if($attachments)
                $email->attachments( $attachments );
            /** save outbox */
            if($outbox)
            {
                $trayBox = ClassRegistry::init('OutputTray');
                
                $data_outbox['template_id'] = $template_id;
                $data_outbox['de'] = MAIL_SENDER;
                
                if(is_array($to))
                {
                    $data_outbox['para'] = $to['to'];
                    $data_outbox['cc'] = json_encode( @$to['cc'] );
                    $data_outbox['bcc'] = json_encode( @$to['bcc'] );
                    $data_outbox['replyTo'] = json_encode( @$to['replyTo'] );
                }
                else
                {
                    $data_outbox['para'] = $to;
                }
                
                $data_outbox['asunto'] = $asunto;
                $data_outbox['smessage'] = $smessage;
                $data_outbox['user_system'] = SessionComponent::read('Auth.User.username');
                
                $trayBox->saveReg( $data_outbox );
            }
            //se envia
            
            try
            {                
                $email->send( $smessage );
            }
            catch(Exception $e)
            {
                return false;
            }
            
            return true;
        }
        
        return false;
    }
    
}