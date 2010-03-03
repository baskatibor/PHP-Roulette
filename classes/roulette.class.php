<?php

/**
 * This class represents an American roulette wheel.
 *
 * It generates a number and matching color randomly within the
 * range of the wheel.
 *
 * @author Dan Ruscoe - http://ruscoe.org
*/

class Roulette
{
	const COLOR_GREEN	= 1;
	const COLOR_BLACK	= 2;
	const COLOR_RED		= 3;

	const MIN_WHEEL_NUMBER	= 0;
	const MAX_WHEEL_NUMBER	= 36;

	private $number;
	private $color;

	public function __construct() {}

	/**
	 * Spins the roulette wheel, generating a random number and
	 * matching color within the range of the wheel.
	 */
	public function spin()
	{
		$this->number = $this->generate_random_number(self::MIN_WHEEL_NUMBER, self::MAX_WHEEL_NUMBER);

		$this->color = $this->find_number_color($this->number);
	}

	/**
	 * Returns the resulting number of the last wheel spin.
	 *
	 * @return int
	 */
	public function get_number()
	{
		return $this->number;
	}

	/**
	 * Returns the resulting color of the last wheel spin.
	 *
	 * @return int - Color ID, defined as class constant.
	 */
	public function get_color()
	{
		return $this->color;
	}

	/**
	 * Generates a random number within a given range.
	 *
	 * This function just wraps PHP's rand() fuction
	 * to allow for easy replacement with any preferred
	 * random number generator.
	 *
	 * @param int $min - The start of the number range.
	 * @param int $max - The end of the number range.
	 * @return int - Random number.
	 */
	private function generate_random_number($min, $max)
	{
		return rand($min, $max);
	}

	/**
	 * Returns the color on the roulette wheel matching a given number.
	 *
	 * @param int $number - The number on the wheel.
	 * @return int - The ID of the matching color, defined as a class constant.
	 */
	private function find_number_color($number)
	{
		if ($number == 0)
		{
			return self::COLOR_GREEN;
		}

		else if ( (($number >= 1) && ($number <= 10))
			|| (($number >= 19) && ($number <= 28))
		)
		{
			return (($number % 2) == 0)? self::COLOR_BLACK : self::COLOR_RED;
		}

		else if ( (($number >= 11) && ($number <= 18))
			|| (($number >= 29) && ($number <= 36))
		)
		{
			return (($number % 2) == 0)? self::COLOR_RED : self::COLOR_BLACK;
		}
	}
}

?>
