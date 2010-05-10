<?php

	/**
	 * Lingual_Syntax
	 * Acts as our base class for all Lingual_Syntaxes in the Lingual plugin. We
	 * aren't an interface because we provide various functionality.
	 * @author Joe Beeson <jbeeson@gmail.com>
	 * @abstract
	 */
	abstract class Lingual_Syntax {
		
		/**
		 * This is the only function that are classes are required to implement
		 * in their code. This function should return well formatted HTML that
		 * the helper can use.
		 * @param string $string
		 * @return string
		 * @access public
		 */
		abstract public function toHtml($string = '');
		
	}