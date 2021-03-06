<?php
/**
 * OriginalKeyModel test case base
 *
 * @copyright Copyright 2014, NetCommons Project
 * @author Kohei Teraguchi <kteraguchi@commonsnet.org>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 */

App::uses('Model', 'Model');

/**
 * OriginalKeyModel for test case
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\NetCommons\Model\Behavior
 */
class OriginalKeyModel extends Model {

/**
 * Table name
 * @var string
 */
	public $useTable = 'original_keys';

/**
 * List of behaviors
 * @var array
 */
	public $actsAs = array(
		'NetCommons.OriginalKey',
	);
}

/**
 * OriginalWithoutKeyModel for test case
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\NetCommons\Model\Behavior
 */
class OriginalWithoutKeyModel extends Model {

/**
 * Table name
 * @var string
 */
	public $useTable = 'original_without_keys';

/**
 * List of behaviors
 * @var array
 */
	public $actsAs = array(
		'NetCommons.OriginalKey',
	);
}

/**
 * Base class of OriginalWithoutKeyModel test case
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\NetCommons\Model\Behavior
 */
class OriginalKeyBehaviorTestBase extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.net_commons.original_key',
		'plugin.net_commons.original_without_key',
	);

/**
 * setUp
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->OriginalKey = ClassRegistry::init('OriginalKeyModel');
		$this->OriginalWithoutKey = ClassRegistry::init('OriginalWithoutKeyModel');
	}

/**
 * tearDown
 *
 * @return void
 */
	public function tearDown() {
		unset($this->OriginalKey);
		unset($this->OriginalWithoutKey);
		parent::tearDown();
	}

}
