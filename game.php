<?php

/**
 * Places bets, spins the roulette wheel and displays the outcome.
 *
 * Note that a return value of -1 should be considered double-zero.
 */

include 'classes/roulette.class.php';
include 'classes/roulette_game.class.php';

$game = new RouletteGame();

// Multiple bets may be placed by calling place_bet with different bet types.

$game->place_bet(RouletteGame::BET_RED, 10);

$game->play();

switch ($game->get_color())
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

echo 'Wager: '.$game->get_total_wager().PHP_EOL.PHP_EOL;

echo "Result: {$color} - ".$game->get_number().PHP_EOL.PHP_EOL;

echo 'Won: '.$game->get_money_won().PHP_EOL;

echo 'Lost: '.$game->get_money_lost().PHP_EOL.PHP_EOL;

echo 'Money: '.$game->get_money().PHP_EOL.PHP_EOL;

?>
