<?php

	/**
	 * Embellish_Syntaxes_Markdown
	 * Provides support for Textile formatting via the Textile library by
	 * Dean Allen.
	 * @see http://thresholdstate.com/
	 * @author Joe Beeson <jbeeson@gmail.com>
	 */
	class Embellish_Syntaxes_Textile extends Embellish_Syntax {
		
		/**
		 * Holds our Textile object
		 * @var Textile
		 * @access protected
		 */
		protected $Textile;
		
		/**
		 * Construction method. Ensures our needed libraries are present.
		 * @return null
		 * @access public
		 */
		public function __construct() {
			if (!App::import('Vendors', 'Embellish.textile')) {
				throw new RuntimeException(
					get_class($this).' could not load our Textile vendor library'
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
			return $this->_getTextile()->TextileThis($string);
		}
		
		/**
		 * Returns our Textile object. If we don't have one yet we will create
		 * it here.
		 * @return Textile
		 * @access protected
		 */
		protected function _getTextile() {
			if (!isset($this->Textile)) {
				$this->Textile = new Textile();
			}
			return $this->Textile;
		}
		
	}
	