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
	function get_player_link($player_id = false, $settings = false, $use_popup = false, $teams = false) 
	{
		if ($player_id === false) 
		{
			return false;
		}
		$link = "";
		$ci =& get_instance();
		$ci->load->model('open_sports_toolkit/players_model');
		$player_name = $ci->players_model->get_player_name($player_id);
		if ($use_popup === false)
		{
			$link = anchor('players/profile/'.$player_id, $player_name);
		}
		else 
		{
			$link = anchor('#', $player_name, array('id'=>$player_id, 'rel'=>'player_popup'));
			Template::set('popup_template',$ci->load->view('players/profile_ajax',false,true));
			Assets::clear_cache();
			Assets::set_globals(false);
            Assets::add_module_css('players','players_popup.css');
			Assets::add_module_js('players','players_popup.js');
			Assets::add_js('assets/js/underscore-min.js');
		}
		return $link;
	}
} 

?>