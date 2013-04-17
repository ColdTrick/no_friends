<?php

	/**
	 * Elgg profile icon / profile links: passive links when looking at your own icon / profile
	 * 
	 * @package ElggProfile
	 * 
	 * @uses $vars['entity'] The user entity. If none specified, the current user is assumed. 
	 */

?>
	<?php
		if ($vars['entity']->canEdit()) {
	?>
		<p class="user_menu_profile">
			<a href="<?php echo $vars['url']?>pg/profile/<?php echo $vars['entity']->username; ?>/editicon/"><?php echo elgg_echo("profile:editicon"); ?></a>
		</p>
	<?php
		}
	
	?>