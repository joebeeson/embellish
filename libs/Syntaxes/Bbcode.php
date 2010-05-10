<?php

	/**
	 * Lingual_Syntaxes_Bbcode
	 * Provides support for BBcode formatting. We will try to use the BBCode
	 * extension if it is installed otherwise we fall back to a regex solution.
	 * @see http://en.wikipedia.org/wiki/BBCode
	 * @author Joe Beeson <jbeeson@gmail.com>
	 */
	class Lingual_Syntaxes_Bbcode extends Lingual_Syntax {
		
		/**
		 * Converts our passed BBCode $string into HTML and returns it.
		 * @param string $string
		 * @return string
		 * @access public
		 */
		public function toHtml($string = '') {
			return ($this->_hasBbcodeExtension()
				? $this->_toHtmlExtension($string)
				: $this->_toHtmlRegex($string)
			);
		}
		
		/**
		 * Performs the ::toHtml() processing using the BBCode extension
		 * @param string $string
		 * @return string
		 * @access protected
		 */
		protected function _toHtmlExtension($string = '') {
			return bbcode_parse(
				bbcode_create(),
				$string
			);
		}
		
		/**
		 * Performs the ::toHtml() processing using regular expressions
		 * @param string $string
		 * @return string
		 * @access protected
		 */
		protected function _toHtmlRegex($string = '') {
			return preg_replace(
				array(
					'@\[(?i)b\](.*?)\[/(?i)b\]@si',
					'@\[(?i)i\](.*?)\[/(?i)i\]@si',
					'@\[(?i)u\](.*?)\[/(?i)u\]@si',
					'@\[(?i)img\](.*?)\[/(?i)img\]@si',
					'@\[(?i)url=(.*?)\](.*?)\[/(?i)url\]@si',
					'@\[(?i)code\](.*?)\[/(?i)code\]@si'
				),
				array(
					'<b>\\1</b>',
					'<i>\\1</i>',
					'<u>\\1</u>',
					'<img src="\\1">',
					'<a href="\\1">\\2</a>',
					'<code>\\1</code>'
				),
				$string
			);
		}
		
		/**
		 * Checks if the BBCode extension is installed
		 * @return boolean
		 * @access protected
		 */
		protected function _hasBbcodeExtension() {
			return function_exists('bbcode_parse');
		}
		
	}