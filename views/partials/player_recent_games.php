			<?php
			if (isset($recent_games) && !empty($recent_games)) : ?>
				<h3><?php echo lang('player_recent_games'); ?></h3>
				<?php echo($recent_games); ?>
			<?php
			endif;
			/*
							<!-- RECENT GAMES -->
							<table class="table table-bordered table-striped">
							<thead>
							<?php  if ($details['position'] != 1) : ?>
							<tr align="center">
								<th class="headline"></th>
								<th class="headline">OPP</th>
								<th class="headline">AB</th>
								<th class="headline">R</th>
								<th class="headline">H</th>
								<th class="headline">HR</th>
								<th class="headline">RBI</th>
								<th class="headline">BB</th>
								<th class="headline">SB</th>
							</tr>
							</thead>
							<tbody>
							<?php
							foreach($recentGames as $game) :
							?>
							<tr>
								<td><?php echo(date('m/d',strtotime($game['date']))); ?></td>
								<td><?php echo(strtoupper($game['opp'])); ?></td>
								<td><?php echo($game['ab']); ?></td>
								<td><?php echo($game['r']); ?></td>
								<td><?php echo($game['h']); ?></td>
								<td><?php echo($game['hr']); ?></td>
								<td><?php echo($game['rbi']); ?></td>
								<td><?php echo($game['bb']); ?></td>
								<td><?php echo($game['sb']); ?></td>
							</tr>
							<?php
							endforeach;
							
							else:
							?>
							<tr align="center">
								<th class="headline"></th>
								<th class="headline">OPP</th>
								<th class="headline">W</th>
								<th class="headline">L</th>
								<th class="headline">S</th>
								<th class="headline">HR</th>
								<th class="headline">RBI</th>
								<th class="headline">BB</th>
								<th class="headline">SB</th>
							</tr>
							</thead>
							<tbody>
							<?php
							foreach($recentGames as $game) :
							?>
							<tr>
								<td><?php echo(date('m/d',strtotime($game['date']))); ?></td>
								<td><?php echo(strtoupper($game['opp'])); ?></td>
								<td><?php echo($game['ab']); ?></td>
								<td><?php echo($game['r']); ?></td>
								<td><?php echo($game['h']); ?></td>
								<td><?php echo($game['hr']); ?></td>
								<td><?php echo($game['rbi']); ?></td>
								<td><?php echo($game['bb']); ?></td>
								<td><?php echo($game['sb']); ?></td>
							</tr>
							<?php
							endforeach;
							
							endif;
							?>
                    <table width=100% cellpadding=2 cellspacing=1 border=0>
                	<?php  if ($thisItem['position'] != 1) { ?>
					
                    <?php 
						if (isset($recentGames) && sizeof($recentGames) > 0) {
							$rowCount = 0;
							
                       <tr height="17" class="<?php echo(($rowCount % 2) == 0 ? "s1_l" : "s2_l"); ?>" align="center" valign="middle">
                        
                        
                        
                    </tr>
					<?php 		$rowCount++;
							} 
						} ?>
                    <?php 
					} else { 
					?>
                    <tr align=center class=bg4>
                        <td></td>
                        <td>OPP</td>
                        <td>W</td>
                        <td>L</td>
                        <td>S</td>
                        <td>IP</td>
                        <td>H</td>
                        <td>ERA</td>
                        <td>BB</td>
                        <td>K</td>
                    </tr>
                    <?php 
						if (isset($recentGames) && sizeof($recentGames) > 0) {
							$rowCount = 0;
							foreach($recentGames as $game) { ?>	
                     <tr  height=17  class="<?php echo(($rowCount % 2) == 0 ? "s1_l" : "s2_l"); ?>" align="center" valign="middle">
                        <?php
							$ip = $game['ip'];
							$er = $game['er'];
							if ($ip==0) { 
								$era=0;
						  	} else {
								$era=$er*9/$ip;
						   }
						   $era=sprintf("%.2f",$era);
						   $ip=sprintf("%.1f",$ip);
						?>
                        <td><?php echo(date('m/d',strtotime($game['date']))); ?></td>
                        <td><?php echo(strtoupper($game['opp'])); ?></td>
                        <td><?php echo($game['w']); ?></td>
                        <td><?php echo($game['l']); ?></td>
                        <td><?php echo($game['s']); ?></td>
                        <td><?php echo($ip); ?></td>
                        <td><?php echo($game['ha']); ?></td>
                        <td><?php echo($era); ?></td>
                        <td><?php echo($game['bb']); ?></td>
                        <td><?php echo($game['k']); ?></td>
                    </tr>
                        <?php $rowCount++;
							} 
						} 
					}?>
                    </table>
                	</td>
                </tr>
                </table>
                </div>
				*/
				?>