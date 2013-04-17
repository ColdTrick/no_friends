<?php 

	function no_friends_init(){
		global $CONFIG;
		
		// remove friends page handlers
		unregister_page_handler("friends");
		unregister_page_handler("friendsof");
		//unregister_page_handler("collections");
		
		// remove tools menu item
		remove_menu(elgg_echo("friends"));
		
		// unregister actions
		if(isset($CONFIG->actions) && is_array($CONFIG->actions)){
			$forbidden_actions = array(
				"friends/add",
				"friends/remove",
		//		"friends/addcollection",
				"friends/deletecollection",
				"friends/editcollection",
				//"groups/invite",
			);
			
			foreach($CONFIG->actions as $action => $settings){
				if(in_array($action, $forbidden_actions)){
					unset($CONFIG->actions[$action]);
				}
			}
		}
		
		// disable friends plugin
		if(is_plugin_enabled("friends")){
			disable_plugin("friends");
		}
		// disable invitefriends plugin
		if(is_plugin_enabled("invitefriends")){
			disable_plugin("invitefriends");
		}
		
	}
	
	function no_friends_pagesetup(){
		global $CONFIG;
		
		$forbidden_menu_items = array();
		
		// menu items based on page owner
		if(($page_owner = page_owner_entity()) && ($page_owner instanceof ElggGroup || $page_owner instanceof ElggUser)){
			$forbidden_menu_items[] = sprintf(elgg_echo("blog:user:friends"), $page_owner->name);
			$forbidden_menu_items[] = sprintf(elgg_echo("file:yours"), $page_owner->name);
			$forbidden_menu_items[] = sprintf(elgg_echo("file:yours:friends"), $page_owner->name);
			$forbidden_menu_items[] = sprintf(elgg_echo("file:friends"), $page_owner->name);
		}
		
		// menu items based on loggedin user
		if($user = get_loggedin_user()){
			$forbidden_menu_items[] = elgg_echo("blog:friends");
			$forbidden_menu_items[] = elgg_echo("bookmarks:friends");
			//$forbidden_menu_items[] = elgg_echo("groups:invite");
			$forbidden_menu_items[] = elgg_echo("thewire:friends");
		}
		
		// general menu items
		$forbidden_menu_items[] = elgg_echo("file:all");
		
		
		if(!empty($forbidden_menu_items) && !empty($CONFIG->submenu) && is_array($CONFIG->submenu)){
			foreach($CONFIG->submenu as $group => $items){
				if(!empty($items) && is_array($items)){
					foreach($items as $index => $item){
						if(!empty($item) && in_array($item->name, $forbidden_menu_items)){
							unset($CONFIG->submenu[$group][$index]);
						}
						
						if(empty($CONFIG->submenu[$group])){
							unset($CONFIG->submenu[$group]);
						}
					}
				}
			}
		}
		
		elgg_unextend_view('profile/menu/links','pages/menu');
		elgg_unextend_view('profile/menu/links','file/menu');
	}

	function no_friends_read_write_hook($hook, $entity_type, $returnvalue, $params){
		$result = $returnvalue;
		
		if(is_array($result) && isset($result[ACCESS_FRIENDS])){
			unset($result[ACCESS_FRIENDS]);
		}
		
		if(!empty($params["user_id"])){
			$user_guid = $params["user_id"];
			
			if($collections = get_user_access_collections($user_guid)){
				foreach($collections as $col){
					if(isset($result[$col->id]) && $result[$col->id] == $col->name){
						unset($result[$col->id]);
					}
				}
			}
		}
		
		return $result;
	}

	// register default Elgg events
	register_elgg_event_handler("init", "system", "no_friends_init", 99999);
	register_elgg_event_handler("pagesetup", "system", "no_friends_pagesetup", 99999);
	
	// we need to remove friends from access collections, needs to be last
	register_plugin_hook("access:collections:write", "all", "no_friends_read_write_hook", 99999); 
	register_plugin_hook("access:collections:read", "all", "no_friends_read_write_hook", 99999); 


?>