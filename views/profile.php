<?php
if (!isset($details) || !is_array($details) || count($details) == 0) : ?>
<div class="container-fluid">
	<div class="row-fluid">
		<div class="span12">
		<h1><?php echo(lang('player_profile_title')); ?></h1>
		
		<?php echo lang('player_profile_not_found'); ?>
		</div>
	</div>
</div>
<?php
else :
?>
	<!-- Begin profile Display -->
<div class="container-fluid">
	<div class="row-fluid rowbg content">
		<div class="span1">
            <?php
            if (file_exists($settings['osp.players_img_path'].'player_'.$details['player_id'].'.png')) {
                $player_img = $settings['osp.players_img_url'].'player_'.$details['player_id'].'.png';
            }
            else
            {
                $player_img = $settings['osp.asset_url'].'images/default_player_photo.png';
            }
            echo "<img src='".$settings['osp.players_img_url']."default_player_photo.jpg'>"
            ?>
		</div>
		<div class="span10">
			<h2>
			<?php 
			echo($details['first_name']." ".$details['last_name']." ");  
			if ($details['position'] != 1) {
				echo(get_pos($details['position'])); 
			} else { 
				echo(get_pos($details['role'])); 
			}
			?>
			</h2><br />
			 <b>Team:</b> <a href="<?php echo($settings['osp.asset_url']); ?>teams/team_<?php echo($details['team_id']); ?>.html" target="_blank"><?php echo(" ".$details['team_name']." ".$details['teamNickname']); ?></a>
			| <b>Nickname:</b> <?php echo($details['playerNickname']); ?>
			<br /> 
			<b>Height/Weight:</b> <?php echo(cm_to_ft_in($details['height'])); ?>/<?php echo($details['weight']); ?> lbs
			| <b>Bats/Throws:</b> <?php echo(get_hand($details['bats'])); ?>/<?php echo(get_hand($details['throws'])); ?>
			<br /><b>Age:</b> <?php echo($details['age']); ?> | <b>Birthdate:</b> <?php echo(date("F j, Y",strtotime($details['date_of_birth']))); ?>
			| <b>Birthplace: </b> <?php echo($details['birthCity'].", ".$details['birthRegion']." ".$details['birthNation']); ?>
			<br />
			<b> Drafted:</b> <?php 
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
			<a href="<?php echo($settings['osp.asset_url']); ?>players/player_<?php echo($details['player_id']); ?>.html">OOTP Player Page</a>
			
		</div>
		<div class="span1">
			<a href="<?php echo($settings['osp.asset_url']); ?>teams/team_<?php echo($details['team_id']); ?>.html" target="_blank"><img src="<?php echo($settings['osp.team_logo_url'].$teams[$details['team_id']]['logo_file']); ?>" /></a>
		</div>
	</div>
</div>
	<!-- Show Stats -->
<div class="row-fluid rowbg content">
		<div class="span12">
		<!-- CAREER -->
		<?php
		if (isset($career)) :
			echo($career);
		endif;
		?>
		<!-- EXTENDED -->
		<?php
		if (isset($extended)) :
			echo($extended);
		endif;
		?>
		</div>
    </div>
	
<?php 
endif;
?>