<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Players extends Front_Controller {

	//--------------------------------------------------------------------
	
	public function __construct() 
	{
		parent::__construct();
		$this->load->model('open_sports_toolkit/players_model');
		$this->load->model('open_sports_toolkit/leagues_model');
		$this->load->model('open_sports_toolkit/teams_model');
		
		$this->load->helper('open_sports_toolkit/general');
        
		$this->load->library('open_sports_toolkit/stats');
            
		$this->lang->load('players');
		
	}

	//--------------------------------------------------------------------
	
	// Full Player List
	public function index()
	{
		$settings = $this->settings_lib->find_all();
        $league_id = $this->uri->segment(4);
		if (!isset($league_id) || empty($league_id) || $league_id == -1) {
			$league_id = $settings['osp.league_id'];
		}
		
		
		Template::render();
	}

	// Ind Player profile
	public function profile() 
	{
		$settings = $this->settings_lib->find_all();
        
		$player = null;
		// Choose Player Type
		$player_id = 1;
		$player_id = $this->uri->segment(3);
		$league_id = $this->uri->segment(4);
		if (!isset($league_id) || empty($league_id) || $league_id == -1) {
			$league_id = $settings['osp.league_id'];
		}
		if (isset($player_id) && !empty($player_id) && $player_id !== NULL) {
			
			$teams = $this->teams_model->get_teams_array($league_id);
			$details = $this->players_model->get_player_details($player_id, $settings);
			
			$player_id = (int)$player_id;
			
			if($details['position'] == 1) {
				$player_type = TYPE_SPECIALTY;
			} else {
				$player_type = TYPE_OFFENSE;
			}
			
			// Player Stats
			Stats::init($settings['osp.game_sport'],$settings['osp.game_source']);
			$stats_list = Stats::get_stats_list();
			
			$stat_classes = array (
				'Career'=>stats_class($player_type, CLASS_EXPANDED, array('NAME','GENERAL')),
				'Extended'=>stats_class($player_type,CLASS_EXTENDED, array('NAME','GENERAL'))
			);
			$records = array (
				'Career'=>Stats::get_stats(ID_PLAYER,$player_id,$player_type,$stat_classes['Career'],STATS_CAREER,RANGE_CAREER),
				'Extended'=>Stats::get_stats(ID_PLAYER,$player_id,$player_type,$stat_classes['Extended'],STATS_CAREER,RANGE_CAREER)
			);

			// RENDER STATS TO VIEW CODE				
			$career = $this->load->view('open_sports_toolkit/stats_table',array('player_type'=>$player_type,'stats_class'=>$stat_classes['Career'],'stats_list'=>$stats_list,'records'=>$records['Career']), true);
			$extended = $this->load->view('open_sports_toolkit/stats_table',array('player_type'=>$player_type,'stats_class'=>$stat_classes['Extended'],'stats_list'=>$stats_list,'records'=>$records['Extended']), true);
			
			// ASSURE PATH COMPLIANCE TO OOPT VERSION
			$settings = get_asset_path($settings);

			Template::set('teams',$teams);
			Template::set('settings',$settings);
			Template::set('details',$details);
			Template::set('career',$career);
			Template::set('extended',$extended);
			Template::set('stat_classes',$stat_classes);
			Template::set('stats_list',$stats_list);
			Template::set('player_id',$player_id);
	
			Template::set('toolbar_title', $details['first_name']." ".$details['last_name']);
		}
		Template::render();
	}
}

// End main module class