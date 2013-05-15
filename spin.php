<?php

/**
 * Spins the roulette wheel a given number of times and displays the results.
 *
 * Note that a return value of -1 should be considered double-zero.
 */

include 'classes/roulette.class.php';

define('SPINS', 20);

$roulette = new Roulette();

for ($i = 1; $i <= SPINS; $i++)
{
	$roulette->spin();

	switch ($roulette->get_color())
	{
		case Roulette::COLOR_GREEN:
			$color = 'Green';
		break;

		case Roulette::COLOR_BLACK:
			$color = 'Black';
		break;

		case Roulette::COLOR_RED:
			$color = 'Red';
		break;
	}

	echo "{$color} - ".$roulette->get_number()."\n";
}

?>
