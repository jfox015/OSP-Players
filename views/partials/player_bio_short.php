			<div class="player-bio-short">
				<h3><?php 
				echo($details['first_name']." ".$details['last_name']." ");
				?></h3>
				<br />
				<?php if (isset($details['position']) && !empty($details['position'])) : 
					if ($player['position'] == 1) { $pos = $player['role']; } else { $pos = $player['position']; } 
					echo(get_pos($pos,$positions)."&nbsp;"); 				
				endif; ?> 
				<?php if (isset($details['number']) && !empty($details['number'])) : ?>
				<b>#<?php echo($details['number']); ?></b>
				<?php endif; ?>
				<br />
				<b><?php echo lang('player_team'); ?>:</b> <a href="<?php echo($settings['osp.asset_url']); ?>teams/team_<?php echo($details['team_id']); ?>.html" target="_blank"><?php echo(" ".$details['team_name']." ".$details['teamNickname']); ?></a>
			</div>
			