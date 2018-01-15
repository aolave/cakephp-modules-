<?php echo $this->element('../Secures/submenu2'); ?>
<br />
<div class="section" style="width: 500px;">
    <?php echo $this->Form->create();?>
    <div class="info">        
            <table>
                <tr>
                    <td><?php echo __('Current password'); ?></td>
                    <td><?php echo $this->Form->input('old_password', array("label"=>false, 'size' => 30, "div" => false, "type"=>"password", 'autocomplete' => 'off'));?></td>
                </tr>
                <tr>
                    <td><?php echo __('New password'); ?></td>
                    <td><?php echo $this->Form->input('new_password', array("label"=>false, 'size' => 30, "div" => false, "type"=>"password", 'autocomplete' => 'off'));?></td>
                </tr>
                <tr>
                    <td><?php echo __('Confirm password'); ?></td>
                    <td><?php echo $this->Form->input('new_password2', array("label"=>false, 'size' => 30, "div" => false, "type"=>"password", 'autocomplete' => 'off'));?></td>
                </tr>
            </table>
    </div>
    <br clear="all" />
    <?php echo $this->Form->end(ACCEPT);?>
</div>