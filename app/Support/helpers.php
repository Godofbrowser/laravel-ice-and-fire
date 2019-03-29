<?php
/**
 * Created by PhpStorm.
 * User: Ajeh Emeke
 * Date: 3/29/2019
 * Time: 2:20 AM
 */

if(! function_exists('ordinal_number')) {
	/**
	 * Convert a number to an ordinal number (eg 2 => 2nd)
	 *
	 * @param $number
	 *
	 * @return string
	 */
	function ordinal_number($number) {
		$locale = 'en_US';
		$nf = new NumberFormatter($locale, NumberFormatter::ORDINAL);
		return $nf->format($number);
	}
}
