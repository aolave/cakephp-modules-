<?php echo $this->element('../Secures/submenu2'); ?>
<div class="infobox"><?php echo __('Por favor conteste al menos '. NUMBER_QUESTIONS .' preguntas de este listing y recuerde no compartirlas con nadie'); ?></div>
<br />
<?php echo $this->Form->create(); ?>
<div class="section sectionorden" style="width: 750px;">
    <div class="info">
        <?php            
            $pos = 1;
            //
            foreach($preguntas AS $id => $pregunta)
            {
                echo $this->Form->input('pregunta.'. $id, array('label' => $pos++ .". ". $pregunta ."?", 'value' => @$respuestas[ $pregunta ] ));                
            }
        ?>
    </div>
    <?php echo $this->Utilities->submit_ajax(); ?>
</div>
<?php echo $this->Form->end(); ?>