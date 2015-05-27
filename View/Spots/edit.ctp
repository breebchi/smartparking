<!-- File: /app/View/Phones/edit.ctp -->

<h1>Edit Spot</h1>
<?php
echo $this->Form->create('Spot');
echo $this->Form->input('spot_name');
echo $this->Form->input('spot_domain');
echo $this->Form->input('status');
echo $this->Form->input('id', array('type' => 'hidden'));
echo $this->Form->end('Save Spot');
?>