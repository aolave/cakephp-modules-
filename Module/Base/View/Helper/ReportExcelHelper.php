<?php
class ReportExcelHelper extends AppHelper {
    
    var $helpers = array('Form', 'Javascript', 'Html', 'Paginator', 'Session', 'Ajax', 'Utilities', 'Tabla', 'Filter', 'Js' => array('Jquery'));
    
    function show($reports, $controller, $action, $pass, $type, $name_reports, $msj_no_data = NULL)
    {
        $html = array();
        
        $ths_table = $tds_table = array();
        $options = $reports['options'];
        unset( $reports['options'] );
        $tablas = '';
        //prx($reports);
        
      //  prx($name_reports);
        
        
        foreach($reports AS $report)
        {
            $ths_table = array();
            $tds_table = array();
            
            if(isset($report['header']))
            {
                foreach($report['header'] AS $posX => $trh )
                {
                    $ths = array();
                    
                    foreach($trh AS $posY => $th)
                    {
                        $ths[ $posY ] = $th['format'];
                        $ths[ $posY ]['label'] = $th['value'];
                    }
                    
                    $ths_table[ $posX ] = $ths;
                }
            }
            
            if(isset($report['data']))
            {
                foreach($report['data'] AS $posX => $trd )
                {
                    $tds = array();
                    
                    foreach($trd AS $posY => $td)
                    {
                        $tds[ $posY ] = $td['format'];
                        $tds[ $posY ]['data'] = $td['value'];
                    }
                    
                    $tds_table[ $posX ] = $tds;
                }
            }
            
            $tablas .= $this->Tabla->tabla($ths_table, $tds_table, 'No se encontraron resultados', array(), 1) . "<br />";
        }
        //prx($tds_table);
        
        $html = "<div id='opciones'>";
        $params = "?". $this->Tabla->get_GET($this->params['url']);
        
        if($options['html'])
        {
            $html .= $this->Html->link(__('Listing', true), $this->Filter->getUrl($controller, $action, $pass), array('class' => 'link_listing'));
        }        
        if($options['excel'])
        {
            $html .= $this->Html->link(__('Excel', true), $this->Filter->getUrl($controller, $action, $pass ).'/excel'. $params, array('class' => 'link_excel'));
        }        
        if($options['pdf'])
        {
            //$html[2] .= $this->Html->link(__('PDF', true), $this->Filter->getUrl($controller, $action, $pass ).'/pdf'. $params, array('class' => 'link_pdf'));
        }
        if($options['save'])
        {
            $html .= $this->Html->link(__('Save', true), "#", array('class' => 'link_save', 'onclick' => 'saveReportsFavorito();'));
        }
        
        $html .= "</div>";
        
        return $html . $tablas;
        /*        
        $options = $reports['options'];
        unset($reports['options']);
        $columns = 0;
        $first = true;
        
        foreach($reports[1]['header'][0] AS $tabla)
        {
            $columns += ( isset($tabla['formato']['colspan']) ? $tabla['formato']['colspan'] : 1 );
        }
        
        //sheet
        foreach($reports AS $tabla)
        {
            if($type == 'html' || $type == 'pdf')//html o pdf
            {
                $html[1]  = "<table class='table_page' url_base='". @$this->Paginator->url(array('page' => null)) ."'>";
            }
            elseif($type == 'excel')//excel
            {
                $html[1]  = "<table class='table_page' border='1'>";
            }
            
            $html[1] .= "<thead>";
            $html[2]  = '';
            //options
            if($type == 'html' && $first)
            {
                $html[2] .= "<tr><td colspan='$columns' style='background: none'>";
                $html[2] .= "<div id='opciones'>";
                $first = false;
                
                $params = "?". $this->Tabla->get_GET($this->params['url']);
                
                if($options['html'])
                {
                    $html[2] .= $this->Html->link(__('Listing', true), $this->Filter->getUrl($controller, $action, $pass), array('class' => 'link_listing'));
                }
                
                if($options['excel'])
                {
                    $html[2] .= $this->Html->link(__('Excel', true), $this->Filter->getUrl($controller, $action, $pass ).'/excel'. $params, array('class' => 'link_excel'));
                }
                
                if($options['pdf'])
                {
                    //$html[2] .= $this->Html->link(__('PDF', true), $this->Filter->getUrl($controller, $action, $pass ).'/pdf'. $params, array('class' => 'link_pdf'));
                }
                
                if($options['save'])
                {
                    $html[2] .= $this->Html->link(__('Save', true), "#", array('class' => 'link_save', 'onclick' => 'saveReportsFavorito();'));
                }
                
                $html[2] .= "</div>";
                $html[2] .= "</td></tr>";
            }
            
            $html[3] = '';
            
            //header
            foreach($tabla['header'] AS $trh)
            {
                if(isset($tabla['name']))
                {
                    $html[3] .= "<tr><td>". $tabla['name'] ."</td></tr>";
                }
                
                $html[3] .= "<tr>";
                
                foreach($trh AS $th)
                {
                    $html[3] .= "<th style='". @$th['formato']['style'] ."' class='". @$th['formato']['class'] ."' colspan='". @$th['formato']['colspan'] ."' rowspan='". @$th['formato']['rowspan'] ."'>";
                    $html[3] .= $this->Tabla->getOrdenador($th['value']);
                    $html[3] .= "</th>";
                }
                
                $html[3] .= "</tr>";
            }
            
            $html[3] .= "</thead>";
            $html[3] .= "<tbody>";
            
            if(isset($tabla['data']))
            {
                foreach($tabla['data'] AS $tr)
                {
                    $html[3] .= "<tr>";
                    
                    foreach($tr AS $td)
                    {
                        $class_footer = isset($td['formato']['footer']) ? ' reports_footer' : '';
                        $html[3] .= "<td style='". @$td['formato']['style'] ."' class='". @$td['formato']['class'] ." ".$class_footer."' colspan='". @$td['formato']['colspan'] ."'>";
                        
                        if($type == 'html' && isset($td['formato']['link']))
                        {
                            $html[3] .= $this->Html->link($td['value'], $td['formato']['link'], array('target' => isset($td['format']['target']) ? $td['format']['target'] : ''));
                        }
                        else
                        {
                            if($type == 'html' && isset($td['format']['number_format']))
                            {
                                $html[3] .= getNumberFormat( $td['value'], $td['format']['number_format'] );
                            }
                            else
                            {
                                $html[3] .= $td['value'];
                            }
                        }
                        
                        $html[3] .= "</td>";
                    }
                    
                    $html[3] .= "</tr>";
                }
            }
            elseif($msj_no_data)
            {
                $html[3] .= "<tr><td colspan='$columns'><div class='msg_box'>$msj_no_data</div></td></tr>";
            }
            
            $html[3] .= "</tbody>";
            
            if($type == 'html')
            {
                $html[4]  = "<tfoot>";
                $html[4] .= "<tr><td colspan='$columns' style='background: none'>". @$this->Tabla->getPaginador() ."</td></tr>";
                $html[4] .= "</tfoot>";
            }
            
            $html[5]  = "</table>";
            $html[5] .= $this->Html->scriptBlock("paginador();");
            
            $all_html[] = implode("", $html);
        }
        
        return $this->getResponse($all_html, $type, $name_reports);
        */
    }
    
    function getResponse($html, $type, $name_reports)
    {
        if($type == 'html')
        {
            return implode("<br /><br />", $html);
        }
        elseif($type == 'excel')
        {
            ob_end_clean();
            //error_reporting(0);
            header('Content-type: application/vnd.ms-excel');
            header("Content-Disposition: attachment; filename=$name_reports.xls");
            //header("Pragma: no-cache");
            header("Expires: 0");
            
            echo utf8_decode( (isset($html[0]) ? $html[0] : "") . (isset($html[1]) ? $html[1] : "") . (isset($html[3]) ? $html[3] : "") . (isset($html[5]) ? $html[5] : "") );
        }
        elseif($type == 'pdf')
        {
            App::import('Vendor','xmpdf');
            $xmpdf = new XmPDF();
            //$xmpdf = new XmPDF('', '', 0, '', 10, 10, 20, 10, 3, 3, 'P');
            $css = '<link href="../css/main.css" type="text/css" rel="stylesheet"><link href="../css/layout.css" type="text/css" rel="stylesheet">';
            $xmpdf->SetHTMLFooter('Pág. {PAGENO}', '0');
            $xmpdf->WriteHTML($css . ( $html[1] . $html[3] . $html[5] ) );//
            $xmpdf->Output($name_reports .'.pdf', 'D');//I
        }
    }
}
?>