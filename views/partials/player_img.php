			<?php
            if (file_exists($settings['osp.players_img_path'].'player_'.$details['player_id'].'.png')) {
                $player_img = $settings['osp.players_img_url'].'player_'.$details['player_id'].'.png';
            }
            else
            {
                $player_img = $settings['osp.asset_url'].'images/default_player_photo.png';
            }
            echo '<img src="'.$player_img.'" />';
            ?>