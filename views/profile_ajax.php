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
		<div class="span10">
				<!-- PLAYER BIO DETAILS -->
			<?php 
			echo $this->load->view('players/partials/player_bio_short',array('settings'=>$settings, 'details'=>$details, 'teams'=>$teams),true); ?>
			<br />
			<?php 
			echo $this->load->view('players/partials/player_injury_report',array('details'=>$details),true); 
			?>
		</div>
	</div>
</div>
	<!-- Show Current Stats -->
<div class="row-fluid rowbg content">
	<div class="span12">
		<?php echo $this->load->view('players/partials/stats_bar',array('statYear'=>$year, 'player_stats'=>$current),true); ?>
	</div>
</div>
<div class="row-fluid rowbg content">
    <div class="span12"><br />&nbsp;</div>
</div>
<div class="row-fluid rowbg content">
    <div class="span12"><br />
		<!-- PLAYER LINK PARTIAL -->
		<?php echo $this->load->view('players/partials/player_link',array('settings'=>$settings, 'player_id'=>$details['player_id']),true); ?></div>
</div>
<?php 
endif;
?>