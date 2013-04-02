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
		} else {
			$league_id = 100;
		}
		$type = $this->uri->segment(5);
		$param = $this->uri->segment(6);	
		
		if ($this->players_model->getPlayerCount() > 0) {
			$players = $this->players_model->get_players($league_id, $type, $param, false);
			
			// Pagination
			$this->load->library('pagination');

			$total_players = sizeof($players);
			
			$this->pager['base_url'] = site_url(SITE_AREA .'/players/index');
			$this->pager['total_rows'] = $total_players;
			$this->pager['per_page'] = $this->limit;
			$this->pager['uri_segment']	= 7;

			$this->pagination->initialize($this->pager);

			Template::set('players', $players);
			Template::set('current_url', current_url());
		} else {
			Template::set('toolbar_title', "Players Error");
			Teamplte::set('message', $this->lang->line('players_no_players_error'));
		}
		Template::render();
	}
	// Player Stats Tool
	public function stats()
	{
		$settings = $this->settings_lib->find_all();
        $league_id = $this->uri->segment(4);
        
		// FILTER PARAMS
		$type = $this->uri->segment(5);
		$team_id = $this->uri->segment(6);
		$positions = $this->uri->segment(7);
		$range = $this->uri->segment(8); // current, last, last 3 summary
        $sub_league_id = $this->uri->segment(9); // sub league id

		if (!isset($league_id) || empty($league_id) || $league_id == -1) {
			$league_id = $settings['osp.league_id'];
		}
		
		if ($this->players_model->getPlayerCount() > 0) {
			
			Stats::init($settings['osp.game_sport'],$settings['osp.game_source']);
			
            $stats_list = Stats::get_stats_list();

			if (!isset($league_year) || $league_year === false)
			{
				$league_year = $this->leagues_model->resolve_stats_season($league_id);
			}
			$league_year = (int)$league_year;
			
			if($type !== false && $type == 1) {
				$player_type = TYPE_SPECIALTY;
			} else {
				$player_type = TYPE_OFFENSE;
			}
			
			if($team_id !== false) {
				$id_param = (int) $team_id;
				$stat_type = ID_TEAM;
			} else if($sub_league_id !== false) {
				$id_param = (int) $sub_league_id;
				$stat_type = ID_SUB_LEAGUE;
			} else {
				$id_param = (int) $league_id;
				$stat_type = ID_LEAGUE;
			}

			$stat_classes = stats_class($player_type, CLASS_COMPLETE, array('NAME','GENERAL'));
			$records = Stats::get_stats($stat_type,$id_param,$player_type,$stat_classes['Batting'],STATS_SEASON,RANGE_SEASON,array('year'=>$league_year));
			// RENDER STATS TO VIEW CODE				
			$players_stats = $this->load->view('open_sports_toolkit/stats_table',array('player_type'=>$player_type,'stats_class'=>$stat_classes['Batting'],'stats_list'=>$stats_list,'records'=>$records['Batting']), true);
			
			Template::set('players_stats',$players_stats);
			Template::set('stat_classes',$stat_classes);
			Template::set('stats_list',$stats_list);
			Template::set('league_year',$league_year);
			Template::set('team_id',$team_id);
			Template::set('team_details',$this->teams_model->select('team_id, name, nickname, logo_file')->find($team_id));
			
			// Pagination
			$this->load->library('pagination');

			//$this->players_model->where($where);
			$total_players = $this->players_model->count_all();
			
			$this->pager['base_url'] = site_url(SITE_AREA .'/players/index');
			$this->pager['total_rows'] = $total_players;
			$this->pager['per_page'] = $this->limit;
			$this->pager['uri_segment']	= 10;

			$this->pagination->initialize($this->pager);

			Template::set('current_url', current_url());

		} else {
			Template::set('toolbar_title', "Player Stats Error");
			Teamplte::set('message', $this->lang->line('players_no_players_error'));
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
			
			$league_year = $this->leagues_model->resolve_stats_season($league_id);
			
			if($details['position'] == 1) {
				$player_type = TYPE_SPECIALTY;
			} else {
				$player_type = TYPE_OFFENSE;
			}
			
			// Player Stats
			Stats::init($settings['osp.game_sport'],$settings['osp.game_source']);
			$stats_list = Stats::get_stats_list();
			
			$stat_classes = array (
				'Career'=>stats_class($player_type, CLASS_EXPANDED, array('NAME','POS')),
				'Extended'=>stats_class($player_type,CLASS_EXTENDED, array('NAME')),
				'Current'=>stats_class($player_type,CLASS_STANDARD)
			);
			$records = array (
				'Career'=>Stats::get_stats(ID_PLAYER,$player_id,$player_type,$stat_classes['Career'],STATS_CAREER,RANGE_CAREER),
				'Extended'=>Stats::get_stats(ID_PLAYER,$player_id,$player_type,$stat_classes['Extended'],STATS_CAREER,RANGE_CAREER),
				'Current'=>Stats::get_stats(ID_PLAYER,$player_id,$player_type,$stat_classes['Current'],STATS_SEASON,RANGE_SEASON, array('year'=>$league_year))
			);

			// RENDER STATS TO VIEW CODE				
			$career = $this->load->view('open_sports_toolkit/stats_table',array('player_type'=>$player_type,'stats_class'=>$stat_classes['Career'],'stats_list'=>$stats_list,'records'=>$records['Career']), true);
			$extended = $this->load->view('open_sports_toolkit/stats_table',array('player_type'=>$player_type,'stats_class'=>$stat_classes['Extended'],'stats_list'=>$stats_list,'records'=>$records['Extended']), true);
			$current = $this->load->view('open_sports_toolkit/stats_table',array('player_type'=>$player_type,'stats_class'=>$stat_classes['Current'],'stats_list'=>$stats_list,'records'=>$records['Current']), true);
			
			
			// ASSURE PATH COMPLIANCE TO OOPT VERSION
			$settings = get_asset_path($settings);

			Template::set('teams',$teams);
			Template::set('settings',$settings);
			Template::set('details',$details);
			Template::set('career',$career);
			Template::set('extended',$extended);
			Template::set('current',$current);
			Template::set('stat_classes',$stat_classes);
			Template::set('stats_list',$stats_list);
			Template::set('player_id',$player_id);
			Template::set('year',$league_year);
	
			Template::set('toolbar_title', $details['first_name']." ".$details['last_name']);
		}
		Template::render();
	}
}

// End main module class