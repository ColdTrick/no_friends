<?php

namespace ColdTrick\NoFriends;

class Access {
	
	/**
	 * Remove friends and friendscollections from the write access array
	 *
	 * @param string $hook        the name of the hook
	 * @param string $type        the type of the hook
	 * @param int    $returnvalue current return value
	 * @param array  $params      supplied params
	 *
	 * @return array
	 */
	public static function removeFriends($hook, $type, $returnvalue, $params) {
		
		if (empty($params) || !is_array($params)) {
			return;
		}
		
		$result = $returnvalue;
		
		// remove friends access
		unset($result[ACCESS_FRIENDS]);
		
		// unset access collections
		$user_guid = elgg_extract('user_id', $params);
		$site_guid = elgg_extract('site_id', $params);
		
		if ($user_guid && $site_guid) {
			$access_collections = get_user_access_collections($user_guid, $site_guid);
			if ($access_collections) {
				foreach ($access_collections as $acl) {
					unset($result[$acl->id]);
				}
			}
		}
		
		return $result;
	}
}