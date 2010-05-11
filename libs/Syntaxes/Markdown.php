<?php

	/**
	 * Embellish_Syntaxes_Markdown
	 * Provides support for Markdown formatting via the PHP Markdown library by
	 * Michel Fortin. 
	 * @see http://michelf.com/projects/php-markdown/
	 * @see http://daringfireball.net/projects/markdown/
	 * @author Joe Beeson <jbeeson@gmail.com>
	 */
	class Embellish_Syntaxes_Markdown extends Embellish_Syntax {
		
		/**
		 * Construction method. Ensures our needed libraries are present.
		 * @return null
		 * @access public
		 */
		public function __construct() {
			if (!App::import('Vendors', 'Embellish.markdown')) {
				throw new RuntimeException(
					get_class($this).' could not load our Markdown vendor library'
				);
			}
		}
		
		/**
		 * Converts our passed Markdown $string into HTML and returns it.
		 * @param string $string
		 * @return string
		 * @access public
		 */
		public function toHtml($string = '') {
			return Markdown($string);
		}
		
	}