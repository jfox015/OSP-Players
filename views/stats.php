<h1 class="page-header"><?php echo lang('statslist_view_header'); ?></h1>
			
<div class="container-fluid">
	<div class="row-fluid rowbg content">
		<div class="span12">
			<h2><?php echo lang('player_title_stats'); ?></h2>
		</div>
	</div>
	<div class="row-fluid rowbg content">
		<div class="span12"></div>
	<div class="row-fluid rowbg content">
		
		<div class="span5">
            <?php
            echo form_label("Player Type:", "year", array('style'=>'display: inline-block !important;'));
            ?>
            <div class="btn-group" data-toggle="buttons-radio" style="display: inline-block !important;">
                <button class="btn" rel="type" id="<?php echo TYPE_OFFENSE; ?>">Batting</button>
                <button class="btn" rel="type" id="<?php echo TYPE_SPECIALTY; ?>">Pitching</button>
                <button class="btn" rel="type" id="<?php echo TYPE_DEFENSE; ?>">Fielding</button>
            </div>
		</div>

		<div class="span7" style="text-align:right;">
        <?php
		echo form_open(site_url('/players/stats'), ' id="form_filter" method="post" class="form-horizontal"');
        ?>
        <div id="pos_div" style="display:inline;">
        <?php
        if (isset($position_list[$type]) && sizeof($position_list[$type]) > 0) :
            echo form_label("Position:", "position_id", array('style'=>'display: inline-block !important;'));
            echo '<select id="position_id" name="position_id" style="width:auto;">'."\n";
            echo '<option value="">Allr</option>';
            foreach($position_list[$type] as $id => $val) :
                echo "\t".'<option value="'.$id.'"';
                if (isset($position) && $position == $id) { echo " selected"; }
                echo '>'. $val.'</option>'."\n";
            endforeach;
            echo '</select>'."\n"; ?>
            <?php
        endif;
        ?>
        </div>
        <?php
        if (isset($splits) && sizeof($splits) > 0) :
			echo form_label("Select Split:", "split", array('style'=>'display: inline-block !important;'))."\n";
			echo '<select name="split" id="split" style="width:auto;">'."\n";
			echo '<option value="">Select Split</option>';
            foreach ($splits as $id => $split_name) :
				echo '<option value="'.$id.'"';
				if (isset($split_id) && $id == $split_id) { echo " selected"; }
				echo '>'.lang('full_'.$split_name).'</option>'."\n";
			endforeach;
			echo '</select>'."\n";
		endif;
        if (isset($years) && sizeof($years) > 0) :
			echo form_label("Select Season:", "year", array('style'=>'display: inline-block !important;'))."\n";
			echo '<select name="year" id="year" style="width:auto;">'."\n";
			echo '<option value="">Select Year</option>';
            foreach ($splits as $split) :
				echo '<option value="'.$year.'"';
				if (isset($league_year) && $year == $league_year) { echo " selected"; }
				echo '>'.$year.'</option>'."\n";
            endforeach;
			echo '</select>'."\n";
        endif;
		if (isset($teams) && sizeof($teams) > 0) :
			echo form_label("Select Team:", "team_id", array('style'=>'display: inline-block !important;'));
			echo '<select id="team_id" name="team_id" style="width:auto;">'."\n";
            echo '<option value="">Select Team</option>';
            foreach($teams as $team) :
				echo "\t".'<option value="'.$team['team_id'].'"';
				if (isset($team_id) && $team['team_id'] == $team_id) { echo " selected"; }
				echo '>'.str_replace(".","",$team['name']." ".$team['nickname']).'</option>'."\n";
			endforeach;
			echo '</select>'."\n"; ?>
            <?php
		endif;
        ?>
        <input type="hidden" name="type" id ="type" value="<?php echo($type); ?>" />
        <button class="btn btn-primary" href="#" id="btn_filter">Go</button>
        <?php
            echo form_close()."\n";
		?>
		</div>
	</div>
	<div class="row-fluid rowbg content">
		<div class="span12"><?php echo (form_close()); ?> </div>
	</div>
	<div class="row-fluid rowbg content">
		<div class="span12">
		<!-- BATTING -->
		<?php
		if (isset($players_stats)) :
			echo('<b>'.$player_count.' Players Found.</b><br />');
            echo($players_stats);
		else:
            echo lang('players_no_players');
        endif;
		?>
		</div>
    </div>
</div>

<?php
$url = site_url('/players/stats');
$type_offense = TYPE_OFFENSE;
$type_defense = TYPE_DEFENSE;
$type_speciality = TYPE_SPECIALTY;
$types = array(TYPE_OFFENSE, TYPE_DEFENSE, TYPE_SPECIALTY);
$array_js = "var position_list = {};";

foreach ($types as $pos_type) {
    if (isset($position_list[$pos_type])) {
        $array_js .= " var ".$pos_type." = new Array(".sizeof($position_list[$pos_type]).");\n";
        $count = 0;
        foreach ($position_list[$pos_type] as $id => $pos) {
            $array_js .= $pos_type."[".$count."] = '".$id."|".$pos."';\n";
            $count++;
        }
    }
    $array_js .=  "position_list.".$pos_type." = ".$pos_type.";\n";
}

$inline = <<<EOL

    {$array_js}
    $('#{$type}').addClass('active');

	$('button[rel="type"]').click(function() {
        type = this.id;
        var newOptions = null, el = $("#position_id");
        if (type != '' && position_list[type] && position_list[type].length > 0) {
            el.empty(); // remove old options
            var newOptions =  position_list[type];
            $.each(newOptions, function(key, value) {
            var pair = value.split("|");
            el.append($("<option></option>")
                .attr("value", pair[0]).text(pair[1]));
            });
            $('#pos_div').css('display','inline-block');
        } else {
            $('#pos_div').css('display','none');
        }
	});
	$("#btn_filter").click(function() {
		types = $('button[rel="type"]'),
		$.each(types, function (i, item) {
			if (item.classList.contains('active'))
				type = item.id;
		});
		if (type == '')
		{
			type = '{$type_offense}';
		}
		$('#type').val(type);
		$('#form_filter').submit();
	});
EOL;

Assets::add_js( $inline, 'inline' );
unset ( $inline );
?>