<?php
App::uses('HtmlHelper', 'View/Helper');

class UtilitiesHelper extends AppHelper 
{
    public $helpers = array('Html', 'Form', "Session", "Js" => array('Jquery'));
    public $urlForm = null;
    
    public function formCreate($model = null, $options = array())
    {
        $this->urlForm = array('controller' => $this->params['controller'], 'action' => $this->params['action']);
        
        if(isset($options['url']))
        {
            if(isset($options['url']['controller']))
            {
                $this->urlForm['controller'] = $options['url']['controller'];
            }
            if(isset($options['url']['action']))
            {
                $this->urlForm['action'] = $options['url']['action'];
            }
        }
        
        return $this->Form->Create($model, $options);
    }
    
    public function formEnd($options = null)
    {
        return $this->Form->end($options);
    }
    
    public function graficas($graficas)
    {
        $html = "<div class='images'>";
        
        foreach($graficas AS $grafica)
        {
            if(file_exists(JPGRAPH_FOLDER . $grafica))
            {
                $html .= "<div>". $this->Html->image("/". JPGRAPH_FOLDER . $grafica) ."</div>";
            }
        }
        
        $html .= "</div>";
        return $html;
    }
    
    public function field_hidden($label, $id, $name, $valor=NULL)
    {
        $name_ = explode(".", $name);
        
        if(count($name_) == 3)
        {
            if( ($val = @$this->request->data[ $name_[0] ][ $name_[1] ][ $name_[2] ]) != '' || $val = $valor )
            {
                $label = $this->Html->tag("label", $label);
                $div_id = $this->Form->hidden($id) . $this->Form->hidden($name);
        		$div_valor = $this->Html->tag("div", $val, array("class" => "fixed_field"));
        		return $this->Html->tag("div", $label . $div_id . $div_valor, array("class" => "input"));
            }
        }
        else
        {        
            if( ($val = @$this->request->data[ $name_[0] ][ $name_[1] ]) != '' || $val = $valor)
            {
                $label = $this->Html->tag("label", $label);
                $div_id = $this->Form->hidden($id) . $this->Form->hidden($name);
        		$div_valor = $this->Html->tag("div", $val, array("class" => "fixed_field"));
        		return $this->Html->tag("div", $label . $div_id . $div_valor, array("class" => "input"));
            }
        }
    }
    
    public function autoCompleteTag($name, $tags = array(), $delimiter=TAG_SEPARATOR)
    {
        $valor = '';
        
        if($data = $this->params->query)
        {
            $a = explode("[", $name);
            $valor = @$data[ $a[0] ][ substr($a[1], 0, -1) ];
            /*$datos = explode($delimiter, $valor);            
            foreach($datos AS $li) {
                $lis .= "<li class='tagit-choice ui-widget-content ui-state-default ui-corner-all tagit-choice-editable'>". $li ."</li>";
            }*/
        }
        
        $ulId = "ul_". rand(0, 1000);
        $idInput = "tag_". rand(0, 1000);
        $html  = "<input type='hidden' id='$idInput' name='$name' class='_sh_filter' value='$valor' />";
        $html .= "<ul id='$ulId'></ul>";
        $html .= "<script>";
        $html .= "$('#$ulId').tagit({";
            $html .= "singleField: true,";
            $html .= "singleFieldDelimiter: '$delimiter',"; 
            $html .= "singleFieldNode: $('#$idInput'),";
            $html .= "allowSpaces : true,";
            //$html .= "availableTags: ["c++", "java", "php", "javascript", "ruby", "python", "c"] 
            $html .= "});";
        $html .= "</script>";
        return $html;
    }
    
    public function getAdicionarFila()
    {
        return " adicionarFila(this, 0); ";
    }
    
    public function adicionarFila($label='Nueva fila')
    {
        return '<a class="adicionar" style="font-size: 9px" href="javascript:void(0)" title="Add new row" onclick=" adicionarFila(this, 1); ">'. __($label) .'</a>';
    }
    
    public function deleteregFila($label='Delete')
    {
        return '<a class="deletereg" style="font-size: 9px" href="javascript:void(0)" title="Delete row" onclick=" deleteregFila(this); ">'. __($label) .'</a>';
    }    
    
    public function radio($model, $field, $list, $label=null, $options=array('hiddenField' => false))
    {
        if($label === false)
        {
            $labelBefore = false;
        }
        elseif(is_null($label))
        {
            $label = Inflector::humanize($field);
            $labelBefore = $this->Html->tag('label', $label);
        }
        else
        {
            $labelBefore = $this->Html->tag('label', $label);
        }
        //prx($labelBefore);
        return $this->Form->input($model .'.'. $field, $options + array('options' => $list, 'type' => 'radio', 'legend' => false, 'before' => $labelBefore));
    }
    
    public function boolean($field, $options=array())
    {
        $options['before'] = $this->Form->label( $field, @$options['label'] );
        $options['label'] = false;
        return $this->estado($field, $options);
    }
    
    public function estado($field, $options=array())
    {
        $options['default'] = 1;
        return $this->Form->input($field, $options);
    }
    
    public function fecha($model, $field, $options=array())
    {
        return $this->Form->input($model .'.'. $field, $options + array('type' => 'text', 'class' => 'dates', 'readonly' => true, 'default' => date('Y-m-d')));
    }
    
    public function fechaHora($model, $field, $options=array())
    {
        return $this->Form->input($model .'.'. $field, $options + array('type' => 'text', 'class' => 'date_hour', 'readonly' => true, 'default' => date('Y-m-d H:i:s')));
    }
    
    public function hora($model, $field, $options=array())
    {
        return $this->Form->input($model .'.'. $field, $options + array('type' => 'text', 'class' => 'hora', 'readonly' => true));
    }
    
    public function file($model, $field, $options=array(), $ajax=false, $varFile=NULL, $new=false, $delete=true)
    {
        if(isset($this->data[$model][$field]) && !is_array($this->data[$model][$field]) && $this->data[$model][$field] != '')
        {
            $options['after'] = " <a href='". $this->webroot . $this->data[$model][$field] ."'>". __('Descargar') ."</a> ";
        }
        
        $options['type'] = 'file';        
        
        if($ajax)
        {
            $options['data-url'] = $this->Html->url('/') .'files/uploads/';
            $options['multiple'] = false;
            $options['onclick'] = " fileUpload(this, '.myfile'); ";
            $options['name'] = "files[$field]";
            $options['after'] = "<div id='progress'><div class='bar'></div></div><input class='myfile' type='hidden' name='$varFile' />";
        }
        //
        if($new)
        {
            $options['label'] = false;
        }
        
        return $this->Form->input($model .".". $field, $options);
    }
    
    public function printFiles($files, $url, $model, $delete=true)
    {
        if($files)
        {
            $html = '<ul>';
            
            foreach($files AS $pos => $file)
            {
                $html .= '<li>';
                    $html .= $this->Html->link( substr($file['ubicacion'], strrpos($file['ubicacion'], '/')+1), $url ."/". $file['id'] ."/". $model );
                    
                    if($delete)
                    {
                        $html .= " <a href='javascript:void(0)' class='deletereg' onclick=\" deleteFile(this, '". $file['id'] ."', '$model'); \">". __('Delete'). "</a>";
                    }
                    //$html .= "<input type='hidden' name='data[$model][$pos][ubicacion]' value='". $file['ubicacion'] ."'>";
                $html .= '</li>';
            }
            
            $html .= '</ul>';
            return $html;
        }
    }
    
    public function foto($foto, $replace=null)
    {
        if($foto || true)
        {
            if($foto != '' && file_exists(WWW_ROOT . $foto))
            {            
                //return $this->Html->Image($foto);
                $foto = $this->webroot . $foto;
                return "<img src='$foto' />";
            }
            elseif($replace)
            {
                $foto = $this->webroot . $replace;
                return "<img src='$foto' />";
            }
        }
    }
    
    public function isAjax()
    {
        //return $this->request->params['isAjax'];
        return $this->request->is('ajax');
    }
    
    public function fixed_field($label, $value, $options = array())
    {
        $label= $this->Html->tag("label", $label);
        $value = nl2br( $value != '' ? $value: '&nbsp;' );
        $options['class'] = "fixed_field ". @$options['class'];
        $div_value= $this->Html->tag("div", $value, $options);
        return $this->Html->tag("div", $label . $div_value, array("class"=>"input"));
    }
    
	public function date($label, $options=array(), $type='input')
	{
		return $this->Form->$type($label, $options + array('type' => 'text', 'class' => 'dates', 'readonly' => 'true'));
	}
	
    public function infobox($msg)
    {
         return "<div class='infobox'>$msg</div>"; 
    }    
    
    public function autoComplete($label, $title, $select, $options = array(), $minLength = 3)
    {
        $value = '';
        $dataClass = 'new_data';
        
        if($this->request->data)
        {
            $modelLabel = explode(".", $label);
            $value = @$this->request->data[ $modelLabel[0] ][ $modelLabel[1] ];
        }
        
        if(isset($options['valueHidden']))
        {
            $value = $options['valueHidden'];
            unset( $options['valueHidden'] );
        }
        
        if(isset($options['new_data']) && $options['new_data'] == false)
        {
            $dataClass = 'error_data';
            unset( $options['new_data'] );
        }
                
        $html = $this->Form->input($title, $options + array('value' => @$select[ $value ], 'before' => $this->Form->input($label, array('value' => @$value, 'type' => 'hidden'))));
        
        foreach($select AS $key => $valor)
        {
            $info[] = array('id' => $key, 'value' => trim($valor));//, 'label' => $valor
        }
        
        $textAutoC = ( isset($info) ? json_encode($info) : "''" );
        
        $idHtml = Inflector::camelize( str_replace(".", "_", $label) ) . "[type=hidden]";
        $nameHtml = Inflector::camelize( str_replace(".", "_", $title) );
        $nameUl = Inflector::camelize( str_replace(".", "_", $title) ) . "Ul";
        
        $js = "$( '#$nameHtml' ).bind('keyup', function(){
                    if( $(this).val() == '' || $(this).val().length < $minLength )
                    {
                        $( '#$idHtml' ).val('');
                        $(this).removeClass('$dataClass');
                    }  
                    }).autocomplete({
                    source: $textAutoC,
                    minLength: $minLength,
                    select: function( event, ui ) {
		              $( '#$idHtml' ).val( ui.item.id );//ui.item.value
                    },
                    search: function(event, ui) {
                        //change
                        $( '#$idHtml' ).val('');
                        $(this).removeClass('$dataClass');
                        $('.ui-autocomplete:visible').attr('name', '$nameUl');
                    }
                }).bind('blur', function(){
                    //console.log( $(this).val() );
                    ulObj = $(\"[name='$nameUl']\");
                    if( ulObj.find('li').length == 1 && $(this).val().toUpperCase() == ulObj.find('li a').html().toUpperCase() )
                    {
                        ulObj.find('li a').click();
                        //setTimeout(\" $('.ui-autocomplete').hide(); \", 1000);
                    }
                    
                    if( $(this).val() != '' && $( '#$idHtml' ).val() == '' )
                    {
                        $(this).addClass('$dataClass');
                    }                    
                });";
                
        return $html . $this->Html->scriptBlock($js);
    }
    
    /*
	public function fixed_field($label, $valor)
	{
		$label= $this->Html->tag("label", $label);
		$div_valor= $this->Html->tag("div", $valor, array("class"=>"fixed_field"));
		return $this->Html->tag("div", $label . $div_valor, array("class"=>"input"));
	}
	*/
    
    public function submit_ajax($label=ACCEPT, $jsValidate='validateForm', $options = array())
    {
        $validate = "return $jsValidate(event)";
        
        if( $this->isAjax() )
        {
            return $this->ajaxSubmit($label, $options + array('update' => '#modalWindow', 'beforeSend' => $validate));    
        }
        else
        {
            return $this->Form->submit($label, $options + array('onclick' => $validate) );
        }
    }
    
    public function submit_ajax_url($url, $label=ACCEPT, $jsValidate='validateForm', $options = array())
    {
        if( $this->isAjax() )
        {
            return $this->ajaxSubmit($label, $options + array('update' => '#modalWindow', 'beforeSend' => "return $jsValidate(event)"), $url);    
        }
        else
        {
            return $this->Form->submit($label, $options + array('onclick' => "if($jsValidate(event)){ $('form').last().attr('action', '". $this->Html->url($url) ."'); return true; }else { return false; }") );
        }
    }
    
    public function link_ajax($label, $url, $options=array(), $type=1, $confirmMessage = false, $width='300')
    {
        if($type == 1)
        {
            return $this->link($label, $url, $options, $confirmMessage);
        }
        else
        {
            return $this->ajaxDialog($label, $url, $options, $width);
        }
    }
    
    public function link($label, $url, $options=array(), $confirmMessage = false)
    {
        if($this->validarPermit($url))
        {
             return $this->Html->link($label, $url, $options, $confirmMessage);
        }
    }
    
    public function postLink($label, $url, $options=array(), $confirmMessage = false)
    {
        if($this->validarPermit($url))
        {
             return $this->Form->postLink($label, $url, $options, $confirmMessage);
        }
    }
        
    public function linkRegresar($url, $options=array())
    {
        if($this->validarPermit($url))
        {
             return $this->Html->link(__('[Back]'), $url, $options) ."<br /><br />";
        }
    }
    
    public function linkBookmark($label, $bookMarkName, $options=array(), $confirmMessage = false)
    {
        $bookMark = $this->Session->read("BOOKMARKS.". $bookMarkName);
        $url = "/". $bookMark['url'] .'?'. get_GET( $bookMark['params'] );
        $options['class'] = 'regresar';
        return $this->Html->link($label, $url, $options, $confirmMessage);
    }
    
    public function submit($label=ACCEPT, $jsValidate='validateForm', $options)
    {
        if($this->validarPermit($this->urlForm))
        {
             return $this->Form->submit($label, $options + array('onclick' => "return $jsValidate(event)") );
        }
    }
    
    public function ajaxLink($title, $url, $options=array())
    {
        if(!isset($url["admin"])){
            $url["admin"] = false;
        }
        if($this->validarPermit($url))
        {
             return $this->Js->link($title, $url, $options);
        }
    }
    
    public function linkSubmit($title, $url, $data, $complete, $before=NULL)
    {
        $url = $this->Html->url( $url );
        $onClick = "            
            $.ajax({
                url: '$url',
                type: 'POST',
                data: $data.serialize(),
                beforeSend: function(request, json){ $before },
                complete: function (data, textStatus) { $complete }
            });
        ";
        $html = "<a href='javascript:void(0)' onclick=\" $onClick \"> $title</a>";
        
        return $html;
    }
    
    public function submitLinkAjax($title, $url, $options=array())
    {
        if($this->validarPermit($url))
        {
            $id = $options['update'];
            $url = $this->Html->url( $url );
            $evento = " $.ajax({data: $('$id :input').serialize(), success:function (data, textStatus) { $('$id').html(data); }, type:'post', url:'$url'}); ";
            $html = "<a href='javascript:void(0)' onclick=\" $evento \">". ACCEPT ."</a>";
            return $html;
        }
    }
    
    public function ajaxSubmit($label, $options, $url=false)
    {
        $theUrl = $this->urlForm;
        
        if($url)
        {
            $theUrl = $url;
        }
        //if($this->validarPermit($url))
        if($this->validarPermit($theUrl))
        {
             $options['url'] = $theUrl;
             return $this->Js->submit($label, $options);
        }
    }
    
    public function ajaxDialog($title, $url, $options=array(), $width='0')
    {
        $title = ( isset($options['titulo']) ? $options['titulo'] : $title );
        $options['beforeSend'] = " loadDialog('modalWindow', '$title', $width); ";
        $options['complete'] = " showDialog('modalWindow', XMLHttpRequest.responseText ); ";
        return $this->ajaxLink($title, $url, $options);
    }
    
    public function updateDialog($title, $url, $options=array(), $width='300')
    {
        $options['update'] = '#modalWindow';
        echo $this->Js->link($title, $url, $options);
    }
    
    public function validarPermit($url)
    {
        return true;
        if(isset($url['controller']))
        {
            $controller = $url['controller'];
        }
        else
        {
            $controller = $this->params->params['controller'];
        }
        
        return in_array( array( Inflector::camelize($controller), $url['action'] ), $this->Session->read('permits') );
    }
    
    public function secureEstadoUser($status, $model, $foreignKey)
    {
        $title = __('Inactivo');
        if($status)
        {
            $title = __('Activado');
        }
        return $this->ajaxLink($title, array('controller' => 'secures', 'action' => 'statusUpdate', $model, $foreignKey), 
            array(
                'htmlAttributes' => array(
                    'onclick' => 'tmpA = this',
                ),
                'confirm' => ARE_YOU_SURE,
                'success' => " setMessage('" . __("operation successes") . "', 1); tmpA.text= (tmpA.text=='Inactivo' ? 'Activado' : 'Inactivo')"
            )
        );
    }
    
    public function secureCambiarPasswordUser($model, $foreignKey)
    {
        return $this->ajaxLink(__('Restore password'), array('controller' => 'secures', 'action' => 'passwordReset', $model, $foreignKey), 
            array(                
                'confirm' => ARE_YOU_SURE,
                'success' => " setMessage('" . __("operation successes") . "', 1);"
            )
        );
    }
    
    public function secureSolicitarCambiarPasswordUser($model, $foreignKey)
    {
        return $this->ajaxLink(__('Require password change'), array('controller' => 'secures', 'action' => 'changePasswordRequest', $model, $foreignKey), 
            array(                
                'confirm' => ARE_YOU_SURE,
                'success' => "setMessage('" . __("operation successes") . "', 1);"
            )
        );
    }
    
    public function selectCreate($label, $options, $url, $msj=NEWCREATE)
    {
        $options['after'] = $this->ajaxDialog($msj, $url, array('htmlAttributes' => array('class' => 'new_registro', 'onclick' => 'aTmp = this;')));
        return $this->Form->input($label, $options);
    }
    
    public function actions($actions, $url, $jQueryObj='', $options=array(), $all=true, $label='Select an action')
    {
        $options['empty'] = "--". __($label) ."--";
        $html  = "<div class='actions'>";
        $html .= $this->Form->select('action', $actions, $options);
        
        if($all)
        {
            $html .= "<div class='all'>". $this->Form->checkbox('actions_all', array('hiddenField' => false)) ."  " . __("Select all") . "   </div>";
        }
        
        $html .= "<a class='boton' href='javascript:void(0)' onclick=\" procesarAccion('$jQueryObj', '$url'); \">Confirm</a>";
        $html .= "</div>";
        return $html;
    }
    
    public function smessages($smessage)
    {
        if($smessage)
        {
            if(is_array($smessage))
            {
                $smessage_name = $smessage['Smessage']['name'];
                $msj = $smessage;
            }
            else
            {
                $msj = $this->requestAction("/smessages/smessage/$smessage");
            }
            
            if($msj && $msj['Smessage']['estado'] == 1)
            {
                $retorno = "<div class='help_message'>";
                $html_data = $msj['Smessage']['smessage'];
                
                if($msj['Smessage']['popup'] == 1)
                {
                    $retorno .= $this->ajaxDialog($msj['Smessage']['label'], array('controller' => 'smessages', 'action' => 'getSmessage', $smessage_name));
                }
                else
                {
                    $retorno .= "<div>". nl2br($html_data) ."</div>";
                }
                
                $retorno .= "</div>";
                return $retorno;
            }
        }
    }
    
    function autosave()
    {
        $url = $this->Html->url( array( 'controller' => 'autosaves', 'action' => 'save', $this->params['controller'], $this->params['action'] ) );
        $code = "function autosave(){ $.ajax({async:true, type:'post', url:'". $url ."', data: $('form').serialize()}) }var timer_autosave = setInterval(autosave, ". $this->Session->read('frecuencia_autosave') .")";
        return $this->Html->scriptBlock($code);
    }
    
    public function checkboxAll($class)
    {
        return $this->Form->checkbox('all', array('onclick' => " $('.$class:visible:checkbox').attr('checked', $(this).is(':checked') ); "));
    }
    
    public function checkbox($name, $options=array())
    {
        return $this->Form->checkbox($name, $options + array('hiddenField' => false));
    }
    
    public function labelData($label, $data)
    {
        return "<div><label>$label</label><div>". nl2br($data) ."</div></div>";
    }
        
    public function activar_inactivar($status, $url, $options=array())
    {
        $title = __('Inactivo');
        
        if($status)
        {
            $title = __('Activo');
        }
        
        return $this->ajaxLink($title, $url, 
            $options + array(
                'htmlAttributes' => array(
                    'onclick' => 'tmpA = this',
                ),
                'confirm' => ARE_YOU_SURE,
                'success' => " setMessage('Operación exitosa', 1); tmpA.text= (tmpA.text=='Activo' ? 'Inactivo' : 'Activo')"
            )
        );
    }
    
    
}
?>