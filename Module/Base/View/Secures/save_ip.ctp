<?php if(isset($ver)): ?>
    <td><?php echo $ipAllowed['ipAllowed']['ip']; ?></td>
    <td><?php echo getStatus( $ipAllowed['ipAllowed']['estado'] ); ?></td>
    <td>
        <?php echo $this->Js->link(__('Editar'), array('controller' => 'secures', 'action' => 'saveIp', $ipAllowed['ipAllowed']["id"]), array('update' => '#dato_'. $ipAllowed['ipAllowed']["id"])); ?>
        <?php echo $this->Js->writeBuffer(); ?>
    </td>
    <script>
        setMessage("<?php echo messages('SUCCESS'); ?>", 1);
        $("#dato_").attr('id', 'dato_<?php echo $ipAllowed['ipAllowed']["id"]; ?>');
    </script>
<?php else: ?>
    <td>
        <?php echo $this->Form->input('ipAllowed.id'); ?>
        <?php echo $this->Form->input('ipAllowed.ip', array('div' => false, 'label' => false, 'style' => "width: 500px")); ?>
    </td>
    <td>
        <?php echo $this->Form->input('ipAllowed.estado', array('div' => false, 'label' => false)); ?>
    </td>
    <td>
        <?php echo $this->Utilities->submitLinkAjax(ACCEPT, array('action' => 'saveIp', @$this->data['ipAllowed']['id']), array('update' => '#dato_'. @$this->data['ipAllowed']['id'])); ?>
    </td>
<?php endif; ?>