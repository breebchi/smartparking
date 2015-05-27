<!-- File: /app/View/Phones/index.ctp -->

<h1>Spots DB</h1>
<p><?php echo $this->Html->link('Add Spot', array('action' => 'add')); ?></p>
<table>
    <tr>
        <th>id</th>
        <th>spot_name</th>
		<th>spot_domain</th>
		<th>status</th>
        <th>Actions</th>
        <th>Created</th>
    </tr>

<!-- Here's where we loop through our $phones array, printing out phone info -->

    <?php foreach ($spots as $spot): ?>
    <tr>
        <td><?php echo $spot['Spot']['id']; ?></td>
        <td>
            <?php
                echo $this->Html->link(
                    $spot['Spot']['spot_name'],
                    array('action' => 'view', $spot['Spot']['id'])
                );
            ?>
        </td>
		<td><?php echo $spot['Spot']['spot_domain']; ?></td>
		<td><?php echo $spot['Spot']['status']; ?></td>
        <td>
            <?php
                echo $this->Form->postLink(
                    'Delete',
                    array('action' => 'delete', $spot['Spot']['id']),
                    array('confirm' => 'Are you sure?')
                );
            ?>
            <?php
                echo $this->Html->link(
                    'Edit', array('action' => 'edit', $spot['Spot']['id'])
                );
            ?>
        </td>
        <td>
            <?php echo $spot['Spot']['created']; ?>
        </td>
    </tr>
    <?php endforeach; ?>

</table>