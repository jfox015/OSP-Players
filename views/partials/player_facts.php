			<h3><?php echo lang('player_facts'); ?></h3>
			<div class="container-fluid">
				<div class="row-fluid rowbg content">
					<div class="span12 player-facts">
						<ul>
							<li>
							<b><?php echo lang('player_drafted'); ?>:</b> 
							<?php 
							if ($details['draft_team_id'] != 0) {
								echo ordinal_suffix($details['draft_pick'],1)." ".lang('player_pick_in')." ".ordinal_suffix($details['draft_round'],1)." ".lang('player_round_of')." ";
								if ($details['draft_year']==0) { echo lang('player_inaugural'); } else { echo $details['draft_year']; }
								echo " ".lang('player_draft_by')." ";
								if (!isset($teams[$details['draft_team_id']]['name'])) {
									$draftTeam = lang('player_team_nonexistent');
								} else {
									$draftTeam = $teams[$details['draft_team_id']]['name']." ".$teams[$details['draft_team_id']]['nickname'];
								}
								if ($details['draft_year']==0) {echo $teams[$details['draft_team_id']]['name'];} else {echo $draftTeam;}
							}
							?>
							</li>
						<?php
						
						// TODO: SALARY
						
						// TODO: FIRST GAME (POSSIBLE?)
						
						if (isset($awards) && is_array($awards) && sizeof($awards) > 0) : ?>
						<?php
							//echo("size of awards = ".sizeof($awards)."<br />");
                            $awardsByYear = $awards['byYear'];
							$awdDrawn = false;
							$count = 0;
							foreach ($awardsByYear as $awid => $val) :
                                //echo($awid ." = ".$val."<br />");
								$awCnt=explode(",",$val);
								$awCnt=count($awCnt);
								$awrdType = get_award($awid,$award_list);
								switch ($awid) :
									case 'POY': 
									case 'BOY': 
									case 'ROY': 
									case 'GG': 
									case 'AS': echo '<li class="award trophy-'.strtolower($awrdType).'"><dl><dt class="title">'.lang('full_'.$awrdType).' ('.$awCnt.')</dt><dd>'.$val.'</dd></dl></li>'; break;
									default:
                                        break;
								endswitch; // END switch
								$count++;
								//if ($count < (sizeof($awardsByYear))) { echo("; "); }
							endforeach;
						endif;
						?>
						</ul>
					</div>
				</div>
			</div>
