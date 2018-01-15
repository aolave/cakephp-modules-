<?php
class TablaHelper extends AppHelper
{
	public $helpers= array("Html", "Form", "Javascript", "Ajax", "Ojax", "Paginator", "Js", 'Session');
	
    /** table */
    function tabla($ths, $tds, $msj_no_data=NULL, $tfs=array(), $class_over=0, $hideColumns=false, $params = array(), $classTable = "", $hidepaginator = false)
    {
        $class_over_tr = '';
        if($class_over)
        {
            $class_over_tr = 'over_tr';
        }
        
        $idTabla = rand(1, 1000);
        $table  = "<table class='table_page $classTable' id='tabla_$idTabla'>";//url_base='". @$this->Paginator->url(array('page' => null)) ."'
        /*
        $this->Paginator->options(array('url' => array("?" => $this->get_GET($this->params['url']))));
        if($type == 'ajax')
        {
            $this->Paginator->options['update'] = "#". $div_id;
            $this->Paginator->options['evalScripts'] = true;
        }
        */
        if($ths)
        {
            $filas = 0;
            foreach($ths[0] AS $th)
            {
                $filas += isset($th['colspan']) ? $th['colspan'] : 1;
            }
            $table .= "<thead>";
            if($hideColumns)
            {
                $table .= "<tr>";
                $table .= "<th id='hideC' colspan='". $filas ."'>";                
                $table .= "<div>";
                $table .= "<div id='elemHide'><a href='javascript:showHideTable()'>Columnas</a></div>";
                $table .= "<div id='tablaHide'><ul>";
                $pos = 1;
                
                foreach($ths AS $trh)
                {
                    foreach($trh AS $th)
                    {
                        $table .= "<li><input type='checkbox' checked='true' onclick='hideShowColumn(". $pos++ .", this)' />&nbsp;". $th['label'] ."</li>";
                    }
                }
                $table .= "</ul></div>";
                $table .= "</div>";
                $table .= "</th>";
                $table .= "</tr>";
            }
            
            foreach($ths AS $trh)
            {
                $table .= "<tr>";
                
                foreach($trh AS $th)
                {
					$style = isset($th['style']) ? 'style="'.$th['style'].'"' : '';
                    $table .= "<th ".$style." class='". @$th['class'] ."'  colspan='". @$th['colspan'] ."' rowspan='". @$th['rowspan'] ."'>"; 
                    $table .= $this->getOrdenador(@$th['label'], @$th['ordenar']);
                    
                    if(@$th['filter'])
                    {
                        $table .= "<input type='text' class='filterText' onKeyUp=' textFilter(this); '>";
                    }
                    
                    $table .= "</th>";
                }
                
                if(isset($params['delete']) && $params['delete'])
                {
                    $table .= "<th></th>"; 
                }
                
                $table .= "</tr>";
            }
            
            $table .= "</thead>";
        }
        
        if($tds)
        {
            if(!isset($filas))
            {
                @$filas = count( $tds[0] );
            }
            
            $table .= "<tbody>";
            
            foreach($tds AS $trd)
            {
                //prx($tds);
                $table .= "<tr class='$class_over_tr ". @$trd['class'] ."' style='". @$trd['style'] ."' id='". @$trd['id'] ."'>";
                unset( $trd['style'] );
                unset( $trd['class'] );
                unset( $trd['id'] );
                
                foreach($trd AS $td)
                {
					$class    = isset($td['class']) ? $td['class'] : '';                    
					$class   .= ( isset($td['editable']) && $td['editable'] ) ? 'celda_editable' : '';
					$style   = isset($td['style']) ? 'style="'.$td['style'].'"' : '';
                    $required = isset($td['required']) ? 'required="'.$td['required'].'"' : '';
					$colspan = isset($td['colspan']) ? 'colspan="'.$td['colspan'].'"' : '';
                    $rowspan = isset($td['rowspan']) ? 'rowspan="'.$td['rowspan'].'"' : '';
                    $indice = isset($td['indice']) ? 'indice="'.$td['indice'].'"' : '';
                    $tipo = isset($td['tipo']) ? $td['tipo'] : 0;
					
                    //$this->_parseAttributes($options);
                    
					$js_actions = '';
					if(isset($td['editable']) && $td['editable']) {
						$js_actions = "onDblClick=\" makeCellEditable(this, '". $td['method'] ."', '". $tipo ."'); \"";
					}
					
                    $table .= "<td class='".$class."' ".$style." ".$required." ".$colspan." ".$js_actions." ".$indice." ".$rowspan.">";
                    
                    if(@$td['number_format'])
                    {
                        $table .= getNumberFormat(@$td['data'], $td['number_format']);
                    }
                    elseif(@$td['link'])
                    {
                        $table .= $this->Html->link(@$td['data'], $td['link'], array('target' => $td['target']));
                    }
                    else
                    {
                        $table .= @$td['data'];
                    }
                    
                    $table .= "</td>";
                }
                
                if(isset($params['delete']) && $params['delete'])
                {
                    $table .= "<td><a class='deletereg' href='javascript:void(0);' onclick='deleteregFila(this);'>". __('Delete') ."</a></td>";
                }
                
                $table .= "</tr>";
            }
            
            $table .= "</tbody>";            
        }
        elseif($msj_no_data)
        {
            $table .= "<tbody><tr><td colspan='$filas'>";
            $table .= "<div class='msg_box'>$msj_no_data</div>";
            $table .= "</td></tr></tbody>";
        }
        //foot
        if($tfs)
        {
            $table .= "<tfoot>";
            
            foreach($tfs AS $trd)
            {
                $table .= "<tr style='". @$trd['style'] ."'>";
                unset( $trd['style'] );
                
                foreach($trd AS $td)
                {
					$class    = isset($td['class']) ? $td['class'] : '';
					$style    = isset($td['style']) ? 'style="'.$td['style'].'"' : '';
					$colspan  = isset($td['colspan']) ? 'colspan="'.$td['colspan'].'"' : '';
										
                    $table .= "<td class='".$class."' ".$style." ".$colspan.">";
                    
                    if(@$td['number_format'])
                    {
                        $table .= getNumberFormat(@$td['data'], $td['number_format']);
                    }
                    else
                    {
                        $table .= @$td['data'];
                    }
                    
                    $table .= "</td>";
                }
                
                $table .= "</tr>";
            }
            
            $table .= "</tfoot>";
		}
		
        if($tds && !$hidepaginator)//
        {
            $table .= "<tfoot><tr><td colspan='$filas' style='background: none'>";
            $table .= @$this->getPaginador();
            $table .= "</td></tr></tfoot>";
        }
        
        $table .= "</table>";
        
        if(isset($params['add']) && $params['add'])
        {
            $table .= "<br /><a class='adicionar' href='javascript:void(0);' onclick=\"adicionarFila('tabla_$idTabla');\">". __('Nueva fila') ."</a>";
        }
        
        if(isset($params['order']) && $params['order'] != '')
        {
            $table .= "<script> $('#tabla_$idTabla').tableDnD({ onDragClass: 'dndDrag', onDrop: function(table, row){ ". $params['order'] ."(table, row); } }); </script>";
        }
        
        //$table .= $this->Html->scriptBlock("paginador();");
        return $table;
    }
    
    function getOrdenador($label, $ordenar=false)
    {
        if($ordenar)
        {
            return $this->Paginator->sort($ordenar, $label, array('class' => 'paginar orden', ));
        }
        else
        {
            return $label;
        }
    }
    
    function getPaginador()
    {
        @$number_results = $this->Paginator->counter(array("format" => __("{:count}",true)));
        
        if($number_results)
        {
            $paginator = "<div class='info_paginar'><span class='numero_resultados'> ". __("Results") ." (".$number_results.")</span>";
    		
            if($this->Paginator->numbers() != ''){
            
                $paginator .= $this->Paginator->first('<<', array('class'=>'paginar inicio', 'onclick' => 'gotoURL(false, "page", this.innerHTML);'));
                
                if($this->Paginator->hasPrev())
                {
                    $paginator .= $this->Paginator->prev("<", null, null, array('class'=>'paginar antes', 'onclick' => 'gotoURL(false, "page", this.innerHTML);')); 
                }
                
    			$paginator .= $this->Paginator->numbers(array('separator' => '&nbsp;&nbsp;', 'modulus' => 5, 'class' => 'paginar numeros', 'onclick' => 'gotoURL(false, "page", this.innerHTML);'));

                if($this->Paginator->hasNext())
                {
                    $paginator .= $this->Paginator->next(">", null, null, array('class' => 'paginar despues'));
                }
                
                $paginator .= $this->Paginator->last('>>', array('class'=>'paginar ultimo')); 
            }
            
            $paginator .= $this->getSelect();
            return $paginator;
       }
    }
    
    private function getSelect()
    {
        $cant_registros = array(10 => 10, 20 => 20, 50 => 50, 100 => 100);        
        $amount = isset($this->params->query['limit']) ? $this->params->query['limit'] : $this->Session->read('setting.paginador');

        $select  = "<div class='paginador'>" . __("Show") . ":";
        $select .= "<select name='limit' onChange='gotoURL(false, \"limit\", this.value);'>";
        
        foreach($cant_registros AS $registro)
        {
            $selected = '';
            if($registro == $amount)
            {
                $selected = "selected='selected'";
            }
			$select .= "<option $selected value='". $registro ."'>". $registro ."</option>";
        }
        
        $select .= "</select>";
        $select .= __("results per page") . "</div></div>";
        return $select;
    }
    
    public function get_GET($urls)
    {
        return get_GET($urls);
    }
}
?>