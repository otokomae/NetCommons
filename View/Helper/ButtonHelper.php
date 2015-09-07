<?php
/**
 * Button Helper
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('FormHelper', 'View/Helper');

/**
 * Button Helper
 *
 * @package NetCommons\NetCommons\View\Helper
 */
class ButtonHelper extends FormHelper {

/**
 * Other helpers used by FormHelper
 *
 * @var array
 */
	public $helpers = array(
		'Form',
		'Html',
		'NetCommons.BackHtml',
		'NetCommons.NetCommonsForm',
	);

/**
 * Creates a `<a>` tag for edit link link. The type attribute defaults
 *
 * @param string $title The button's caption. Not automatically HTML encoded
 * @param mixed $url Link url
 * @param array $options Array of options and HTML attributes.
 * @return string A HTML button tag.
 * @link http://book.cakephp.org/2.0/en/core-libraries/helpers/form.html#FormHelper::button
 */
	public function editLink($value, $title = '', $url = null, $options = array()) {
		$output = '';

		//iconの有無
		$iconElement = '';
		if (! isset($options['icon'])) {
			$options['icon'] = 'edit';
		}
		if ($options['icon'] !== '') {
			$iconElement = '<span class="glyphicon glyphicon-' . h($options['icon']) . '"></span> ';
			unset($options['icon']);
		}
		//ボタンサイズ
		$sizeAttr = '';
		if (isset($options['iconSize']) && $options['iconSize'] !== '') {
			$sizeAttr = h('btn-' . $options['iconSize']);
			unset($options['iconSize']);
		}

		//Linkオプションの設定
		$inputOptions = Hash::merge(array(
			'escapeTitle' => false,
			'class' => 'btn btn-primary ' . $sizeAttr
		), $options);
		if (! $inputOptions['escapeTitle']) {
			$title = h($title);
		}

		//span tooltipタグの出力
		if (isset($options['tooltip']) && $options['tooltip']) {
			$output .= '<span class="nc-tooltip" tooltip="' . __d('net_commons', 'Edit') . '">';
			unset($inputOptions['tooltip']);
		}
		$output .= $this->NetCommonsForm->editLink($value, $iconElement . $title, $url, $inputOptions);
		if (isset($options['tooltip']) && $options['tooltip']) {
			$output .= '</span>';
		}
		return $output;
	}

/**
 * Creates a `<button>` tag. The type attribute defaults to `type="submit"`
 * You can change it to a different value by using `$options['type']`.
 *
 * ### Options:
 *
 * - `escape` - HTML entity encode the $title of the button. Defaults to false.
 *
 * ### Original options
 * - `confirm` - Add javascript confirm in onclick attribute
 *
 * @param string $title The button's caption. Not automatically HTML encoded
 * @param string $confirm Confirm message by button click
 * @param array $options Array of options and HTML attributes.
 * @return string A HTML button tag.
 * @link http://book.cakephp.org/2.0/en/core-libraries/helpers/form.html#FormHelper::button
 */
	public function delete($title, $confirm, $options = array()) {
		$output = '';

		$title = '<span class="glyphicon glyphicon-trash"> </span> ' . $title;

		$defaultOptions = array(
			'name' => 'delete',
			'class' => 'btn btn-danger pull-right',
			'onclick' => 'return confirm(\'' . $confirm . '\')',
			'ng-click' => 'sending=true',
			'ng-disabled' => 'sending'
		);
		$inputOptions = Hash::merge($defaultOptions, $options);

		$output .= $this->Form->button($title, $inputOptions);
		return $output;
	}

/**
 * Creates a `<button>` tag. The type attribute defaults to `type="submit"`
 * You can change it to a different value by using `$options['type']`.
 *
 * ### Options:
 *
 * - `escape` - HTML entity encode the $title of the button. Defaults to false.
 *
 * ### Original options
 * - `confirm` - Add javascript confirm in onclick attribute
 *
 * @param string $title The button's caption. Not automatically HTML encoded
 * @param array $options Array of options and HTML attributes.
 * @return string A HTML button tag.
 * @link http://book.cakephp.org/2.0/en/core-libraries/helpers/form.html#FormHelper::button
 */
	public function save($title, $options = array()) {
		$output = '';

		$defaultOptions = array(
			'name' => 'save',
			'class' => 'btn btn-primary btn-workflow',
			'ng-click' => 'sending=true',
			'ng-disabled' => 'sending'
		);
		$inputOptions = Hash::merge($defaultOptions, $options);

		$output .= $this->Form->button($title, $inputOptions);
		return $output;
	}

/**
 * Creates a `<button>` tag. The type attribute defaults to `type="submit"`
 * You can change it to a different value by using `$options['type']`.
 *
 * ### Options:
 *
 * - `escape` - HTML entity encode the $title of the button. Defaults to false.
 *
 * ### Original options
 * - `url` - The url in onclick attribute
 *
 * @param string $title The button's caption. Not automatically HTML encoded
 * @param string $url The url in onclick attribute
 * @param array $options Array of options and HTML attributes.
 * @return string A HTML button tag.
 * @link http://book.cakephp.org/2.0/en/core-libraries/helpers/form.html#FormHelper::button
 */
	public function cancel($title, $url, $options = array()) {
		$defaultOptions = array(
			'name' => 'cancel',
		);
		$inputOptions = Hash::merge($defaultOptions, $options);
		return $this->BackHtml->button($title, $url, $inputOptions);
	}

/**
 * Creates a `<button>` tag for cacnel and save.
 *
 * @param string $cancelTitle The button's caption. Not automatically HTML encoded
 * @param string $saveTitle The button's caption. Not automatically HTML encoded
 * @param string $cancelUrl The url in onclick attribute
 * @param array $options Array of options and HTML attributes.
 * @return string A HTML button tag.
 * @link http://book.cakephp.org/2.0/en/core-libraries/helpers/form.html#FormHelper::button
 */
	public function cancelAndSave($cancelTitle, $saveTitle, $cancelUrl = null, $options = array()) {
		if (! isset($cancelUrl)) {
			$cancelUrl = Current::backToPageUrl();
		}

		$output = '';
		$output .= $this->cancel($cancelTitle, $cancelUrl, $options);
		$output .= $this->save($saveTitle, $options);
		return $output;
	}

}
