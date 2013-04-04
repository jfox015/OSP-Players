			<h3><?php echo lang('player_injury_report'); ?></h3>
			<div class="container-fluid">
				<div class="row-fluid rowbg content">
					<div class="span12">
						<?php 
						if (isset($details['injury_is_injured']) && !empty($details['injury_is_injured']) && $details['injury_is_injured'] != 0) :
							$injStatus = make_injury_status_string($details);
							?>
							<img src="<?php echo img_path(); ?>red_cross.gif" width="7" height="7" align="absmiddle"
							alt="<?php echo($injStatus); ?>" title="<?php echo($injStatus); ?>" />&nbsp; 
							<?php echo($injStatus);  
						else : ?>
							No information available at this time (<?php echo(date('m/d/Y')); ?>). 
						<?php 
						endif;
						?>
					</div>
				</div>
			</div>
