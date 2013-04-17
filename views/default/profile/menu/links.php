<?php

	/**
	 * Elgg profile icon hover over: passive links
	 * 
	 * @package ElggProfile
	 * 
	 * @uses $vars['entity'] The user entity. If none specified, the current user is assumed. 
	 */

?>

	<p class="user_menu_profile">
		<a href="<?php echo $vars['entity']->getURL(); ?>"><?php echo elgg_echo("profile"); ?></a>
	</p>
	<?php
		if ($vars['entity']->canEdit())	{
	?>
		<p class="user_menu_profile">
			<a href="<?php echo $vars['url']?>pg/profile/<?php echo $vars['entity']->username; ?>/editicon/"><?php echo elgg_echo("profile:editicon"); ?></a>
		</p>
	<?php
		}
	
	?>