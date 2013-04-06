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
        redirect('/players/playerlist/');
    }
    // Full Player List
    public function playerlist()
    {

        $settings = $this->settings_lib->find_all();
        $league_id = $this->uri->segment(3);
        if (!isset($league_id) || empty($league_id) || $league_id == -1) {
			$league_id = $settings['osp.league_id'];
		} else {
			$league_id = 100;
		}
		$type = $this->uri->segment(4);
		$param = $this->uri->segment(5);

        // IF NO PARAMS PASSED, LIMIT PLAYER SEARCH TO FIRST LETTER
		if (!isset($type) || empty($type) || $type == NULL) {
            $type = 'alpha';
        }
		if (!isset($param) || empty($param) || $param == NULL) {
            $param = 'A';
        }

		if ($this->players_model->getPlayerCount() > 0) {
			$players = $this->players_model->get_players($league_id, $type, $param, false);
			
			Template::set('players', $players);
			Template::set('current_url', current_url());
			Template::set('league_id', $league_id);
			Template::set('settings', $settings);
            Template::set('toolbar_title', "Players List");
            // Include stats lib for position resolution
			$this->load->library('open_sports_toolkit/stats');
            Stats::init($settings['osp.game_sport'],$settings['osp.game_source']);
            Template::set('positions', Stats::get_position_list());
        } else {
			Template::set('toolbar_title', "Players Error");
			Teamplte::set('message', $this->lang->line('players_no_players_error'));
		}
        $this->load->helper('form');
        Assets::add_module_css('players','style.css');
		Template::render();
	}
	// Player Stats Tool
	public function stats()
	{
		if ($this->players_model->getPlayerCount() > 0) 
		{
			$settings = $this->settings_lib->find_all();
			if ($this->input->post('type'))
			{
				$type = $this->input->post('type');
				$league_year = ($this->input->post('year')) ? $this->input->post('year') : -1;
				$team_id = ($this->input->post('team_id')) ? $this->input->post('team_id') : -1;
				$position_id = ($this->input->post('position_id')) ? $this->input->post('position_id') : -1;
				$split = ($this->input->post('split')) ? $this->input->post('split') : -1;
				$sub_league_id = ($this->input->post('sub_league_id')) ? $this->input->post('sub_league_id') : -1;
				$offset = ($this->input->post('offset')) ? $this->input->post('offset') : -1;
				$limit = ($this->input->post('limit')) ? $this->input->post('limit') : -1;
			} 
			else 
			{
				$league_id = $this->uri->segment(3);
			}
			// LEAGUE ID FAIL SAFE
			if (!isset($league_id) || empty($league_id) || $league_id == -1) {
				$league_id = $settings['osp.league_id'];
			}
	
			Stats::init($settings['osp.game_sport'],$settings['osp.game_source']);
			$stats_list = Stats::get_stats_list();

			if (!isset($league_year) || $league_year == -1)
			{
				$league_year = (int)$this->leagues_model->resolve_stats_season($league_id);
			}
			$years =  $this->leagues_model->get_all_seasons($league_id);
			
			if(!isset($type) || $type == null) {
				$type = TYPE_OFFENSE;
			}
			
			if(isset($team_id) && $team_id != -1) {
				$id_param = (int) $team_id;
				$stat_type = ID_TEAM;
			} else if(isset($sub_league_id) && $sub_league_id != -1) {
				$id_param = (int) $sub_league_id;
				$stat_type = ID_SUB_LEAGUE;
			} else {
				$id_param = (int) $league_id;
				$stat_type = ID_LEAGUE;
			}

			if (!isset($split)) {
				$split = SPLIT_SEASON;
			}
			if ($type == TYPE_DEFENSE) {
				$split = SPLIT_DEFENSE;
			}

			$stat_class = stats_class($type, CLASS_COMPLETE, array('PNABBR','TEAM_ACY','GENERAL'));
			$records = Stats::get_stats($stat_type,$id_param,$type,$stat_class,STATS_SEASON,RANGE_SEASON,array('year'=>$league_year, 'no_operator'=>true, 'split' => $split));
			$players_stats = $this->load->view('open_sports_toolkit/stats_table',array('player_type'=>$type,'stats_class'=>$stat_class,'stats_list'=>$stats_list,'records'=>$records), true);
			
			Template::set('years',$years);
			Template::set('players_stats',$players_stats);
			Template::set('stat_classes',$stat_class);
			Template::set('stats_list',$stats_list);
			Template::set('league_year',$league_year);
			Template::set('league_id',$league_id);
			//Template::set('sub_league_id',$sub_league_id);
			Template::set('team_id',(isset($team_id) ? $team_id : "-1"));
			Template::set('position_list',Stats::get_position_array());

			// Pagination
			/*$this->load->library('pagination');

			//$this->players_model->where($where);
			$total_players = $this->players_model->count_all();
			
			$this->pager['base_url'] = site_url(SITE_AREA .'/players/index');
			$this->pager['total_rows'] = $total_players;
			$this->pager['per_page'] = $this->limit;
			$this->pager['uri_segment']	= 9;

			$this->pagination->initialize($this->pager);

			Template::set('current_url', current_url()); */
			
			$settings = get_asset_path($settings);
			$this->load->helper('form');
			$this->load->helper('url');
			Template::set('teams',$this->teams_model->get_teams_array($league_id));
			Template::set('years',$years);
			Template::set('settings',$settings);
			Template::set('type',$type);
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
		$player_id = -1;
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
			$league_date = $this->leagues_model->get_league_date('current',$league_id);
			
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
				'Current'=>stats_class($player_type,CLASS_STANDARD),
				'Recent'=>stats_class($player_type,CLASS_RECENT)
			);
			$records = array (
				'Career'=>Stats::get_stats(ID_PLAYER,$player_id,$player_type,$stat_classes['Career'],STATS_CAREER,RANGE_CAREER, array('year'=>$league_year, 'no_operator'=>true)),
				'Extended'=>Stats::get_stats(ID_PLAYER,$player_id,$player_type,$stat_classes['Extended'],STATS_CAREER,RANGE_CAREER, array('year'=>$league_year, 'no_operator'=>true)),
				'Current'=>Stats::get_stats(ID_PLAYER,$player_id,$player_type,$stat_classes['Current'],STATS_SEASON,RANGE_SEASON, array('year'=>$league_year, 'no_operator'=>true)),
				'Recent'=>$this->players_model->get_recent_game_stats($league_id, $league_date, $league_year, $settings['osp.sim_length'], $player_id), 
			);

			// RENDER STATS TO VIEW CODE				
			$career = $this->load->view('open_sports_toolkit/stats_table',array('player_type'=>$player_type,'stats_class'=>$stat_classes['Career'],'stats_list'=>$stats_list,'records'=>$records['Career']), true);
			$extended = $this->load->view('open_sports_toolkit/stats_table',array('player_type'=>$player_type,'stats_class'=>$stat_classes['Extended'],'stats_list'=>$stats_list,'records'=>$records['Extended']), true);
			$current = $this->load->view('open_sports_toolkit/stats_table',array('player_type'=>$player_type,'stats_class'=>$stat_classes['Current'],'stats_list'=>$stats_list,'records'=>$records['Current']), true);
			$recent = $this->load->view('open_sports_toolkit/stats_table',array('player_type'=>$player_type,'stats_class'=>$stat_classes['Recent'],'stats_list'=>$stats_list,'records'=>$records['Recent']), true);
			
			$upcoming_games = $this->players_model->get_player_schedules(array($player_id), $league_date, $settings['osp.sim_length'], $settings);
			
			// ASSURE PATH COMPLIANCE TO OOPT VERSION
			$settings = get_asset_path($settings);

			Template::set('teams',$teams);
			Template::set('settings',$settings);
			Template::set('details',$details);
			Template::set('career',$career);
			Template::set('extended',$extended);
			Template::set('current',$current);
			Template::set('recent_games',$recent);
			Template::set('upcoming_games',$upcoming_games);
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