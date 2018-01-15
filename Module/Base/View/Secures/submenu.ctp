<?php
    $arrSubMenu[] = array('controller' => 'secures', 'action' => 'users');
    $arrSubMenu[] = array('controller' => 'secures', 'action' => 'index');
    
    if(RESTRICT_IP)
    {
        $arrSubMenu[] = array('controller' => 'secures', 'action' => 'ips');
    }
    
    echo $this->Menu->submenus('', $arrSubMenu);
?>