<?php
/**
 * Current Utility
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('CurrentControlPanel', 'NetCommons.Utility');
App::uses('CurrentFrame', 'NetCommons.Utility');

/**
 * Current Utility
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\NetCommons\Utility
 */
class Current {

/**
 * Constant setting mode value
 */
	const SETTING_MODE_WORD = 'setting';

/**
 * Constant default room_role_key
 *
 * @var string
 */
	const DEFAULT_ROOM_ROLE_KEY = 'visitor';

/**
 * is setting mode true
 *
 * @var bool
 */
	private static $__isSettingMode = null;

/**
 * Request object
 *
 * @var mixed
 */
	private static $__request;

/**
 * Instance object
 *
 * @var mixed
 */
	private static $__instance;

/**
 * Current data
 *
 * @var array
 */
	private static $__current = array();

/**
 * setup current data
 *
 * @param CakeRequest $request CakeRequest
 * @return void
 */
	public static function initialize(CakeRequest $request) {
		if (! self::$__instance) {
			self::$__instance = new Current();
		}

		self::$__request = $request;

		self::$__current['User'] = AuthComponent::user();

		self::$__current = CurrentControlPanel::initialize(self::$__request, self::$__current);

		if (! self::isControlPanel()) {
			self::$__current = CurrentFrame::initialize(self::$__request, self::$__current);
		}
	}

/**
 * Get the current data.
 *
 * @param string|null $key field to retrieve. Leave null to get entire Current data
 * @return array|null Current data.
 */
	public static function read($key = null) {
		if (! isset($key)) {
			return self::$__current;
		}
		return Hash::get(self::$__current, $key);
	}

/**
 * Get the permission value.
 *
 * @param string|array $key field to retrieve. Leave null to get entire Current data
 * @return bool permission value
 */
	public static function permission($key) {
		if (is_array($key)) {
			foreach ($key as $k) {
				if (self::permission($k)) {
					return true;
				}
			}
			return false;
		}
		$path = 'Permission.' . $key . '.value';

		return (bool)Hash::get(self::$__current, $path);
	}

/**
 * Back to page url
 *
 * @param bool|array $full If (bool) true, the full base URL will be prepended to the result.
 * @return string Full translated URL with base path.
 */
	public static function backToPageUrl($settingMode = false, $full = false) {
		$url = '/';
		if (! Current::isControlPanel()) {
			if ($settingMode) {
				$url .= self::SETTING_MODE_WORD . '/';
			}

			if (Current::read('Page.permalink')) {
				$url .= Current::read('Page.permalink') . '/';
			}
		}
		return h(Router::url($url, $full));
	}

/**
 * Back to default action url
 *
 * @param bool|array $full If (bool) true, the full base URL will be prepended to the result.
 * @return string Full translated URL with base path.
 */
	public static function backToIndexUrl($defaultField = 'default_action', $full = false) {
		$url = '/' . self::read('Plugin.key') . '/' . self::read('Plugin.' . $defaultField);
		if (self::read('Plugin.' . $defaultField) && ! Current::isControlPanel()) {
			if (Current::read('Frame.id')) {
				$url .= '/' . Current::read('Frame.id');
			}
		}
		return h(Router::url($url, $full));
	}

/**
 * Is login
 *
 * @return bool
 */
	public static function isLogin() {
		return (bool)AuthComponent::user('id');
	}

/**
 * Check setting mode
 *
 * @return bool
 */
	public static function isSettingMode() {
		if (isset(self::$__isSettingMode)) {
			return self::$__isSettingMode;
		}

		$pattern = preg_quote('/' . self::SETTING_MODE_WORD . '/', '/');
		if (preg_match('/' . $pattern . '/', Router::url())) {
			self::$__isSettingMode = true;
		} else {
			self::$__isSettingMode = false;
		}

		return self::$__isSettingMode;
	}

/**
 * Has setting mode
 *
 * @return bool
 */
	public static function hasSettingMode() {
		return self::permission('page_editable');
	}

/**
 * Check control panel
 *
 * @return bool
 */
	public static function isControlPanel() {
		if (self::$__request->params['plugin'] === CurrentControlPanel::PLUGIN_CONTROL_PANEL) {
			return true;
		}

		if (! isset(self::$__current['Plugin'])) {
			return false;
		}

		if (self::$__current['Plugin']['type'] === Plugin::PLUGIN_TYPE_FOR_CONTROL_PANEL) {
			return true;
		} else {
			return false;
		}
	}

/**
 * Has Control panel
 *
 * @return bool
 */
	public static function hasControlPanel() {
		if (! isset(self::$__current['PluginsRole'])) {
			return false;
		} else {
			return (bool)count(self::$__current['PluginsRole']);
		}
	}

}
