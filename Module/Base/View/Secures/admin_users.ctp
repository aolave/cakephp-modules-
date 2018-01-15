<?php echo $this->element('../Secures/submenu'); ?>
<?php echo $this->Utilities->ajaxDialog(__('New User'), array('controller' => 'secures', 'action' => 'saveUser', 0, 0), array('class' => 'adicionar')); ?>
<?php echo $this->Filter->show( $filters, $this->params['controller'], $this->params['controller'], $this->params['action'], $this->params['pass'] ); ?>
<br />
<?php

    /* cabecera */
    $ths = array();   
    $ths[]= array("label"=> $this->Utilities->checkboxAll('usrs'));
    $ths[]= array("label"=>__("Id", true), 'ordenar' => 'User.id');
    $ths[]= array("label"=>__("User", true), 'ordenar' => 'User.username');
    $ths[]= array("label"=>__("User type", true), 'ordenar' => 'Group.name');
    $ths[]= array("label"=>__("Email", true), 'ordenar' => 'User.email');
    $ths[]= array("label"=>__("Date last entry", true));
    $ths[]= array("label"=>__("Actions", true));
    
    $ths_table[0] = $ths;
	$tds_table= array();
	
	//prx($listing);

	foreach($listing as $data)
	{
		$td= array();
        
        $action_view = $this->Utilities->ajaxDialog(__('View'), array('controller' => 'secures', 'action' => 'viewUser', $data['User']['id']));
        $action_edit = $this->Utilities->ajaxDialog(__('Modify'), array('controller' => 'secures', 'action' => 'saveUser', $data['User']['id'], 0));
        $action_password = $this->Utilities->ajaxDialog(__('Change password'), array('controller' => 'secures', 'action' => 'changePassword', $data['User']['id']));
        $action_delete = $this->Utilities->link(__('Remove'), array('controller' => 'secures', 'action' => 'deleteUser', $data['User']['id'], 'users'), array('class' => 'deletereg'), __('You are sure to delete the user: ') . $data['User']['username'] .'?');      
       
        $user_action_status = $this->Utilities->secureEstadoUser($data['User']['estado'], 0, $data['User']['id']);
        
        $action_restore_user_pw = $this->Utilities->secureCambiarPasswordUser(0, $data['User']['id']);
        $action_changed_user_pw = $this->Utilities->secureSolicitarCambiarPasswordUser(0, $data['User']['id']);
        //
        $td[] = array('data' => $this->Utilities->checkbox('user.'. $data['User']['id'], array('class' => 'usrs')), 'class' => 'center');
        $td[] = array('data' => $data['User']["id"]);
        $td[] = array('data' => $data['User']["username"]);
        $td[] = array('data' => $data['Group']["name"]);
        $td[] = array('data' => $data['User']["email"]);
        $td[] = array('data' => $data['User']["ultimo_ingreso"]);
        //$td[] = array('data' => $action_view . $action_edit . $action_restore_user_pw . $action_changed_user_pw . $action_password . $action_delete . $user_action_status, 'class' => 'actions_td');
        //$td[] = array('data' => $action_view . $action_edit . $action_restore_user_pw . $action_changed_user_pw . $action_password . $user_action_status, 'class' => 'actions_td');
        $td[] = array('data' => $action_view . $action_edit . $action_password . $action_delete .  $user_action_status, 'class' => 'actions_td');
         
		$tds_table[] = $td;
    }
    
    echo $this->Tabla->tabla($ths_table, $tds_table, NO_RESULTS, array(), 1, 0);
?>
<?php echo $this->Utilities->actions($actions, "secures/changes", '.usrs'); ?>