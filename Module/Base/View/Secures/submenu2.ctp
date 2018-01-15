<?php
    $arrSubMenu[] = array('controller' => 'secures', 'action' => 'contrasena');
    
    if(CHANGE_USERNAME)
    {
        $arrSubMenu[] = array('controller' => 'secures', 'action' => 'username');
    }
    
    if(USE_QUESTION)
    {
        $arrSubMenu[] = array('controller' => 'secures', 'action' => 'preguntas');
    }
    
    echo $this->Menu->submenus('', $arrSubMenu);
?>