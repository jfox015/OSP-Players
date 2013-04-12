<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Settings extends Admin_Controller {

	//--------------------------------------------------------------------
	
	public function __construct() 
	{
		parent::__construct();
		
		$this->auth->restrict('Site.Settings.View');

        if (!class_exists('Activity_model'))
        {
            $this->load->model('activities/Activity_model', 'activity_model', true);
        }
		$this->lang->load('players');
	}
	
	//--------------------------------------------------------------------

	public function _remap($method) 
	{ 
		if (method_exists($this, $method))
		{
			$this->$method();
		}
	}
    //--------------------------------------------------------------------

    public function index()
    {
        if ($this->input->post('submit'))
        {
            if ($this->save_settings())
            {
                Template::set_message(lang('md_settings_saved'), 'success');
                redirect(SITE_AREA .'/settings/players');
            } else
            {
                Template::set_message(lang('md_settings_error'), 'error');
            }
        }
        // Read our current settings
        $settings = $this->settings_lib->find_all();
        Template::set('settings', $settings);

        Template::set('toolbar_title', lang('players_settings_title'));
        Template::set_view('players/settings/index');
        Template::render();
    }

    //--------------------------------------------------------------------

    //--------------------------------------------------------------------
    // !PRIVATE METHODS
    //--------------------------------------------------------------------

    private function save_settings()
    {

		$this->load->library('form_validation');

        $this->form_validation->set_rules('player_link_type', lang('player_link_type'), 'trim|xss_clean');
        
        if ($this->form_validation->run() === false)
        {
            return false;
        }

		$data = array(
            array('name' => 'players.player_link_type', 'value' => $this->input->post('player_link_type')),

        );
        //destroy the saved update message in case they changed update preferences.
        if ($this->cache->get('update_message'))
        {
            if (!is_writeable(FCPATH.APPPATH.'cache/'))
            {
                $this->cache->delete('update_message');
            }
        }

        // Log the activity
        $this->activity_model->log_activity($this->auth->user_id(), lang('mod_act_settings_saved').': ' . $this->input->ip_address(), '[prefix]');

        // save the settings to the DB
        $updated = $this->settings_model->update_batch($data, 'name');

        return $updated;

	}
}

// End Settings Class