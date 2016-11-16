<?php
/**
 * Enables notification method for a batch of group members
 */

$methods = get_input('methods');
$offset = get_input('offset');

if (empty($methods)) {
	register_error(elgg_echo('notification_tools:error:no_methods'));
	forward(REFERER);
}

$reg_methods = _elgg_services()->notifications->getMethods();

$methods = explode(' ', $methods);

// TODO Verify that notification methods are valid

$limit = 10;

$dbprefix = elgg_get_config('dbprefix');

$query = "SELECT r.guid_one as user_guid, r.guid_two as group_guid
FROM {$dbprefix}entity_relationships r
INNER JOIN {$dbprefix}entities ue ON ue.guid = r.guid_one
INNER JOIN {$dbprefix}entities ge ON ge.guid = r.guid_two
WHERE r.relationship = 'member'
AND ue.type = 'user'
AND ge.type = 'group'
LIMIT {$offset}, {$limit}";

// Get all group memberships
$memberships = get_data($query);

foreach ($memberships as $membership) {
	foreach ($reg_methods as $reg_method) {
		if (in_array($reg_method,$methods)){
			add_entity_relationship($membership->user_guid, "notify{$reg_method}", $membership->group_guid);
		} else {
			remove_entity_relationship($membership->user_guid, "notify{$reg_method}", $membership->group_guid);			
		}
	}
}

// Return the amount of processed items
$result = new stdClass;
$result->count = $limit;
echo json_encode($result);
