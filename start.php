<?php

elgg_register_event_handler('init', 'system', 'no_friends_init');

/**
 * No friends init
 *
 * @return void
 */
function no_friends_init() {
	// cleanup some menu's
	elgg_register_plugin_hook_handler('register', 'menu:topbar', '\ColdTrick\NoFriends\Menus::topbarCleanup', 999999);
	elgg_register_plugin_hook_handler('register', 'menu:filter', '\ColdTrick\NoFriends\Menus::filterCleanup', 999999);
	elgg_register_plugin_hook_handler('register', 'menu:user_hover', '\ColdTrick\NoFriends\Menus::userHoverCleanup', 999999);
	elgg_register_plugin_hook_handler('register', 'menu:title', '\ColdTrick\NoFriends\Menus::titleCleanup', 999999);
	
	// remove the friends widget
	elgg_unregister_widget_type('friends');
	
	// remove friends access
	elgg_register_plugin_hook_handler('access:collections:write', 'user', '\ColdTrick\NoFriends\Access::removeFriends');
	
	// remove some page handlers
	elgg_unregister_page_handler('friends');
	elgg_unregister_page_handler('collections');
}
