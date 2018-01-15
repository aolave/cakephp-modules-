<div>
    <strong><?php echo __('Modulo a configurar'); ?> :</strong>
    <?php echo $this->Form->select('modulo', $modulos_data, array('value' => $modulo_id, 'style' => 'display:inline', 'empty' => EMPTY_SELECT, 'onchange' => "ReloadPage(this, 'settings/index');")); ?>
</div>
<br clear="all" />
<?php if(isset($modulos)): ?>
    <?php echo $this->Form->create('Setting', array('action' => 'save')); ?>
        <fieldset>
            <legend><?php echo $modulos[0]['Setting']['modulo']; ?></legend>
            <ul class="lista_2">
                <?php $pos = 0; foreach($modulos AS $modulo): ?>
                    <li>
                        <div><?php echo $modulo['Setting']['nombre']; ?>:</div>
                        <?php
                            //dependiendo del tipo se arma el valor a mostrar
                            echo $this->Form->hidden('Setting.'. $pos .'.id', array('value' => $modulo['Setting']['id']));
                            $name = 'Setting.'. $pos++ .'.valor';
                            //checkbox
                            if($modulo['Setting']['tipo'] == 1) {
                                //
                                echo $this->Form->checkbox($name, array('checked' => ($modulo['Setting']['valor']==1) ));
                            }
                            //select
                            elseif($modulo['Setting']['tipo'] == 2) {
                                //
                                $data = json_decode($modulo['Setting']['lista'], true);
                                echo $this->Form->select($name, $data, array('value' => $modulo['Setting']['valor'], 'empty' => false));
                            }
                            //text
                            elseif($modulo['Setting']['tipo'] == 3) {
                                //
                                echo $this->Form->text($name, array('value' => $modulo['Setting']['valor'] ));
                            }
                        ?>
                        <p><?php echo $modulo['Setting']['description']; ?></p>                    
                    </li>
                <?php endforeach; ?>
            </ul>
        </fieldset>
        <br />
    <?php echo $this->Form->end( ACCEPT ); ?>
<?php endif; ?>
<?php //echo $this->Utilities->autosave(); ?>