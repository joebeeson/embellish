<?php

	/**
	 * TongueHelperTest
	 * Unit test for the Lingual plugin's TongueHelper
	 * @author Joe Beeson <jbeeson@gmail.com>
	 */
	class TongueHelperTest extends CakeTestCase {
		
		/**
		 * Executed at the start of our unit test
		 * @return null
		 * @access public
		 */
		public function start() {
			$this->_createTestHelper();
		}
		
		/**
		 * Executed at the start of each test
		 * @return null
		 * @access public
		 */
		public function startTest() {
			$this->Helper = new TestTongueHelper;
		}
		
		/**
		 * Executed at the end of each test
		 * @return null
		 * @access public
		 */
		public function endTest() {
			unset($this->Helper);
			ClassRegistry::flush();
		}
		
		/**
		 * Tests our setSyntax method
		 * @return null
		 * @access public
		 */
		public function testSetSyntax() {
			$this->assertNull($this->Helper->setSyntax('Markdown'));
			$this->assertFalse($this->Helper->setSyntax('Blah'));
		}
		
		/**
		 * Tests our "pass through" __call method with a successful call
		 * @return null
		 * @access public
		 */
		public function testCallSuccess() {
			// Set our syntax and check the response
			$this->Helper->__construct('Markdown');
			$this->assertIdentical(
				$this->Helper->toHtml('**This** is a test'),
				"<p><strong>This</strong> is a test</p>\n"
			);
		}
		
		/**
		 * Tests our "pass through" __call method with an unsuccessful call
		 * @return null
		 * @access public
		 */
		public function testCallFailure() {
			// Set our syntax and check the response
			$this->Helper->__construct('Markdown');
			
			$this->expectError();
			$this->Helper->no_such_method();
		}
		
		/**
		 * Tests the _getSyntax method with an existing syntax
		 * @return null
		 * @access public
		 */
		public function testGetSyntaxSuccess() {
			$this->assertIsA(
				$this->Helper->_getSyntax('Markdown'),
				'Embellish_Syntaxes_Markdown'
			);
		}
		
		/**
		 * Tests the _getSyntax method with a non-existant syntax
		 * @return null
		 * @access public
		 */
		public function testGetSytnaxFailure() {
			$this->expectException('InvalidArgumentException');
			$this->Helper->_getSyntax('ay dios mio!');
		}
		
		/**
		 * Tests the __constrct() method with a "correct" initialization.
		 * @return null
		 * @access public
		 */
		public function testConstructSuccess() {
			// We shouldn't have anything set yet...
			$this->assertNull($this->Helper->Syntax);
			
			// Run our __construct action...
			$this->Helper->__construct('Markdown');
			
			// We should have the Markdown syntax loaded
			$this->assertIsA(
				$this->Helper->Syntax,
				'Embellish_Syntaxes_Markdown'
			);
		}
		
		/**
		 * Tests the __construct() method with an "incorrect" initialization.
		 * @return null
		 * @access public
		 */
		public function testConstructFailure() {
			// We shouldn't have anything set yet...
			$this->assertNull($this->Helper->Syntax);
			
			// Expect an exception and run the construct
			$this->expectException('InvalidArgumentException');
			$this->Helper->__construct('no such syntax!');
		}
		
		/**
		 * Creates a class that extends the TongueHelper so that we may access
		 * protected variables and methods.
		 * @return null
		 * @access protected
		 */
		protected function _createTestHelper() {
			App::import('Helper', 'Embellish.tongue');
			eval('
				class TestTongueHelper extends TongueHelper {
					
					public function __get($variable) {
						if (isset($this->$variable)) {
							return $this->$variable;
						}
					}
					
					public function __call($method, $arguments) {
						if (method_exists($this, $method)) {
							return call_user_func_array(array($this, $method), $arguments);
						} else {
							return parent::__call($method, $arguments);
						}
					}
					
				}
			');
		}
		
	}