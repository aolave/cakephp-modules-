<table class="table_page">
    <tr>
        <td><?php echo __('Date'); ?></td>
        <td style="white-space: nowrap;"><?php echo $this->Time->format('d-m-Y H:i:s', $outputTray['OutputTray']['created']); ?></td>
    </tr>
    <tr>
        <td><?php echo __('User'); ?></td>
        <td><?php echo $outputTray['OutputTray']['user_system']; ?></td>
    </tr>
    <tr>
        <td><?php echo __('From'); ?></td>
        <td><?php echo $outputTray['OutputTray']['de']; ?></td>
    </tr>
    <tr>
        <td><?php echo __('To'); ?></td>
        <td><?php echo $outputTray['OutputTray']['para']; ?></td>
    </tr>
    <tr>
        <td><?php echo __('Subject'); ?></td>
        <td><?php echo $outputTray['Template']['asunto']; ?></td>
    </tr>
    <tr>
        <td><?php echo __('Message'); ?></td>
        <td><?php echo $outputTray['OutputTray']['smessage']; ?></td>
    </tr>
</table>