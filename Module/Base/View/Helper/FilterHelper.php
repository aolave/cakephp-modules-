<?php
class FilterHelper extends AppHelper
{    
    var $helpers = array('Form', 'Javascript', 'Html', 'Paginator', 'Session', 'Ajax', 'Utilities', 'Js' => array('Jquery'));
    
    function show($filters, $div_id, $controller, $action, $pass = array(), $visible=false)
    {
        if(isset($filters) && isset($filters['filters']) && $filters['filters'])
        {
            $html  = "<div id='form_filter'>";
            $html .= "<div class='search'><a href='javascript:void(0)' onclick=\" $('#filters').toggle(); \">". __("Filters"). "</a></div>";
            //display
            $display = ( ($visible || isset($this->params->query[SEARCH]) || @$filters['filters'][ key($filters['filters']) ]['required'] == 1 ) ? 'inline' : 'none' );//block
            $html .= "<fieldset id='filters' style='display: $display'>";
            //$html .= "<legend>". __('Filters', true) ."</legend>";
            $html .= "<ul>";
            $texto = ( isset($this->params->query['filter']) ? implode(";", array_keys($this->params->query['filter'])) : '' );
            
            foreach($filters['filters'] AS $id => $filter)
            {
                if(isset($filter['integrated']))
                {
                    $html .= "<li class='integrated'>";
                }
                else
                {
                    $html .= "<li>";    
                }
                
                if(@$filter['required'] == 1)
                {
                    $html .= "<label class='required'>";
                }
                else
                {
                    $html .= "<label>";
                }
                         
                $html .= $filter['label'] ."</label>";
                
                if(isset($filter['integrated']) && stripos($texto, $id) !== false)
                {
                    $html .= "<a href='javascript:void(0)' class='remove-filter' onclick=\" $(this).parent().find('.filterLi li').detach();  $('#filter').click(); \"> </a>";
                }
                
                if(@$filter['required'] == 1)
                {
                     $html .= "<div class='filterLi required'>". $this->getHtmlValues( $id, $filter ) ."</div>";
                }
                else
                {
                    $html .= "<div class='filterLi'>". $this->getHtmlValues( $id, $filter ) ."</div>";
                }
                
              
                
                $html .= "</li>";
            }
            
            $html .= "<li>";
            //$html .= "<label>&nbsp;</label>";
            $html .= "<div class='submitform'>";
            //$url = $this->Paginator->url(array('page' => null));
            $html .= $this->Html->link(__('Search', true), "javascript:void(0)", array('id' => 'filter', 'onclick' => "filter('". $filters['type'] ."', '$div_id')" ));//, '". $url ."'
            $html .= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
            $html .= $this->Html->link(__('Clean Up', true), '#', array('id' => 'limpiar', 'onclick' => " return limpiar(); "));
            $html .= "</div>";
            $html .= "</li>";
            
            $html .= "</ul>";
            $html .= "</fieldset>";
            $html .= "</div><script> setFormatDates('.date'); </script>";
            return $html;
        }
    }
    
    function getUrl($controller, $action, $pass)
    {
        return $this->Html->url( array('controller' => $controller, 'action' => $action, implode("/", $pass) ), true );
    }
    
    private function getNameInflector($name)
    {
        return Inflector::camelize( str_replace(".", '_', $name) );
    }
    
    private function getHtmlValues($id, $filter, $options = array())
    {
        if($filter['tipo'] == 'checkbox' && isset($filter['integrated']))
        {
            $html = '<ul>';
            $pos = 0;
            
            foreach($filter['datos'] AS $values)
            {
                $id2 = $values['id'];
                $idCheck = $id .".". $id2;
                $checked = @( $this->request->query[ SEARCH ][ $idCheck ] == 1 );
                $label = $values['name'] ." (". $values['cantidad']. ")";
                $display = '';
                
                if($pos++ == QUANTITY_VALUES_MORE_FILTER)
                {
                    $html .= "<li class='more-text' onclick=\" $(this).parent().find('li').show(); $(this).detach(); \"> more... </li>";
                }
                
                if($pos > QUANTITY_VALUES_MORE_FILTER)
                {
                    $display = "style='display: none'";
                }
                
                $html .= "<li $display>". $this->Form->checkbox( $idCheck, $options + array('checked' => $checked, 'name' => SEARCH .'['. $idCheck .']', 'class' => '_sh_filter', 'hiddenField' => false ) ) . "&nbsp;<span>$label</span>&nbsp;&nbsp;</li>";            
            }
            
            $html .= '</ul>';
            return $html;
        }
        elseif($filter['tipo'] == 'textTag')
        {
            $code  = "<div class='tagFilter'>";
            $code .= $this->Utilities->autoCompleteTag( SEARCH .'['.$id.']' );
            $code .= $this->Form->radio('word_type', array(1 => 'It requires all keywords', 2 => 'It requires any of the words'), array('name' => 'filter[word.type]', 'default' => 1, 'value' => @$this->params->query['filter']['word.type'], 'legend' => false, 'class' => '_sh_filter'));
            $code .= "</div>";
            return $code; 
        }
        elseif($filter['tipo'] == 'select')
        {

            if($filter['placeholder']){
                $empty = $filter['label'];
            }
            else{
                $empty = EMPTY_SELECT;
            }
            if(isset($filter['required']) && $filter['required'] == 1)
            {
                $empty = NULL;
            }
            
            //se trunca
            $valuesSelect = $filter['values'];
            
            foreach($valuesSelect AS $pos => $dataS)
            {
                $valuesSelect[ $pos ] = substr( $dataS, 0, 100 );
            }            
            
            return $this->Form->select( $id, $valuesSelect, $options + array('class' => '_sh_filter', 'value' => ( isset($filter['default']) ? $filter['default'] : NULL ), 'name' => SEARCH .'['.$id.']', 'empty' => $empty) );
        }
        elseif($filter['tipo'] == 'text' || $filter['tipo'] == 'textLike')
        {

			if($filter['placeholder']){
				$placeholder = $filter['label'];
			}
			else{
				$placeholder = '';
			}
			
            return $this->Form->text( $id, $options + array('class' => '_sh_filter', 'value' => @$this->params->query[ SEARCH ][ $id ]/*( isset($filter['default']) ? $filter['default'] : NULL )*/, 'name' => SEARCH .'['.$id.']', 'placeholder' => $placeholder ));
        }        
        elseif($filter['tipo'] == 'autocomplete')
        {
            $filter['tipo'] = 'select';
            
            $opts = array('style' => 'display: none');
            $opti = array();
            
            if(isset($filter['selectShow']) && $filter['selectShow'] == 1)
            {
                $opts = array();
                $opti = array('style' => 'display: none');
            }
            
            $code  = $this->getHtmlValues($id, $filter, $opts);
            $filter['tipo'] = 'text';
            $id2 = $id ."_auto";
            $code .= $this->getHtmlValues($id2, $filter, $opti);
            $id = $this->getNameInflector($id);
            $id2 = $this->getNameInflector($id2);
            $code .= "<script>setAutocomplete('$id2', '$id');</script>";
            return $code;
        }
        elseif($filter['tipo'] == 'autocompleteSelect')
        {
            $filter['tipo'] = 'autocomplete';
            $filter['selectShow'] = 1;
            $code  = $this->getHtmlValues($id, $filter);
            $id2 = $id ."_auto";
            $id = $this->getNameInflector($id);
            $id2 = $this->getNameInflector($id2);
            $code .= "&nbsp;<a href='javascript:void(0)' texto='1' style='display: inline-block;' onclick=\" cambiarAutoComplete('$id2', '$id', this); \">Búsqueda por texto</a>";
            return $code;
        }
        elseif($filter['tipo'] == 'date')
        {
            $idI = $id . "_inicio";
            $idF = $id . "_fin";
            $code  = $this->Form->text( $idI, $options + array('class' => 'fecha _sh_filter', 'value' => (isset($this->params['url']['filter'][$idI]) ?$this->params['url']['filter'][$idI] : NULL), 'name' => SEARCH .'['.$idI.']' ) ) ."<script>$('#$idI').datepicker( {dateFormat: 'yy-mm-dd'} );</script>";
            $code .= " - ";//__("<strong> hasta: </strong>", true);
            $code .= $this->Form->text( $idF, $options + array('class' => 'fecha _sh_filter', 'value' => (isset($this->params['url']['filter'][$idF]) ?$this->params['url']['filter'][$idF] : NULL), 'name' => SEARCH .'['.$idF.']' ) ) ."<script>$('#$idF').datepicker( {dateFormat: 'yy-mm-dd'} );</script>";
            return $code;
        }
        elseif($filter['tipo'] == 'oneDate')
        {
            $code  = $this->Form->text( $id, $options + array('class' => 'fecha _sh_filter', 'value' => (isset($this->params['url']['filter'][$id]) ?$this->params['url']['filter'][$id] : NULL), 'name' => SEARCH .'['.$id.']' ) ) ."<script>$('#$id').datepicker( {dateFormat: 'yy-mm-dd'} );</script>";
            return $code;
        }
        elseif($filter['tipo'] == 'radio')
        {
            $valuesSelect = $filter['values'];
            
            foreach($valuesSelect AS $pos => $dataS)
            {
                $valuesSelect[ $pos ] = substr( $dataS, 0, 100 );
            }            
            
            return $this->Form->radio( $id, $valuesSelect, $options + array('class' => '_sh_filter', 'legend' => false, 'hiddenField' => false, 'value' => ( isset($filter['default']) ? $filter['default'] : 0 ), 'name' => SEARCH .'['.$id.']') );
        }
        elseif($filter['tipo'] == 'checkbox')
        {
            $code = '';
            
            foreach($filter['values'] AS $id2 => $values)
            {
                $idCheck = $id ."_". $id2;
                $checked = @( $this->request->query[ SEARCH ][ $idCheck ] == $id2 );
                $code .= $this->Form->checkbox( $idCheck, $options + array('checked' => $checked, 'name' => SEARCH .'['. $idCheck .']', 'class' => '_sh_filter', 'hiddenField' => false ) ) . "&nbsp;<span>$values</span>&nbsp;&nbsp;";
            }
            
            return $code;
        }
        elseif($filter['tipo'] == 'checkboxTrue')
        {   
            $checked = @( $this->request->query[ SEARCH ][ $id ] == 1 );
            return $this->Form->checkbox( $id, $options + array('checked' => $checked, 'name' => SEARCH .'['. $id .']', 'class' => '_sh_filter', 'hiddenField' => false ) );
        }
        
    }
    
    
    function showAjax($filters, $visibility = false)
    {
        if(isset($filters) && isset($filters['filters']) && $filters['filters'])
        {
			$visibility  = ( $visibility==true ) ? 'block' : 'none';
            $html  = "<div id='form_filter'>";
            $html .= "<div class='search'><a href='javascript:void(0)' onclick=\" $('#filters').toggle(); \">". __("Filters"). "</a></div>";
            $html .= "<fieldset id='filters' style='display:".$visibility."'>";
            $html .= "<ul>";
            $texto = ( isset($this->params->query['filter']) ? implode(";", array_keys($this->params->query['filter'])) : '' );
    
            foreach($filters['filters'] AS $id => $filter)
            {
                if(isset($filter['integrated']))
                {
                    $html .= "<li class='integrated'>";
                }
                else
                {
                    $html .= "<li>";
                }
    
                if(@$filter['required'] == 1)
                {
                    $html .= "<label class='required'>";
                }
                else
                {
                    $html .= "<label>";
                }
                 

				if($filter['placeholder']){
					  $html .= "</label>";
				} 
				else{
					 $html .= $filter['label'] . "</label>";
				}

                if(isset($filter['integrated']) && stripos($texto, $id) !== false)
                {
                    $html .= "<a href='javascript:void(0)' class='remove-filter' onclick=\" $(this).parent().find('.filterLi li').detach();  $('#filter').click(); \"> </a>";
                }
    
               
                if(@$filter['required'] == 1)
                {
                    $html .= "<div class='filterLi required'>". $this->getHtmlValues( $id, $filter ) ."</div>";
                }
                else
                {
                   $html .= "<div class='filterLi'>". $this->getHtmlValues( $id, $filter ) ."</div>";
                }
                
                
                $html .= "</li>";
            }
            $html .= "<li>";
            $html .= "<div class='submitform'>";
            $html .= $this->Html->link(__('Search', true), "javascript:void(0)", array('id' => 'filter', 'onclick' => "admin_gridReload()" )); //actions , '". $url ."'
            $html .= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
            $html .= $this->Html->link(__('Clean Up', true), '#', array('id' => 'limpiar', 'onclick' => " return limpiar(); "));
            $html .= "</div>";
            $html .= "</li>";
            $html .= "</ul>";
            $html .= "</fieldset>";
            $html .= "</div><script> setFormatDates('.date'); </script>";
            return $html;
        }
    }


 }
