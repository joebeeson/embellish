<?php

	// All of our syntaxes extend this file
	require(App::pluginPath('Embellish') . 'libs' . DS . 'Syntax.php');

	/**
	 * TongueHelper
	 * Provides functionality for translating formatting syntax into HTML. You
	 * set the syntax you're "speaking" with ::setSyntax('Name') and then you 
	 * can use the ::toHtml()
	 * @author Joe Beeson <jbeeson@gmail.com>
	 */
	class TongueHelper extends Object {
		
		/**
		 * Heleprs
		 * @var array
		 * @access public
		 */
		public $helpers = array(
		);
		
		/**
		 * The syntax object we're utilizing. This will be null until our
		 * setSyntax method is called.
		 * @var Syntax
		 * @access protected
		 */
		protected $Syntax;
		
		/**
		 * Construction method. If the user has selected a syntax we will go
		 * ahead and run setSyntax() for them with it however if it cannot find
		 * the requested formatting, we will throw an exception.
		 * @param string $syntax
		 * @return null
		 * @access public
		 */
		public function __construct($syntax = '') {
			if (!empty($syntax)) {
				if (!$this->_syntaxExists($syntax)) {
					// The requested syntax doesn't exist, throw a hissy fit
					throw new InvalidArgumentException(
						'The "'.$syntax.'" syntax doesn\'t exist'
					);
				} else {
					// Lets set the requested syntax
					$this->setSyntax($syntax);
				}
			}
		}
		
		/**
		 * Since there's no reason for us to implement every single method that
		 * our Syntax object might, we just pass anything we get right off to
		 * them and return it to our caller.
		 * @param string $method
		 * @param array $arguments
		 * @return mixed
		 * @access public
		 */
		public function __call($method, $arguments) {
			if (method_exists($this->Syntax, $method)) {
				return call_user_func_array(
					array(
						$this->Syntax, 
						$method
					), 
					$arguments
				);
			} else {
				trigger_error(
					'Call to undefined method '.get_class($this->Syntax).'::'.$method, 
					E_USER_ERROR
				);
			}
		}
		
		/**
		 * Sets the selected syntax. We return boolean to indicate the success
		 * of the operation. Failures usually indicate an unsupported syntax.
		 * @param string $syntax
		 * @return boolean
		 * @access public
		 */
		public function setSyntax($syntax = '') {
			if (!$this->_syntaxExists($syntax)) {
				return false;
			} else {
				$this->Syntax = $this->_getSyntax($syntax);
			}
		}
		
		/**
		 * Gets the requested $syntax and returns a newly created instance
		 * @param string $syntax
		 * @return Embellish_Syntax
		 * @access protected
		 */
		protected function _getSyntax($syntax = '') {
			if (!$this->_syntaxExists($syntax)) {
				throw new InvalidArgumentException(
					'Cannot retrieve a syntax, "'.$syntax.'" that doesn\'t exist'
				);
			} else {
				$className = $this->_syntaxClass($syntax);
				if (!class_exists($className)) {
					// The class hasn't been brought in yet, do so now...
					require($this->_syntaxFile($syntax));
				}
				return new $className;
			}
		}
		
		/**
		 * Checks if the passed $syntax exists. Returns boolean to indicate.
		 * @param string $syntax
		 * @return boolean
		 * @access protected
		 */
		protected function _syntaxExists($syntax = '') {
			return file_exists($this->_syntaxFile($syntax));
		}
		
		/**
		 * Convenience method for getting our expected syntax file name
		 * @param string $syntax
		 * @return string
		 * @access protected
		 */
		protected function _syntaxFile($syntax = '') {
			return $this->_syntaxDirectory() . $syntax . '.php';
		}
		
		/**
		 * Convenience method for getting our syntax directory.
		 * @return string
		 * @access protected
		 */
		protected function _syntaxDirectory() {
			return App::pluginPath('Embellish') . 'libs' . DS . 'Syntaxes' . DS;
		}
		
		/**
		 * Convenience method for returning our expected syntax class name
		 * @param string $syntax
		 * @return string
		 * @access protected
		 */
		protected function _syntaxClass($syntax = '') {
			return 'Embellish_Syntaxes_' . $syntax;
		}
		
	}