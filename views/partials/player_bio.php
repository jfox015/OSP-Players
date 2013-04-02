			<b>Team:</b> <a href="<?php echo($settings['osp.asset_url']); ?>teams/team_<?php echo($details['team_id']); ?>.html" target="_blank"><?php echo(" ".$details['team_name']." ".$details['teamNickname']); ?></a>
			| <b>Nickname:</b> <?php echo($details['playerNickname']); ?>
			<br /> 
			<b>Height/Weight:</b> <?php echo(cm_to_ft_in($details['height'])); ?>/<?php echo($details['weight']); ?> lbs
			| <b>Bats/Throws:</b> <?php echo(get_hand($details['bats'])); ?>/<?php echo(get_hand($details['throws'])); ?>
			<br /><b>Age:</b> <?php echo($details['age']); ?> | <b>Birthdate:</b> <?php echo(date("F j, Y",strtotime($details['date_of_birth']))); ?>
			| <b>Birthplace: </b> <?php echo($details['birthCity'].", ".$details['birthRegion']." ".$details['birthNation']); ?>
			<br />
			<b> Drafted:</b> 
			<?php 
			if ($details['draft_team_id'] != 0) {
				echo ordinal_suffix($details['draft_pick'],1)." pick in the ".ordinal_suffix($details['draft_round'],1)." round of the ";
				if ($details['draft_year']==0) {echo "inaugural";} else {echo $details['draft_year'];}
				echo " draft by the ";
				if (!isset($teams[$details['draft_team_id']]['name'])) {
					$draftTeam = "Non existent or deleted team";
				} else {
					$draftTeam = $teams[$details['draft_team_id']]['name'];
				}
				if ($details['draft_year']==0) {echo $teams[$details['draft_team_id']]['name'];} else {echo $draftTeam;}
			}
			?>
			<br />