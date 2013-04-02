		<?php 
		$player_url = "players/player_".$player_id.".html";
		if (file_exists($settings['osp.asset_path'].$player_url)) :
		?>
		<a href="<?php echo($settings['osp.asset_url'].$player_url); ?>">Player&#039;s Game Page</a>
		<?php
		endif;
		?>