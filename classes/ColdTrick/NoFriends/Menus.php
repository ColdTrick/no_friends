<?php

namespace ColdTrick\NoFriends;

class Menus {
	
	/**
	 * Remove unwanted menu items from the menu
	 *
	 * @param string          $hook         the name of the hook
	 * @param string          $type         the type of the hook
	 * @param \ElggMenuItem[] $return_value current return value
	 * @param array           $params       supplied params
	 *
	 * @return void|\ElggMenuItem[]
	 */
	public static function titleCleanup($hook, $type, $return_value, $params) {
		$forbidden_items = [];
		
		if (!elgg_is_active_plugin('group_tools')) {
			$forbidden_items[] = 'groups:invite';
		}
		
		if (empty($forbidden_items)) {
			return;
		}
		
		return self::removeMenuItemsFromMenu($return_value, $forbidden_items);
	}
	
	/**
	 * Remove unwanted menu items from the menu
	 *
	 * @param string          $hook         the name of the hook
	 * @param string          $type         the type of the hook
	 * @param \ElggMenuItem[] $return_value current return value
	 * @param array           $params       supplied params
	 *
	 * @return \ElggMenuItem[]
	 */
	public static function filterCleanup($hook, $type, $return_value, $params) {
		$forbidden_items = [
			'friend',
		];
		
		return self::removeMenuItemsFromMenu($return_value, $forbidden_items);
	}
	
	/**
	 * Remove unwanted menu items from the menu
	 *
	 * @param string          $hook         the name of the hook
	 * @param string          $type         the type of the hook
	 * @param \ElggMenuItem[] $return_value current return value
	 * @param array           $params       supplied params
	 *
	 * @return \ElggMenuItem[]
	 */
	public static function topbarCleanup($hook, $type, $return_value, $params) {
		$forbidden_items = [
			'friends',
		];
		
		return self::removeMenuItemsFromMenu($return_value, $forbidden_items);
	}
	
	/**
	 * Remove unwanted menu items from the menu
	 *
	 * @param string          $hook         the name of the hook
	 * @param string          $type         the type of the hook
	 * @param \ElggMenuItem[] $return_value current return value
	 * @param array           $params       supplied params
	 *
	 * @return \ElggMenuItem[]
	 */
	public static function userHoverCleanup($hook, $type, $return_value, $params) {
		$forbidden_items = [
			'remove_friend',
			'add_friend',
		];
				
		return self::removeMenuItemsFromMenu($return_value, $forbidden_items);
	}
	
	/**
	 * Remove menu items
	 *
	 * @param \ElggMenuItem[] $items           total list of menu items
	 * @param array           $forbidden_names menu names to remove
	 *
	 * @return \ElggMenuItem[]
	 */
	protected static function removeMenuItemsFromMenu($items, $forbidden_names) {
		
		foreach ($items as $index => $menu_item) {
			if (empty($menu_item) || !($menu_item instanceof \ElggMenuItem)) {
				continue;
			}
			
			if (in_array($menu_item->getName(), $forbidden_names)) {
				// remove menu item
				unset($items[$index]);
			}
		}
		
		return $items;
	}
}
