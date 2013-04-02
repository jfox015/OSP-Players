					<!-- CURRETN SEASON STATS -->
                <h3><?php if (isset($statYear)) { echo($statYear); } else { echo(data('Y',time())); } ?> Stats</h3>
				
				<?php
				if (isset($player_stats)) :
					echo($player_stats);
				endif;
				/*$rowsDrawn = 0; ?>
				<div class="stats-table">
				<table class="table table-striped table-bordered">
				<thead>
				<tr>
                    <?php  if ($details['position'] != 1) { 
						$ab = isset($player_stats['ab']) ? $player_stats['ab'] : 0;
						$h = isset($player_stats['h']) ? $player_stats['h'] : 0;
						$bb = isset($player_stats['bb']) ? $player_stats['bb'] : 0;
						$k = isset($player_stats['k']) ? $player_stats['k'] : 0;
						$d = isset($player_stats['d']) ? $player_stats['d'] : 0;
						$t = isset($player_stats['t']) ? $player_stats['t'] : 0;
						$hr = isset($player_stats['hr']) ? $player_stats['hr'] : 0;
						$r = isset($player_stats['r']) ? $player_stats['r'] : 0;
						$rbi = isset($player_stats['rbi']) ? $player_stats['rbi'] : 0;
						$sb = isset($player_stats['sb']) ? $player_stats['sb'] : 0;
						if ($ab==0) {
							$avg=0;
							$wiff = 0;	
						} else {
						  $avg=$h/$ab;
						  $wiff = intval(($k/$ab)*100);
						}
						if ($bb == 0 ) {
							$walk = 0;
						} else {
							$walk = intval(($bb/($ab+$bb))*100);
						}
					   if ($avg<1) {$avg=strstr(sprintf("%.3f",$avg),".");}
						else {$avg=sprintf("%.3f",$avg);}
						
						
						$xbh = ($d+$t+$hr);
						if ($walk > 20) {
						   $walk = '<span style="color:#060">'.$walk.'</span>';
					   } else if ($walk >= 10 && $walk <= 20) {
						   $walk = '<span style="color:#F60">'.$walk.'</span>';
					   } else {
						   $walk = '<span style="color:#C00">'.$walk.'</span>';
					   }
					   if ($wiff < 10) {
						   $wiff = '<span style="color:#060">'.$wiff.'</span>';
					   } else if ($wiff >= 10 && $wiff <= 25) {
						   $wiff = '<span style="color:#f30">'.$wiff.'</span>';
					   } else {
						   $wiff = '<span style="color:#C00">'.$wiff.'</span>';
					   }
					   if (!$rowsDrawn) $rowsDrawn = true;
						?>
                        <td width="9%"><b>BA</b></td>
                        <td width="9%"><b>AB</b></td>
                        <td width="9%"><b>R</b></td>
                        <td width="9%"><b>HR</b></td>
                        <td width="9%"><b>RBI</b></td>
                        <td width="9%"><b>BB</b></td>
                        <td width="9%"><b>KO</b></td>
                        <td width="9%"><b>SB</b></td>
                        <td width="9%"><b>WIFF%</b></td>
                        <td width="9%"><b>WALK%</b></td>
                        <td width="9%"><b>XBH</b></td>
                    </tr>
					</thead>
					<tbody>
                    <tr height=17 class="bg2" align="center" valign="middle">
                    	<td><?php echo($avg); ?></td>
                        <td><?php echo($ab); ?></td>
                        <td><?php echo($r); ?></td>
                        <td><?php echo($hr); ?></td>
                        <td><?php echo($rbi); ?></td>
                        <td><?php echo($bb); ?></td>
                        <td><?php echo($k); ?></td>
                        <td><?php echo($sb); ?></td>
                        <td><?php echo($wiff); ?></td>
                        <td><?php echo($walk); ?></td>
                        <td><?php echo($xbh); ?></td>
                    </tr>
                    <?php } else { 
							$w = isset($player_stats['w']) ? $player_stats['w'] : 0;
							$l = isset($player_stats['l']) ? $player_stats['l'] : 0;
							$s = isset($player_stats['s']) ? $player_stats['s'] : 0;
							$ip = isset($player_stats['ip']) ? $player_stats['ip'] : 0;
							$er = isset($player_stats['er']) ? $player_stats['er'] : 0;
							$bb = isset($player_stats['bb']) ? $player_stats['bb'] : 0;
							$ha = isset($player_stats['ha']) ? $player_stats['ha'] : 0;
							$k =  isset($player_stats['k']) ? $player_stats['k'] : 0;
							$hra = isset($player_stats['hra']) ? $player_stats['hra'] : 0;
							if ($ip==0) { 
							$era=0;$whip=0;$k9 = 0;$bb9 = 0;$hr9 = 0;
						  } else {
							  $era=$er*9/$ip;
							  $whip=($ha+$bb)/$ip;
							  $k9 = ($k*9)/$ip;
							  $bb9 = ($bb*9)/$ip;
							  $hr9 = ($hra*9)/$ip;
						   }
						   $era=sprintf("%.2f",$era);
						   $ip=sprintf("%.1f",$ip);
						   if ($ip<1) {$ip=strstr($ip,".");}
						   $whip=sprintf("%.2f",$whip);
						   
						   
						   $k9=sprintf("%.2f",$k9);
						   if ($k9 > 6) {
							   $k9 = '<span style="color:#060">'.$k9.'</span>';
						   } else if ($k9 >= 4 && $k9 <= 6) {
							   $k9 = '<span style="color:#F60">'.$k9.'</span>';
						   } else {
							   $k9 = '<span style="color:#C00">'.$k9.'</span>';
						   }
						   
						   $bb9=sprintf("%.2f",$bb9);
						   if ($bb9 < 3) {
							   $bb9 = '<span style="color:#060">'.$bb9.'</span>';
						   } else if ($bb9 > 3 && $bb9 <= 5) {
							   $bb9 = '<span style="color:#f30">'.$bb9.'</span>';
						   } else {
							   $bb9 = '<span style="color:#C00">'.$bb9.'</span>';
						   }
						   
						   $hr9=sprintf("%.2f",$hr9);
						   if ($hr9 <= 1) {
							   $hr9 = '<span style="color:#060">'.$hr9.'</span>';
						   } else if ($hr9 > 1 && $hr9 <= 2) {
							   $hr9 = '<span style="color:#F60">'.$hr9.'</span>';
						   } else {
							   $hr9 = '<span style="color:#C00">'.$hr9.'</span>';
						   }
						   if (!$rowsDrawn) $rowsDrawn = true;
						?> 
                        <td width="9%"><b>W</b></td>
                        <td width="9%"><b>L</b></td>
                        <td width="9%"><b>ERA</b></td>
                        <td width="9%"><b>S</b></td>
                        <td width="9%"><b>INN</b></td>
                        <td width="9%"><b>K</b></td>
                        <td width="9%"><b>BB</b></td>
                        <td width="9%"><b>WHIP</b></td>
                        <td width="9%"><b>K/9</b></td>
                        <td width="9%"><b>BB/9</b></td>
                        <td width="9%"><b>HR/9</b></td>
                    </tr>
                    <tr  height=17  class="bg2" align="center" valign="middle">
                    	<td><?php echo($w); ?></td>
                        <td><?php echo($l); ?></td>
                        <td><?php echo($era); ?></td>
                        <td><?php echo($s); ?></td>
                        <td><?php echo($ip); ?></td>
                        <td><?php echo($k); ?></td>
                        <td><?php echo($bb); ?></td>
                        <td><?php echo($whip); ?></td>
                        <td><?php echo($k9); ?></td>
                        <td><?php echo($bb9); ?></td>
                        <td><?php echo($hr9); ?></td>
                    </tr>
                    <?php } ?>
                    </tr>
                   <?php 
					if (!$rowsDrawn) { ?>
                    <tr  height=17  class="bg2" align="right" valign="middle">
                    	<td colspan="8" align=center>No Stats Were Found</td>
                    </tr>
                     <?php } ?>
                     </table>
                	</td>
                </tr>
                </table>
                </div>
				*/ ?>