			<div class="player-bio">
				<h1><?php
				echo($details['first_name']." ".$details['last_name']." ");
				?></h1>
				<br />
				<?php if (isset($details['playerNickname']) && !empty($details['playerNickname'])) : ?>
                <b><?php echo lang('player_nickname'); ?>:</b> <?php echo($details['playerNickname']);
                endif;
                ?>
				<div class="line-divider"></div>
				<?php if (isset($details['uniform_num']) && !empty($details['uniform_num'])) : ?>
				<b>#</b><?php echo($details['uniform_num']); ?>
				<?php endif; ?>
				<?php if (isset($details['position']) && !empty($details['position'])) :
					if ($details['position'] == 1) { $pos = $details['role']; } else { $pos = $details['position']; }
					echo("<b>".get_pos($pos,$positions)."</b>");
				endif; ?>
				<b><?php echo lang('player_bats_throws'); ?>:</b> <?php echo(lang('full_'.get_hand($details['bats'],$hands))); ?>/<?php echo(lang('full_'.get_hand($details['throws'],$hands))); ?>
				
				<b><?php echo lang('player_team'); ?>:</b> <a href="<?php echo($settings['osp.asset_url']); ?>teams/team_<?php echo($details['team_id']); ?>.html" target="_blank"><?php echo(" ".$details['team_name']." ".$details['teamNickname']); ?></a><br />
				
				<b><?php echo lang('player_birthday'); ?>:</b> <?php echo(date("F j, Y",strtotime($details['date_of_birth']))); ?> (<b><?php echo lang('player_age'); ?>:</b> <?php echo($details['age']); ?>)<br />
				
				<b><?php echo lang('player_birthplace'); ?>: </b> <?php echo($details['birthCity'].", ".$details['birthRegion']." ".$details['birthNation']); ?>
				<br />
				<!-- TODO: Experience in years -->
				<b><?php echo lang('player_height_weight'); ?>:</b> <?php echo(cm_to_ft_in($details['height'])); ?>/<?php echo($details['weight']." ".lang('player_pounds')); ?> 
			</div>