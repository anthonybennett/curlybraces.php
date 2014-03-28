<?php
/**
 * CurlyBraces
 * by Anthony Bennett
 *
 * released under the LGPL on 2014/03/28
 */
class CurlyBraces {
	const TEMPLATE_DIR = 'source/templates';

	protected static function Process($template, $data) {
		// process string until it has no braces
		while (true) {
			// look for start and end braces
			$start = strpos($template, '{% ');
			$end = strpos($template, ' %}');

			// return template if none found
			if (!is_int($start) || !is_int($end)) {
				return $template;
			}

			// start building new result
			$temp = '';
			if ($start > 0) {
				$temp .= substr($template, 0, $start);
			}

			// get whatever is between the braces
			$match = substr($template, ($start + 3), ($end - $start - 3));

			// if it's an include, pull it in, process it,
			// and make that part of the result
			$matches = array();
			if (preg_match('/^include (.+)$/', $match, $matches)) {
				$include = trim(@file_get_contents(static::TEMPLATE_DIR . "/{$matches[1]}"));
				$temp .= static::Process($include, $data);
			// if it's in our data, and make that part of the result
			} elseif (isset($data[$match])) {
				$temp .= $data[$match];
			}

			// add final part to result
			if (($end + 3) < strlen($template)) {
				$temp .= substr($template, ($end + 3));
			}

			// replace previous
			$template = $temp;
		};
	}

	public static function Compile($base, $template, $data) {
		// try loading given base; replace content with given template
		$base = trim(@file_get_contents(static::TEMPLATE_DIR . "/$base"));
		$base = str_replace('{% content %}', "{% include $template %}", $base);

		// force data to be an array
		if (!is_array($data)) { $data = array(); }

		// process base and return it
		return static::Process($base, $data);
	}
}