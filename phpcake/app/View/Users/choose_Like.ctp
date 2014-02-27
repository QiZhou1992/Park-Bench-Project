<h1>choose the one you like</h1>
<table>
	<?php foreach($result as $person):?>
			<?php 
			App::import('vendor','Facebook',array('file'=>'facebook.php'));
			 $config = array(
             'appId' => '492159944228947',
             'secret' => '0e2a701f336a22e90cfdb452b0f4765f',
             'allowSignedRequest' => false // 
              );
				$params = array(
	            'method' => 'fql.query',
	           'query' => "SELECT name,pic_big,url FROM profile WHERE id={$person['id']}"
	         );
			  $facebook=new Facebook($config);
	         $data= $facebook->api($params);
			?>
			<tr>
			<td><?php echo $data[0]['name'];?> <br> <?php echo $this->Html->link('visit his Facebook',$data[0]['url'])?></td>
			<td><?php echo $this->Html->image($data[0]['pic_big'])?></td>
			</tr>
	
	<?php endforeach; ?>
</table>