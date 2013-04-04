			<?php
            echo("Game count = ".sizeof($upcoming_games)."<br />");
            if (isset($upcoming_games) && is_array($upcoming_games) && sizeof($upcoming_games) > 0) :
                ?>
				<h3><?php echo lang('player_upcoming_schedule'); ?></h3>
				<table class="table table-bordered table-striped">
				<thead>
				<tr>
					<th class="headline">Date</th>
					<th class="headline">Time</th>
					<th class="headline">OPP</th>
				</tr>
				</thead>
				<tbody>
				<?php
				if (isset($upcoming_games[$details['player_id']]) && is_array($upcoming_games[$details['player_id']]) && count($upcoming_games[$details['player_id']])) :
					$games = $upcoming_games[$details['player_id']];
					$drawn = 0;
					$limit = $settings['osp.sim_length'];
					$lastDate = "";
					$rowCount = 0;
					foreach ($games as $game_id => $game_data) { ?>
						<tr align="center" valign="middle">
						<td>
						<?php if (isset($game_data['game_date'])) { 
							$lastDate = $game_data['game_date']; 
							$thisDate = strtotime($game_data['game_date']); 
						} else {
							if (!empty($lastDate)) {
								$thisDate = $lastDate + strtotime($lastDate) + (60*60*24);
							} else {
								$thisDate = strtotime($league_info->current_date);
							}
						} 
						echo(date('m/d',$thisDate)); ?> </td>
						<td><?php if (isset($game_data['game_time'])) { echo(date('h:m A',strtotime($game_data['game_time']))); } else { echo(" - - "); } ?> </td>
						<td><?php
						if ($game_id > 0) :
							if ($details['team_id'] == $game_data['home_team'])  :
								if (isset($teams[$game_data['away_team']])) :
									echo(strtoupper($teams[$game_data['away_team']]['abbr']));
								endif;
							else :
								if (isset($teams[$game_data['home_team']])) :
									echo("@".strtoupper($teams[$game_data['home_team']]['abbr']));
								endif;
							endif;
						endif;
						$drawn++;
						$rowCount++;
						if ($drawn == $limit) break;
					} ?></td>
					<?php 
				else :
					for ($i = 0; $i < $settings['osp.sim_length']; $i++) :
						echo("<tr><td>'.lang('player_no_games_found').'</td></tr>\n");
					endfor;
				endif;
				?>
				</tbody>
				</table>
			<?php
			endif;
			?>