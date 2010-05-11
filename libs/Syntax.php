<?php

	/**
	 * Embellish_Syntax
	 * Acts as our base class for all Embellish_Syntaxes in the Embellish plugin 
	 * @author Joe Beeson <jbeeson@gmail.com>
	 * @abstract
	 */
	abstract class Embellish_Syntax {
		
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