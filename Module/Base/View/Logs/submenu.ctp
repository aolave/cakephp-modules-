<?php
    $arrSubMenu[] = array('controller' => 'logs', 'action' => 'index');
    $arrSubMenu[] = array('controller' => 'logs', 'action' => 'statistics');
    echo $this->Menu->submenus('', $arrSubMenu);
?>