<?php
/**
 * Enable selected notification methods for a batch of users
 */

$methods = get_input('methods');
$offset = get_input('offset');
$reg_methods = _elgg_services()->notifications->getMethods();

if (empty($methods)) {
	register_error(elgg_echo('notification_tools:error:no_methods'));
	forward(REFERER);
}

$methods = explode(' ', $methods);

$users = elgg_get_entities(array(
    'types' => array('user'),
    'offset' => $offset,
));

foreach ($users as $user) {
	foreach ($reg_methods as $reg_method) {
		$metastring_name = "notification:method:{$reg_method}";
		if (in_array($reg_method,$methods)){
			$user->$metastring_name = true;
		} else {
			$user->$metastring_name = false;
		}
	}
}

$result = new stdClass;
$result->count = count($users);
echo json_encode($result);
