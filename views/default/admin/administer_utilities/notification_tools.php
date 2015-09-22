<?php
/**
 * UI for forcing notification methods for all site users
 */

elgg_require_js('notification_tools/process');

$user_count = elgg_get_entities(array(
	'type' => 'user',
	'count' => true,
));

/**
 * Personal notifications
 */
echo elgg_view('admin/administer_utilities/enable_setting', array(
	'setting' => 'personal',
	'count' => $user_count,
));

/**
 * Friend collection notifications
 */
echo elgg_view('admin/administer_utilities/enable_setting', array(
	'setting' => 'collection',
	'count' => $user_count,
));

/**
 * Group notifications
 */
echo elgg_view('admin/administer_utilities/enable_setting', array(
	'setting' => 'group',
	'count' => $user_count,
));
