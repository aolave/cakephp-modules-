<?php echo $this->Form->create($Template->getController(), array('id' => 'form_template', 'type' => 'file')); ?>
<fieldset class="template_fieldset">
    <legend>Archivo a Importar</legend>
    <?php if( !$Template->isValidaciones() ): ?>
        <span style="font-weight: bold;">Archivo : </span>
        <?php echo $this->Form->file('Archivo.file', array('after' => 'pn', 'style' => 'display: inline; border: none;', 'onblur' => "LimitAttach(this,7);")); ?>
        <?php echo $this->Form->submit('upload File', array('div' => array('style' => 'display: inline; padding-left: 30px; float: none;'))); ?>
        <br clear="all" /><br clear="all" />
        <span style="font-style: italic;">* The file must be loaded Excel (.xls) and have the format described below</span>
        <br clear="all" />        
        <?php echo $this->Template->imprimirTemplate( $Template->getFormatoTemplate(), $Template->getFormatosArchivos(), $this->action ); ?>
    <?php endif; ?>    
    <?php echo $this->Form->input('TemporaryFile', array('type' => 'hidden', 'value' => $Template->getTemporaryFile()) ); ?>    
    <?php if( $Template->isValidaciones() ): ?>
        <?php echo $this->Template->imprimirValidaciones( $Template->getValidaciones(), $Template->getFormatoTemplate() ); ?>
    <?php endif; ?>    
</fieldset>