<?php
/**
 * RoomsController Test Case
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('Controller', 'Controller');
App::uses('CakeRequest', 'Network');
App::uses('CakeResponse', 'Network');
App::uses('ComponentCollection', 'Controller');
App::uses('NetCommonsFrameComponent', 'NetCommons.Controller/Component');
App::uses('Language', 'app.Model');

/**
 * Controller for NetCommonsFrame component test
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\NetCommons\Test\Case\Controller
 */
class TestNetCommonsFrameController extends Controller {

}

/**
 * NetCommonsFrame Component test case
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\NetCommons\Test\Case\Controller
 */
class NetCommonsFrameComponentTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.frames.frame',
		'plugin.frames.language',
		'plugin.frames.plugin',
		'plugin.boxes.box',
		'plugin.blocks.block',
	);

/**
 * NetCommonsFrame component
 *
 * @var Component NetCommonsFrame component
 */
	public $NetCommonsFrame = null;

/**
 * Controller for NetCommonsFrame component test
 *
 * @var Controller Controller for NetCommonsFrame component test
 */
	public $Controller = null;

/**
 * setUp
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();

		Configure::write('Config.language', 'ja');

		//テストコントローラ読み込み
		$CakeRequest = new CakeRequest();
		$CakeResponse = new CakeResponse();
		$this->Controller = new TestNetCommonsFrameController($CakeRequest, $CakeResponse);
		//コンポーネント読み込み
		$Collection = new ComponentCollection();
		$this->NetCommonsFrame = new NetCommonsFrameComponent($Collection);
		$this->NetCommonsFrame->startup($this->Controller);
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		parent::tearDown();

		unset($this->NetCommonsFrame);
		unset($this->Controller);

		Configure::write('Config.language', null);
	}

/**
 * initialize test
 *
 * @return void
 */
	public function testInitialize() {
		$this->NetCommonsFrame->initialize($this->Controller);
		$expected = array(
			'frameId' => 0,
			'blockId' => 0,
			'roomId' => 0,
			'languageId' => 0
		);
		$this->assertEquals($expected, $this->Controller->viewVars);
	}

/**
 * setView test
 *
 * @return void
 */
	public function testSetView() {
		$this->testInitialize();

		$frameId = 1;
		$result = $this->NetCommonsFrame->setView($this->Controller, $frameId);
		$this->assertTrue($result);

		$expected = array(
			'frameId' => 1,
			'frameKey' => 'frame_1',
			'blockId' => 5,
			'roomId' => 1,
			'languageId' => 2
		);
		$this->assertEquals($expected, $this->Controller->viewVars);
	}

/**
 * setViewKey test
 *
 * @return void
 */
	public function testSetViewKey() {
		$this->testInitialize();

		Configure::write('Config.language', 'ja');

		$frameKey = 'frame_1';
		$result = $this->NetCommonsFrame->setViewKey($this->Controller, $frameKey);
		$this->assertTrue($result);

		$expected = array(
			'frameId' => 1,
			'frameKey' => 'frame_1',
			'blockId' => 5,
			'roomId' => 1,
			'languageId' => 2
		);
		$this->assertEquals($expected, $this->Controller->viewVars);

		Configure::write('Config.language', null);
	}

/**
 * setView test for not exist frame id
 *
 * @return void
 */
	public function testSetViewNotExistFrameId() {
		$this->testInitialize();

		$frameId = 999;
		$result = $this->NetCommonsFrame->setView($this->Controller, $frameId);

		$this->assertFalse($result);
	}

/**
 * renderJson test
 *
 * @return void
 */
	public function testRenderJson() {
		$statusCode = 400;
		$message = 'Bad request.';
		$data = array('testRenderJson');
		$result = $this->NetCommonsFrame->renderJson($this->Controller, $statusCode, $message, $data);

		$this->assertInstanceOf('CakeResponse', $result);

		$expected = array(
			'message' => 'Bad request.',
			'status' => 400,
			'data' => array('testRenderJson')
		);
		$result = $this->Controller->response->body();
		$this->assertEquals($expected, get_object_vars(json_decode($result)));
	}
}
