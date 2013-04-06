<!-- Begin profile Display -->
<div class="container-fluid">
    <div class="row-fluid rowbg content">
        <div class="span12">
           <h2>Players List</h2>
            <br />&nbsp;
        </div>
    </div>
    <div class="row-fluid rowbg content">
        <div class="span6">
            <div id="optionsAlpha" class="subOptionsBar">
                <ul>
                    <?php
                    for ($i = 65; $i < 91; $i++) {
                        echo('<li>'.anchor('players/playerlist/'.$league_id.'/alpha/'.chr($i),chr($i)).'</li>');
                    } ?>
                </ul>
            </div>
        </div>
        <div class="span6">
            <?php echo form_open($this->uri->uri_string(), 'class="form-vertical"'); ?>
            <label class="searchlabel" for="searchTerm">Search for Player:</label>
            <input type="text" name="searchTerm" id="searchTerm" value="<?php if (isset($searchTerm)) { echo($searchTerm); } ?>" />
            <input type="submit" name="submit" id="submit" class="btn btn-mini" value="<?php echo lang('button_action_search') ?>" />
            <?php echo form_close(); ?>
        </div>
    </div>
    <div class="row-fluid rowbg content">
        <div class="span12">
            <?php
        if (isset($players) && is_array($players) && count($players)) :
            echo('<b>'.sizeof($players).'</b> Players Found');
            ?>
            <br />    <br />
            <div class="stats-table">
			<table class="table table-striped table-bordered">
			<thead>
			<tr>
                <th class="headline">Name</th>
                <th class="headline">Age</th>
                <th class="headline">Team</th>
                <th class="headline">Position</th>
            </tr>
            </thead>

            <tbody>
            <?php
            foreach($players as $player) : ?>
            <tr>
				<td><?php echo anchor('players/profile/'.$player['player_id'],($player['first_name']." ".$player['last_name'])); 
				if (isset($player['injury_is_injured']) && !empty($player['injury_is_injured']) && $player['injury_is_injured'] != 0) :
					$injStatus = make_injury_status_string($player);
					?>
					<img src="<?php echo img_path(); ?>red_cross.gif" width="7" height="7" align="absmiddle"
					alt="<?php echo($injStatus); ?>" title="<?php echo($injStatus); ?>" />&nbsp; 
					<?php  
				endif;
				?></td>
                <td><?php echo $player['age']; ?></td>
                <td><?php echo anchor($settings['osp.asset_url'].'teams/team_'.$player['team_id'].'.html',($player['teamname']." ".$player['teamnick'])); ?></td>
                <td><?php if ($player['position'] == 1) { $pos = $player['role']; } else { $pos = $player['position']; } echo(get_pos($pos,$positions)); ?></td>
            </tr>
            <?php
            endforeach;
            ?>
            </tbody>
            </table>
            </div>
            <?php
        endif;
        ?>
        </div>
    </div>
</div>