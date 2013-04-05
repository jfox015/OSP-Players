<h1 class="page-header"><?php echo lang('statslist_view_header'); ?></h1>
			
<div class="container-fluid">
	<div class="row-fluid rowbg content">
		<div class="span12">
			<h2><?php echo lang('player_title_stats'); ?></h2>
		</div>
	</div>
	<div class="row-fluid rowbg content">
		<div class="span6">
            <?php
            echo form_label("Player Type:", "year", array('style'=>'display: inline-block !important;'));
            ?>
            <div class="btn-group" data-toggle="buttons-radio" style="display: inline-block !important;">
                <button class="btn" rel="type" id="<?php echo TYPE_OFFENSE; ?>">Batting</button>
                <button class="btn" rel="type" id="<?php echo TYPE_SPECIALTY; ?>">Pitching</button>
                <button class="btn" rel="type" id="<?php echo TYPE_DEFENSE; ?>">Fielding</button>
            </div>
		</div>

		<div class="span6" style="text-align:right;">
		<?php
		echo form_open($this->uri->uri_string(), ' method="post" class="form-horizontal"');
		if (isset($years) && sizeof($years) > 0)
		{
			echo form_label("Select Season:", "year", array('style'=>'display: inline-block !important;'))."\n";
			echo '<select name="year" id="year" style="width:auto;">'."\n";
			foreach ($years as $year) 
			{
				echo '<option value="'.$year.'"';
				if (isset($league_year) && $year == $league_year) { echo " selected"; }
				echo '>'.$year.'</option>'."\n";
			}
			echo '</select>'."\n";
		}
		if (isset($teams) && sizeof($teams) > 0) 
		{
			echo form_label("Select Team:", "team_id", array('style'=>'display: inline-block !important;'));
			echo '<select id="team_id" name="team_id" style="width:auto;">'."\n";
			foreach($teams as $team) 
			{
				echo "\t".'<option value="'.$team['team_id'].'"';
				if (isset($team_id) && $team['team_id'] == $team_id) { echo " selected"; }
				echo '>'.str_replace(".","",$team['name']." ".$team['nickname']).'</option>'."\n";
			}
			echo '</select>'."\n";
			?>
            <button class="btn btn-primary" href="#" id="btn_filter">Go</button>
            <?php
		}
		echo form_close()."\n"; 
		?>
		</div>
	</div>
	<div class="row-fluid rowbg content">
		<div class="span12">
		<!-- BATTING -->
		<?php
		if (isset($players_stats)) :
			echo($players_stats);
		endif;
		?>
		</div>
    </div>
</div>

<?php
$url = site_url('/players/stats');
$default_type = TYPE_OFFENSE;
$inline = <<<EOL

    $('#{$type}').addClass('active');

	$("#btn_filter").click(function() {
		var err = null,
		types = $('button[rel="type"]'),
		//statuses = $('button[rel="status"]'),
		type = '',
		status = '',
		year = $('#year').val(),
		team_id = $('#team_id').val();
		$.each(types, function (i, item) {
			if (item.classList.contains('active'))
				type = item.id;
		});
		if (type == '')
		{
			type = '{$default_type}';
		}

		if (err != null)
		{
			$('.notification').html(err);
			$('.notification').css('display','block');
		}
		else
		{
			var url = '{$url}/{$league_id}/'+type+'/'+year+'/'+team_id;
			document.location.href=url;
		}
	});
EOL;

Assets::add_js( $inline, 'inline' );
unset ( $inline );
?>