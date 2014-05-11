<?php
//SimpleTest::ignore('AppTestCase');

/**
 * App Test case. Contains base set of fixtures.
 *
 * @package temlpates.libs
 */
abstract class AppTestCase extends 
//CakeTestCase 
ControllerTestCase
{

/**
 * Fixtures
 *
 * @var array
 */
	public $dependedFixtures = array();

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array();

/**
 * Autoload entrypoint for fixtures dependecy solver
 *
 * @var string
 */
	public $plugin = null;

/**
 * Test to run for the test case (e.g array('testFind', 'testView'))
 * If this attribute is not empty only the tests from the list will be executed
 *
 * @var array
 */
	protected $_testsToRun = array();

/**
 * Constructor
 *
 * If a class is extending AppTestCase it will merge these with the extending classes
 * so that you don't have to put the plugin fixtures into the AppTestCase
 *
 * @return void
 */
	public function __construct($name = NULL, array $data = array(), $dataName = '') {
		parent::__construct($name, $data, $dataName);
		if (is_subclass_of($this, 'AppTestCase')) {
			$parentClass = get_parent_class($this);
			$parentVars = get_class_vars($parentClass);
			if (isset($parentVars['fixtures'])) {
				$this->fixtures = array_unique(array_merge($parentVars['fixtures'], $this->fixtures));
			}
			if (!empty($this->plugin)) {
				$this->dependedFixtures = $this->solveDependancies($this->plugin);
			}
			if (!empty($this->dependedFixtures)) {
				foreach ($this->dependedFixtures as $plugin) {
					$fixtures = $this->loadConfig('fixtures', $plugin);
					if (!empty($fixtures)) {
						$this->fixtures = array_unique(array_merge($this->fixtures, $fixtures));
					}
				}
			}
		}
	}

/**
 * Loads a file from app/tests/config/configure_file.php or app/plugins/PLUGIN/tests/config/configure_file.php
 *
 * Config file variables should be formated like:
 *  $config['name'] = 'value';
 * These will be used to create dynamic Configure vars.
 *
 *
 * @param string $fileName name of file to load, extension must be .php and only the name
 *     should be used, not the extenstion.
 * @param string $type Type of config file being loaded. If equal to 'app' core config files will be use.
 *    if $type == 'pluginName' that plugins tests/config files will be loaded.
 * @return mixed false if file not found, void if load successful
 */
	public function loadConfig($fileName, $type = 'app') {
		$found = false;
		if ($type == 'app') {
			$folder = APP . 'tests' . DS . 'config' . DS;
		} else {
			$folder = App::pluginPath($type);
				if (!empty($folder)) {
				$folder .= 'tests' . DS . 'config' . DS;
			} else {
				return false;
			}
		}
		if (file_exists($folder . $fileName . '.php')) {
			include($folder . $fileName . '.php');
			$found = true;
		}

		if (!$found) {
			return false;
		}

		if (!isset($config)) {
			$error = __("AppTestCase::load() - no variable \$config found in %s.php");
			trigger_error(sprintf($error, $fileName), E_USER_WARNING);
			return false;
		}
		return $config;
	}

/**
 * Solves Plugin Fixture dependancies.  Called in AppTestCase::__construct to solve
 * fixture dependancies.  Uses a Plugins tests/config/dependent and tests/config/fixtures
 * to load plugin fixtures. To use this feature set $plugin = 'pluginName' in your test case.
 *
 * @param string $plugin Name of the plugin to load
 * @return array Array of plugins that this plugin's test cases depend on.
 */
	public function solveDependancies($plugin) {
		$found = false;
		$result = array($plugin);
		$add = $result;
		do {
			$changed = false;
			$copy = $add;
			$add = array();
			foreach ($copy as $pluginName) {
				$dependent = $this->loadConfig('dependent', $pluginName);
				if (!empty($dependent)) {
					foreach ($dependent as $parentPlugin) {
						if (!in_array($parentPlugin, $result)) {
							$add[] = $parentPlugin;
							$result[] = $parentPlugin;
							$changed = true;
						}
					}
				}
			}
		} while ($changed);
		return $result;
	}

/**
 * Overrides parent method to allow selecting tests to run in the current test case
 * It is useful when working on one particular test
 *
 * @return array List of tests to run
 */
	public function getTests() {
		if (!empty($this->_testsToRun)) {
			debug('Only the following tests will be executed: ' . join(', ', (array) $this->_testsToRun), false, false);
			$result = array_merge(array('start', 'startCase'), (array) $this->_testsToRun, array('endCase', 'end'));
			return $result;
		} else {
			return parent::getTests();
		}
	}

}
