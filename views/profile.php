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
			</h2>
			<br />
				<!-- PLAYER BIO DETAILS -->
			<?php echo $this->load->view('players/partials/player_bio',array('settings'=>$settings, 'details'=>$details, 'teams'=>$teams),true); ?>
			<br />
				<!-- PLAYER LINK PARTIAL -->
			<?php echo $this->load->view('players/partials/player_link',array('settings'=>$settings, 'player_id'=>$details['player_id']),true); ?>
			
		</div>
		<div class="span1">
			<a href="<?php echo($settings['osp.asset_url']); ?>teams/team_<?php echo($details['team_id']); ?>.html" target="_blank"><img src="<?php echo($settings['osp.team_logo_url'].$teams[$details['team_id']]['logo_file']); ?>" /></a>
		</div>
	</div>
</div>
	<!-- Show Current Stats -->
<div class="row-fluid rowbg content">
	<div class="span12">
		<?php echo $this->load->view('players/partials/stats_bar',array('statYear'=>$year, 'player_stats'=>$current),true); ?>
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