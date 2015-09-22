<?php
/**
 * Displays a process bar for enabling notifications for all users
 *
 * TODO Add checkboxes for selecting the desired notification methods
 */

$setting = elgg_extract('setting', $vars);
$count = elgg_extract('count', $vars);

$enable_desc = elgg_echo("notification_tools:process:$setting", array($count));

$link = elgg_view('output/url', array(
	'text' => elgg_echo('notification_tools:admin:activate'),
	'href' => false,
	'id' => "enable-$setting",
	'data-operation' => $setting,
	'class' => 'elgg-button elgg-button-action',
));

echo <<<HTML
	<div class="elgg-border-plain pvl phm mvl">
		<p>$enable_desc</p>
		<div class="elgg-progressbar" data-total="$count" id="progressbar-$setting"></div>
		<p>$link</p>
	</div>
HTML;
