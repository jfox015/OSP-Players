			<b><?php echo lang('player_team'); ?>:</b> <a href="<?php echo($settings['osp.asset_url']); ?>teams/team_<?php echo($details['team_id']); ?>.html" target="_blank"><?php echo(" ".$details['team_name']." ".$details['teamNickname']); ?></a>
			| <b><?php echo lang('player_nickname'); ?>:</b> <?php echo($details['playerNickname']); ?>
			<br /> 
			<b><?php echo lang('player_height_weight'); ?>:</b> <?php echo(cm_to_ft_in($details['height'])); ?>/<?php echo($details['weight']." ".lang('player_pounds')); ?> 
			| <b><?php echo lang('player_bats_throws'); ?>:</b> <?php echo(get_hand($details['bats'])); ?>/<?php echo(get_hand($details['throws'])); ?>
			<br /><b><?php echo lang('player_age'); ?>:</b> <?php echo($details['age']); ?> | <b><?php echo lang('player_birthday'); ?>:</b> <?php echo(date("F j, Y",strtotime($details['date_of_birth']))); ?>
			| <b><?php echo lang('player_birthplace'); ?>: </b> <?php echo($details['birthCity'].", ".$details['birthRegion']." ".$details['birthNation']); ?>
			<br />
			<b><?php echo lang('player_drafted'); ?>:</b> 
			<?php 
			if ($details['draft_team_id'] != 0) {
				echo ordinal_suffix($details['draft_pick'],1)." ".lang('player_pick_in')." ".ordinal_suffix($details['draft_round'],1)." ".lang('player_round_of')." ";
				if ($details['draft_year']==0) { echo lang('player_inaugural'); } else { echo $details['draft_year']; }
				echo " ".lang('player_draft_by')." ";
				if (!isset($teams[$details['draft_team_id']]['name'])) {
					$draftTeam = lang('player_team_nonexistent');
				} else {
					$draftTeam = $teams[$details['draft_team_id']]['name'];
				}
				if ($details['draft_year']==0) {echo $teams[$details['draft_team_id']]['name'];} else {echo $draftTeam;}
			}
			?>
			<br />