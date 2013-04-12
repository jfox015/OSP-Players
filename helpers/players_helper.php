<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Players Helper
 *
 * @package		Players
 * @subpackage	Helpers
 * @category	Helpers
 * @author		Jeff Fox
 * @description	Various helpers for player information
 * @version		1.0
 */
// ------------------------------------------------------------------------

if ( ! function_exists('get_player_link')) 
{
	function get_player_link($player_id = false, $player_name = false) 
	{
		if ($player_id === false) 
		{
			return false;
		}
		$link = "";
		$ci =& get_instance();
		$settings = $ci->settings_lib->find_all_by('module','players');
		if ($player_name === false) 
		{
			$ci->load->model('open_sports_toolkit/players_model');
			$player_name = $ci->players_model->get_player_name($player_id);
		}
		if (isset($settings['players.player_link_type']) && $settings['players.player_link_type'] != 'popup')
		{
			$link = anchor('players/profile/'.$player_id, $player_name);
		}
		else 
		{
			$link = anchor('#', $player_name, array('id'=>$player_id, 'rel'=>'player_popup'));
		}
		return $link;
	}
}
?>