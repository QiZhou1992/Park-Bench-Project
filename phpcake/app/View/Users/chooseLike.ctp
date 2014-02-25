<h1>It is a website for secret crush</h1>
<h3>The hottest male</h3>
<table>
	<tr>
		<th>name</th>
		<th>be liked times</th>
	</tr>
	<?php foreach($UsersMale as $user):?>
			<tr>
				<td><?php echo $user['User']['name'] ?>
				<td><?php echo $user['User']['beLiked'] ?>
			</tr>
	
	<?php endforeach; ?>
</table>

<h3>The hottest female</h3>
<table>
	<tr>
		<th>name</th>
		<th>be liked times</th>
	</tr>
	<?php foreach($UsersFemale as $user):?>
			<tr>
				<td><?php echo $user['User']['name'] ?>
				<td><?php echo $user['User']['beLiked'] ?>
			</tr>
	
	<?php endforeach; ?>
</table>
<table>
	<tr>
		<td><?php echo $this->Form->create('Recipe') ?></td>
	</tr>
</table>


