<?php
App::import('Vendor', 'xjpgraph', array('file' => 'xjpgraph.php'));

class GraficaComponent extends Component
{
    
    function graficaPastel($title, $info)
    {
        //borrar imagenes con mas de 5 minutos
        if ($handle = opendir(JPGRAPH_FOLDER))
        {        
            while (false !== ($file = readdir($handle)))
            {
                if ((time() - filectime(JPGRAPH_FOLDER . $file)) > 300)// 3600 = 60*60*1hora
                {  
                    //if (preg_match('/\.txt$/i', $file))
                    if($file != '.' && $file != '..')
                    {
                        unlink(JPGRAPH_FOLDER . $file);
                    }
                }
            }
        }
        
        if($info)
        {
            foreach($info AS $value)
            {
                $data[] = $value['valor'];
                $labels[] = $value['etiqueta'] . " (". $value['valor'] .")";  //" (%.1f%%)";
            }
            
            $graph = new PieGraph(450, 250);
            $graph->SetShadow();
            $graph->title->Set( strtoupper($title) );        
            $p1 = new PiePlot($data);
            $p1->SetLabels($labels);
            $p1->SetLabelPos(1);
            
            $graph->Add($p1);
            $nameImg = rand(0, 9999) .".png";
            @unlink(JPGRAPH_FOLDER . $nameImg);
            $graph->Stroke(JPGRAPH_FOLDER . $nameImg);
            return $nameImg;
        }
    }
    
}