<?php echo $this->Form->create(); ?>
<?php if(USE_QUESTION): ?>
    <?php foreach($preguntasSecretas AS $pregunta): ?>
        <?php echo $this->Form->input('pregunta.'. $pregunta, array('type' => 'password', 'autocomplete' => 'off', 'size' => 46, 'label'=>false, "before"=>"<label>". $pregunta ."?</label>")); ?>
    <?php endforeach; ?>
<?php endif; ?>
<?php echo $this->Form->end(ACCEPT); ?>