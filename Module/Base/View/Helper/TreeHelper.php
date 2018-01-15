<?php
App::uses('HtmlHelper', 'View/Helper');

class TreeHelper extends AppHelper 
{
	public $helpers = array('Utilities', 'Html');
    
    public function organigrama($ul_id, $datas, $estiloMethod)
    {
        $html = "<ul id='$ul_id' style='display:none'>";
        $html .= $this->getTreeOrganigrama($datas, $tmp, $estiloMethod);
        $html .= "</ul><div id='chart'></div>";
        $html .= $this->Html->scriptBlock("$('#$ul_id').jOrgChart({ chartElement: '#chart', dragAndDrop: false }); 
                                           $('.node').slice(1).click();
                                           $('#$ul_id').detach();");//, depth: 3
        
        return $html;
    }
    
    public function treeview($ul_id, $datas, $width='650', $collapse=false, $admin = false)
    {
		$tmp = '';
        $html  = "<div style='width: ". $width ."px;'>";
        $html .= "<ul id='$ul_id' class='filetree treeview-famfamfam'>";
        $html .= $this->getTree($datas, $tmp, $admin);
        $html .= "</ul></div>";
        
        if($collapse)
        {
            $html .= $this->Html->scriptBlock("$('#$ul_id').treeview({collapsed: true});");//{, unique: true, animated:'slow', persist: 'location'}'
        }
        else
        {
            $html .= $this->Html->scriptBlock("$('#$ul_id').treeview();");//{collapsed: true, unique: true, animated:'slow', persist: 'location'}'
        }
        
        return $html;
    }
    
    private function getTree($datas, &$html='', $admin = false)
    {
        foreach($datas AS $data)
        {
            $html .= "<li id='". @$data['id'] ."' class='". @$data['class_li'] ."'>";
            $html .= "<div class='filehover ". $data['class'] ."'>";
            $html .= "<span class='". $data['class_label'] ."'>". $data['label'] . "</span>";
            $html .= "<span id='". @$data['span2_id'] ."' class='". $data['class_accions'] ."'>";
            
            foreach($data['actions'] AS $action)
            {
                $method = $action['type'];
                $confirm = isset($action['confirm']) ? $action['confirm'] : false;
                
                if(isset($action['label_acc']))
                {
                    $action['url']['admin'] = $admin;
                    if($method == 'link')
                    {
                        $html .= $this->Utilities->$method( $action['label_acc'], $action['url'], $action['options'], $confirm);
                    }
                    else
                    {
                        $html .= $this->Utilities->$method( $action['label_acc'], $action['url'], $action['options']);//, $width
                    }
                }
                else
                {
                    $html .= $this->Utilities->$method( $this->Html->image($action['img']['src'], $action['img']['options']), $action['url'], $action['options'] );
                }
            }
            
            $html .= "</span></div>";
            $html .= "<ul>";
            
            if($data['children'])
            {
                $this->getTree($data['children'], $html, $admin);
            }
            
            $html .= "</ul>";            
            $html .= "</li>";
        }
        
        return $html;
    }
    
    private function getTreeOrganigrama($datas, &$html='', $estiloMethod)
    {
        foreach($datas AS $data)
        {
            $html .= "<li id='". @$data['id'] ."' class='". @$data['class_li'] ."'>";
            $html .= "<div class='div_organigrama ". $data['class'] ."'>";
            $html .= "<div class='". $data['class_label'] ."'>". $this->$estiloMethod( $data['label'] ) . "</div>";
            
            $html .= "<div class='org_info'>";
            $cantidad = count($data['children']);
            $html .= "<div>". ( $cantidad > 0 ? "[". $cantidad ."]" : "" ) ."</div>";
            $html .= "<div><span class='opciones'></span>";
            $html .= "<div class='". $data['class_accions'] ."'>";
            $html .= "<ul id='". @$data['span2_id'] ."'>";
            
            foreach($data['actions'] AS $action)
            {
                $method = $action['type'];
                $confirm = isset($action['confirm']) ? $action['confirm'] : false;
                
                if(isset($action['label_acc']))
                {
                    if($method == 'link')
                    {
                        $html .= "<li>". $this->Utilities->$method( $action['label_acc'], $action['url'], $action['options'], $confirm) ."</li>";
                    }
                    else                    
                    {
                        $html .= "<li>". $this->Utilities->$method( $action['label_acc'], $action['url'], $action['options']) ."</li>";//, $width
                    }
                }
                else
                {
                    $html .= "<li>". $this->Utilities->$method( $this->Html->image($action['img']['src'], $action['img']['options']), $action['url'], $action['options'] ) ."</li>";
                }
            }
            
            $html .= "</ul></div></div></div></div>";
            $html .= "<ul>";
            
            if($data['children'])
            {
                $this->getTreeOrganigrama($data['children'], $html, $estiloMethod);
            }
            
            $html .= "</ul>";            
            $html .= "</li>";
        }
        
        return $html;
    }
    
    private function estiloPuesto($data)
    {
        $html  = "<div class='colaborador vacante'>Vacante</div>";
        
        if($data['Puesto']['colaborador_id'])
        {
            $html  = "<div class='colaborador'>". $data['Colaborador']['name'] ."</div>";
        }
        
        $html .= "<div class='cargo'>". $data['Cargo']['name'] ."</div>";
        $html .= "<div class='area'>". $data['Area']['name'] ."</div>";
        $html .= "<div class='gerencia'>". $data['Gerencia']['name'] ."</div>";
        $html .= "<div class='empresa'>". $data['Empresa']['name'] ."</div>";
        return $html;
    }

}