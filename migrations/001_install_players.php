<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Migration_Install_players extends Migration {
	
	private $permission_array = array(
        'Players.Settings.View' => 'View Players Settings Screens.',
        'Players.Settings.Manage' => 'Manage Players Settings.',
        'Players.Settings.Delete' => 'Delete Players Settings.',
    );

	public function up() 
	{
		$prefix = $this->db->dbprefix;

        foreach ($this->permission_array as $name => $description)
        {
            $this->db->query("INSERT INTO {$prefix}permissions(name, description) VALUES('".$name."', '".$description."')");
            // give current role (or administrators if fresh install) full right to manage permissions
            $this->db->query("INSERT INTO {$prefix}role_permissions VALUES(1,".$this->db->insert_id().")");
        }
		
		$default_settings = "
			INSERT INTO `{$prefix}settings` (`name`, `module`, `value`) VALUES
			 ('players.player_link_type', 'players', 'popup');
		";
        $this->db->query($default_settings);
        $this->db->query("UPDATE {$prefix}sql_tables SET required = 1 WHERE name = 'players_awards' OR name = 'cities' OR name = 'nations' OR name = 'states'");
		
		if ($this->db->table_exists('navigation')) 
		{
			$query = $this->db->query("SELECT nav_group_id FROM {$prefix}navigation_group where title = 'header_nav'");
			if ($query->num_rows() > 0) 
			{
				$row = $query->row();
				$nav_group_id = $row->nav_group_id;
				$data = array('nav_id'=>0,
					  'title'=>'Players',
					  'url'=>'/players',
					  'nav_group_id'=>$nav_group_id,
					  'position'=>3,
					  'parent_id'=>0,
					  'has_kids'=>0);
				$this->db->insert("{$prefix}navigation",$data);
			}
			$query->free_result();
		}


    }
	
	//--------------------------------------------------------------------
	
	public function down() 
	{
		$prefix = $this->db->dbprefix;
		
        $this->db->query("DELETE FROM {$prefix}settings WHERE (module = 'players')");

		foreach ($this->permission_array as $name => $description)
        {
            $query = $this->db->query("SELECT permission_id FROM {$prefix}permissions WHERE name = '".$name."'");
            foreach ($query->result_array() as $row)
            {
                $permission_id = $row['permission_id'];
                $this->db->query("DELETE FROM {$prefix}role_permissions WHERE permission_id='$permission_id';");
            }
            //delete the role
            $this->db->query("DELETE FROM {$prefix}permissions WHERE (name = '".$name."')");

        }
        $this->db->query("UPDATE {$prefix}sql_tables SET required = 0 WHERE name = 'players_awards' OR name = 'cities' OR name = 'nations' OR name = 'states'");
		
		//delete the nav item
		$this->db->query("DELETE FROM {$prefix}navigation WHERE (title = 'Players')");

    }
	
	//--------------------------------------------------------------------
	
}