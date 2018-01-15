<?php echo $this->element('../Secures/submenu2'); ?>
<div class="section">
    <div class="title">        
        <div class="title_label"><?php echo __('Información User'); ?></div>
    </div>
    <?php echo $this->Form->create();?>
    <div class="info">        
            <table>
                <tr>
                    <td><?php echo __('Nombre de user'); ?></td>
                    <td><?php echo $this->Form->input('username', array("label"=>false, 'size' => 30));?></td>
                </tr>                
            </table>
    </div>
    <br clear="all" />
    <?php echo $this->Form->end(ACCEPT);?>
</div>