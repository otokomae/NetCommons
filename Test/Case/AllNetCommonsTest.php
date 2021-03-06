<?php
/**
 * NetCommons All Test Suite
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

/**
 * NetCommons All Test Suite
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\NetCommons\Test\Case
 * @codeCoverageIgnore
 */
class AllNetCommonsTest extends CakeTestSuite {

/**
 * All test suite
 *
 * @return CakeTestSuite
 */
	public static function suite() {
		$plugin = preg_replace('/^All([\w]+)Test$/', '$1', __CLASS__);
		$suite = new CakeTestSuite(sprintf('All %s Plugin tests', $plugin));

		$directory = CakePlugin::path($plugin) . 'Test' . DS . 'Case';
		$Folder = new Folder($directory);
		$exceptions = array(
			'TrackableBehaviorTestBase.php',
			'SingletonViewBlockHtmlHelperTestBase.php',
			'OriginalKeyBehaviorTestBase.php',
			'PublishableBehaviorTestBase.php',
			//後で削除
			'NetCommonsBlockComponentTest.php',
			'NetCommonsFrameComponentTest.php',
			'NetCommonsRoomRoleComponentTest.php',
			//'NetCommonsAppControllerTest.php',
			//'NetCommonsControllerTest.php',
			//'TrackableBehaviorTest.php',
			//'SingletonViewBlockHtmlHelperTest.php',
			//'OriginalKeyBehaviorTest.php',
			//'PublishableBehaviorTest.php',
		);
		$files = $Folder->tree(null, $exceptions, 'files');

		foreach ($files as $file) {
			if (substr($file, -4) === '.php') {
				$suite->addTestFile($file);
			}
		}

		return $suite;
	}
}
