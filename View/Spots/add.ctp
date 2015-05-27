<!-- File: /app/View/Phones/add.ctp -->

<h1>Add Spot</h1>
<?php
echo $this->Form->create('Spot');
echo $this->Form->input('spot_name');
echo $this->Form->input('spot_domain');
echo $this->Form->input('status');
echo $this->Form->end('Save Spot');
?>