<?php
/**
 * Represents a game of roulette on an American roulette wheel.
 *
 * Several bets of the same or different types can be made before playing the game.
 *
 * @author Dan Ruscoe - http://ruscoe.org
 */

class RouletteGame extends Roulette
{
	// Possible Bets
	const BET_RED		= 'bet_red';
	const BET_BLACK		= 'bet_black';

	const BET_LOW		= 'bet_low';
	const BET_HIGH		= 'bet_high';

	const BET_FIRST_DOZEN	= 'bet_first_dozen';
	const BET_SECOND_DOZEN	= 'bet_second_dozen';
	const BET_THIRD_DOZEN	= 'bet_third_dozen';

	const BET_FIRST_COLUMN	= 'bet_first_column';
	const BET_SECOND_COLUMN	= 'bet_second_column';
	const BET_THIRD_COLUMN	= 'bet_third_column';

	// Payoffs
	// x to 1
	const PAYOFF_RED_BLACK	= 1;
	const PAYOFF_LOW_HIGH	= 1;
	const PAYOFF_DOZEN	= 2;
	const PAYOFF_COLUMN	= 2;

	private $money		= 0;
	private $total_wager	= 0;
	private $money_won	= 0;
	private $money_lost	= 0;
	private $win		= false;

	private $bets		= array();

	public function __construct() {}

	/**
	 * Places a bet to play in the game of roulette.
	 * Multiple bets can be placed in a single game.
	 *
	 * @param string $bet_type - Type of bet, defined as class constant.
	 * @param int $wager - The amount of money to bet.
	 */
	public function place_bet($bet_type, $wager)
	{
		if (!isset($this->bets[$bet_type]))
		{
			$this->bets[$bet_type] = (int) $wager;
		}
		else
		{
			$this->bets[$bet_type] += (int) $wager;
		}

		$this->increment_money($wager);

		$this->increment_total_wager($wager);
	}

	/**
	 * Plays all placed bets and maintains a tally of money won,
	 * money lost and total money.
	 *
	 * @return bool - True if a bet was a winner.
	 */
	public function play()
	{
		$this->spin();

		foreach ($this->bets as $bet_type => $wager)
		{
			if (method_exists(RouletteGame, $bet_type))
			{
				if ($payoff = $this->$bet_type())
				{
					$this->win = true;

					$money_won = ($wager * $payoff);

					$this->increment_money_won($money_won);

					$this->increment_money($money_won);
				}
				else
				{
					$this->increment_money_lost($wager);

					$this->decrement_money($wager);
				}
			}
		}

		return $this->win;
	}

	/**
	 * Red numbers win.
	 * @return int - Winning bet payoff.
	 */
	private function bet_red()
	{
		if ($this->get_color() == self::COLOR_RED)
		{
			return self::PAYOFF_RED_BLACK;
		}
		return false;
	}

	/**
	 * Black numbers win.
	 * @return int - Winning bet payoff.
	 */
	private function bet_black()
	{
		if ($this->get_color() == self::COLOR_BLACK)
		{
			return self::PAYOFF_RED_BLACK;
		}
		return false;
	}

	/**
	 * Numbers between 1 and 19 win.
	 * @return int - Winning bet payoff.
	 */
	private function bet_low()
	{
		if ( ($this->get_number() >= 1) && ($this->get_number() <= 19) )
		{
			return self::PAYOFF_LOW_HIGH;
		}
		return false;
	}

	/**
	 * Numbers between 1 and 12 win.
	 * @return int - Winning bet payoff.
	 */
	private function bet_first_dozen()
	{
		if ( ($this->get_number() >= 1) && ($this->get_number() <= 12) )
		{
			return self::PAYOFF_DOZEN;
		}
		return false;
	}

	/**
	 * Numbers between 13 and 24 win.
	 * @return int - Winning bet payoff.
	 */
	private function bet_second_dozen()
	{
		if ( ($this->get_number() >= 13) && ($this->get_number() <= 24) )
		{
			return self::PAYOFF_DOZEN;
		}
	}

	/**
	 * Numbers between 25 and 36 win.
	 * @return int - Winning bet payoff.
	 */
	private function bet_third_dozen()
	{
		if ( ($this->get_number() >= 25) && ($this->get_number() <= 36) )
		{
			return self::PAYOFF_DOZEN;
		}
	}

	/**
	 * Every third number between 1 and 34, inclusive, wins.
	 * @return int - Winning bet payoff.
	 */
	private function bet_first_column()
	{
		for ($i = 1; $i <= 34; $i += 3)
		{
			if ($this->get_number() == $i)
			{
				return self::PAYOFF_COLUMN;
			}
		}
		return false;
	}

	/**
	 * Every third number between 2 and 35, inclusive, wins.
	 * @return int - Winning bet payoff.
	 */
	private function bet_second_column()
	{
		for ($i = 2; $i <= 35; $i += 3)
		{
			if ($this->get_number() == $i)
			{
				return self::PAYOFF_COLUMN;
			}
		}
		return false;
	}

	/**
	 * Every third number between 3 and 36, inclusive, wins.
	 * @return int - Winning bet payoff.
	 */
	private function bet_third_column()
	{
		for ($i = 3; $i <= 36; $i += 3)
		{
			if ($this->get_number() == $i)
			{
				return self::PAYOFF_COLUMN;
			}
		}
		return false;
	}

	private function increment_total_wager($amount)
	{
		$this->total_wager += $amount;
	}

	private function increment_money_won($amount)
	{
		$this->money_won += $amount;
	}

	private function increment_money_lost($amount)
	{
		$this->money_lost += $amount;
	}

	private function increment_money($amount)
	{
		$this->money += $amount;
	}

	private function decrement_money($amount)
	{
		$this->money -= $amount;
	}

	public function get_total_wager()
	{
		return $this->total_wager;
	}

	public function get_money()
	{
		return $this->money;
	}

	public function get_money_won()
	{
		return $this->money_won;
	}

	public function get_money_lost()
	{
		return $this->money_lost;
	}

	public function get_win()
	{
		return $this->win;
	}
}

?>
