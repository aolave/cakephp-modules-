<?php

/**
 * MenuHelper
 *
 */
class MenuHelper extends AppHelper
{
    public $helpers = array('Paginator', 'Form', 'Session', 'Html', 'Utilities');
         
    public function show()
    {
        $menus = $this->Session->read('menues');
        $code = "<div id='menu'><ul>";
        
        foreach($menus AS $menu)
        {            
            $in = false;
            
            if($menu['Menu']['controller'] != '')
            {
                $code_tmp = "<li id='". $menu['Menu']['controller'] ."-". $menu['Menu']['action'] ."' class='". @$menu['Menu']['class'] ."'>";
                $code_tmp .= $this->Html->link(__($menu['Menu']['name']), array('controller' => $menu['Menu']['controller'], 'action' => $menu['Menu']['action'], "admin" => true), array('title' => $menu['Menu']['smessage']));
                $in = true;
            }
            else
            {
                $code_tmp = "<li class='". @$menu['Menu']['class'] ."'>";
                $code_tmp .= "<a>". __($menu['Menu']['name']) ."</a>";
            }
            
            if(isset($menu['children']) && $menu['children'])
            {
                $code_tmp .= "<ul>";
                
                foreach($menu['children'] AS $submenu)
                {
                    if($submenu['Menu']['redirect'] != '')
                    {
                        $url = explode("/", $submenu['Menu']['redirect']);
                        $code_tmp .= "<li>". $this->Html->link(__($submenu['Menu']['name']), array('controller' => $url[0], 'action' => $url[1], "admin" => true), array('title' => $submenu['Menu']['smessage'])) ."</li>";
                    }
                    else
                    {
                        $code_tmp .= "<li>". $this->Html->link(__($submenu['Menu']['name']), array('controller' => $submenu['Menu']['controller'], 'action' => $submenu['Menu']['action'], "admin" => true), array('title' => $submenu['Menu']['smessage'])) ."</li>";
                    }
                    
                    $in = true;
                }
                
                $code_tmp .= "</ul>";
            }
            
            $code_tmp .= "</li>";
            
            if($in)
            {
                $code .= $code_tmp;
            }
        }
        
        $code .= "</ul></div>";
        return $code;
    }
    
    public function route_url()
    {
        $route_urls = $this->Session->read('route_urls');
        $route_url = @$route_urls[ $this->params->params['controller'] ][ $this->params->params['action'] ];
        $code = '';
        
        for($i=0; $i < count($route_url); $i++)
        {
            $code .= "<div class='nodo'>";
            //prx($route_url);
            if(MIGAS_LINK && $route_url[ $i ]['url'] != '/' && ($i+1) != count($route_url))
            {
                $code .= $this->Html->link($route_url[ $i ]['label'], "/". $route_url[ $i ]['url'], array("admin"=>true, "class" => "cesar"));
            }
            else
            {
                $code .= $route_url[ $i ]['label'];
            }
            
            $code .= "</div>";
            
            if($i+1 != count($route_url))
            {
                $code .= "<div class='separator'></div>";
            }
        }
        return $code;
    }
    
    public function submenus($title, $menues) {
        //menu
        $html  = "<div class='menu_titulo'>";
        //si hay titulo
        if($title) {
            $html .= "<div class='titulo'>". $title ."</div>";
        }
        //menues
        $html .= "<div class='menus'><ul>";
        $route_urls = $this->Session->read('route_urls');
        //li
        foreach($menues AS $menu) {
            //
            $action = array('controller' => $menu['controller'], 'action' => $menu['action']);
            
            if(isset($menu['label']))
            {
                $label = $menu['label'];
            }
            else
            {
                if(isset($route_urls[ $menu['controller'] ][ $menu['action'] ]))
                {
                    $route_url = $route_urls[ $menu['controller'] ][ $menu['action'] ];
                    $label = __( $route_url[ count($route_url)-1 ]['label'] );
                }
                else
                {
                    $label = ucfirst( $menu['action'] );
                }
            }
            
            if(isset($menu['?'])) {
                $action['?'] = $menu['?'];
            }
            if( $action['controller'] == $this->params->params['controller'] && $action['action'] == $this->params->params['action'] && !isset($menu['force']))
            {
                $html .= "<li id='". $action['controller'] ."-". $action['action'] ."' class='menu_act'><div>". $label ."<em></em></div></li>";
            }
            else
            {
                if(isset($menu['type']) && $menu['type'] == 'ajaxDialog') {

                    $html .= "<li id='". $menu['controller'] ."-". $menu['action'] ."'><div>".$this->Utilities->ajaxDialog(
                                                            $label,
                                                            array( 'controller' => $menu['controller'], 'action' => $menu['action'], @$menu['urlpars']),
                                                            (isset($menu['extras']) ? $menu['extras'] : array()),
                                                            isset($menu['width']) ? $menu['width'] : '0'
                                                            ) .'</div></li>'; 
                    
                } else {
                    $action += isset($menu['params']) ? $menu['params'] : array();
                    //$html .= "<li>". $this->Utilities->link($menu['label'], $action) ."</li>";
                    $image = isset($menu['image']) ? $this->Html->image($menu['image'], array('align' => 'absmiddle')).' ' : '';
                    if(isset($menu['urlpars'])) {
                        $action = array_merge($action, explode("/", $menu['urlpars']) );
                    }
                    $menu['options'] = array("admin" => true);
                    $html .= "<li id='". $menu['controller'] ."-". $menu['action'] ."'><div>". $image.$this->Utilities->link( $label, $action, @$menu['options'], @$menu['message']) ."</div></li>";
                }
            }
        }
        //
        $html .= "</ul></div>";
        $html .= "</div><br clear='all' />";
        //
        //prx($html);
        return $html;
    }

}