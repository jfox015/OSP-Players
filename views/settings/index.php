<?php if (validation_errors()) : ?>
<div class="notification error">
	<?php echo validation_errors(); ?>
</div>
<?php endif; ?>

<div class="admin-box">

    <h3>Players Settings</h3>

    <?php echo form_open($this->uri->uri_string(), 'class="form-horizontal"'); ?>

    <fieldset>
        <legend><?php echo lang('players_settings_title'); ?></legend>
	
		<div class="control-group <?php echo form_error('player_link_type') ? 'error' : '' ?>">
			<label class="control-label" for="player_link_type"><?php echo lang('player_link_type'); ?></label>
			<div class="controls">
				<select id="player_link_type" name="player_link_type" class="span3">
				<?php
					$linktypes = array(0 =>'Pop-up Card',1 =>'Link to profile');
					foreach( $linktypes as $id => $label) :
						echo('<option value="'.$id.'"');
						if (isset($settings['players.player_link_type']) && $settings['players.player_link_type'] == $id) {
							echo(' selected="selected"');
						}
						echo('">'.$label.'</option>');
					endforeach;
				?>
				</select>
				<?php if (form_error('player_link_type')) echo '<span class="help-inline">'. form_error('player_link_type') .'</span>'; ?>
			</div>
		</div>
	
	</fieldset>
	
	<div class="form-actions">
		<input type="submit" name="submit" class="btn btn-primary" value="<?php echo lang('bf_action_save'); ?>" />
	</div>
	
	<?php echo form_close(); ?>
</div>

