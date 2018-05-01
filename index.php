<?php

$spaces = array_map('rtrim', file('spaces.txt'));



// Cliffless
$cliffless = array_key_exists('cliffless', $_GET) ||
	array_key_exists('nocliff', $_GET) ||
	array_key_exists('nocliffs', $_GET);

if (!$cliffless) {
	array_push($spaces, 'Airblasts Off Cliff');
	array_push($spaces, 'Walks Off Cliff');
}



// List
if (array_key_exists('list', $_GET)) {
	header('Content-Type: text/plain; charset=utf-8');
	sort($spaces);
	$count_spaces = count($spaces);
	for ($x = 0; $x < $count_spaces; $x++)
		echo $x < 9 ? '0' : '', $x + 1, ') ', $spaces[$x], "\n";
	exit();
}

shuffle($spaces);

$free = array_key_exists('free', $_GET);

$tbody = '';
for ($tr = 0; $tr < 5; $tr++) {
	$tbody .= "\t\t\t\t<tr>\n";
	for ($td = 0; $td < 5; $td++)
		$tbody .= "\t\t\t\t\t" . ($free && $tr == 2 && $td == 2 ? '<td class="selected" id="r3d3">Free</td>' : '<td id="r' . ($tr + 1) . 'd' . ($td + 1) . '">' . htmlspecialchars($spaces[$tr * 5 + $td]) . '</td>') . "\n";
	$tbody .= "\t\t\t\t</tr>\n";
}



// Background Image
$background_images = array(
	'f8ea4316fb2db0d62a53e35f8f1f54e6555fb4a5', // Scout
	'3af26b47862cffd38563706f20264f296dc26bc9', // Soldier
	'4fac253144bc134a3f6bac4aa23036ade05716eb', // Engi
	'18b45cda9d60b8e54902a342cb70b1232a144ac0', // Demoman
	'ed767cee2516dd90b78a860127f2ad9d32d1aa1c', // Spy
	'd07dc9315ea8d47180cea3de1ac7eb08e8e00a71', // Heavy
	'083e343d8fa83c7fff47e4ab98e82cf29b88178d', // Pyro
	'47595e774827d894dc01b2e129e82f5aac31e08d', // Medic
	'2c11549003a7357b2fbe1d1344b7f488bb22294e' // Sniper
);
$background_image = $background_images[rand(0, count($background_images) - 1)];



// Options

function options($settings, $name, $value) {
	$params = array();
	foreach ($settings as $k => $v) {
		if ($v)
			array_push($params, $k);
	}
	return ' ' .
		'<a href="?' . implode('&', $params) . '" rel="nofollow">' .
			'[ ' .
			$name .
			(
				$value !== null ?
				': <strong class="' . ($value ? 'on' : 'off') . '"></strong>' :
				''
			) .
			' ]' .
		'</a> ';
}

$options =
	options(
		array(
			'cliffless' => $cliffless,
			'free' => $free
		),
		'new card',
		null
	) .

	options(
		array(
			'cliffless' => !$cliffless,
			'free' => $free
		),
		'cliffs',
		!$cliffless
	) .

	options(
		array(
			'cliffless' => $cliffless,
			'free' => !$free
		),
		'Free Space',
		$free
	) .

	options(
		array(
			'cliffless' => $cliffless,
			'list' => true
		),
		'list',
		null
	) .

	'<a href="http://www.charlesstover.com/donate" target="_blank" title="Donate to the Developer">[ Donate ]</a>';

// Page Renderer
// This package is not included in this repo. Use your imagination. :)
include 'CSPage.php';
$page = new CSPage();
$page
	->set(
		'head-style',
		'<style type="text/css">' .
			'body { background-image: url("http://cdn.akamai.steamstatic.com/steamcommunity/public/images/items/440/{{background_image}}.jpg"); }' .
		'</style>'
	)
	->set('background_image', $background_image)
	->set('options', $options)
	->set('tbody', $tbody)
	->body('index.html')
	->css('bingo.min.css', 'screen')
	->description('Mark your TF2 Bingo card as stereotypical situations unfold throughout your game!')
	->favicon('../favicon.ico')
	->keywords('bingo, game bingo, team fortress, team fortress 2, tf2, team fortress bingo, team fortress 2 bingo, tf2 bingo, video game bingo')
	->title('Team Fortress 2 Bingo')
	->output();

?>