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
		<div class="span2">
           <?php echo $this->load->view('players/partials/player_img',array('settings'=>$settings, 'details'=>$details),true); ?> 
		</div>
		<div class="span8">
				<!-- PLAYER BIO DETAILS -->
			<?php echo $this->load->view('players/partials/player_bio_full',array('settings'=>$settings, 'details'=>$details, 'teams'=>$teams, 'positions' => $position_list),true); ?>
			<br />
				<!-- PLAYER LINK PARTIAL -->
			<?php echo $this->load->view('players/partials/player_link',array('settings'=>$settings, 'player_id'=>$details['player_id']),true); ?>
		</div>
		<div class="span2">
			<a href="<?php echo($settings['osp.asset_url']); ?>teams/team_<?php echo($details['team_id']); ?>.html" target="_blank"><img src="<?php echo($settings['osp.team_logo_url'].$teams[$details['team_id']]['logo_file']); ?>" /></a>
		</div>
	</div>
</div>
<div class="row-fluid rowbg content">
    <div class="span12"><br />&nbsp;</div>
</div>
<?php
if (isset($in_season) && $in_season === true) :  ?>
	<!-- Misc Info -->
<div class="row-fluid rowbg content">
	<div class="span6">
		<?php
		echo $this->load->view('players/partials/player_recent_games',array('details'=>$details, 'recent_games'=>$recent_games),true);
        ?>
    </div>
    <div class="span6">
		<?php
        echo $this->load->view('players/partials/player_upcoming_games',array('details'=>$details, 'teams' => $teams, 'settings' =>$settings, 'awards'=>$upcoming_games),true);
		?>
	</div>
</div>
<?php endif; ?>
<div class="row-fluid rowbg content">
    <div class="span8">
        <?php echo $this->load->view('players/partials/stats_bar',array('statYear'=>$year, 'player_stats'=>$current),true); ?>
    </div>
    <div class="span4">
		<?php echo $this->load->view('players/partials/player_injury_report',array('details'=>$details),true); 
		echo("<br />");
		echo $this->load->view('players/partials/player_facts',array('details'=>$details, 'teams' => $teams, 'awards'=>$awards),true); ?>
	</div>
</div>

<!-- Misc Info -->
<div class="row-fluid rowbg content">
    <div class="span12"><br />&nbsp;</div>
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