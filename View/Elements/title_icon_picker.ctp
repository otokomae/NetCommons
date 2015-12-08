<?php
/**
 * Element of title icon picker include
 *
 * @copyright Copyright 2014, NetCommons Project
 * @author Allcreator <info@allcreator.net>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 */

echo $this->NetCommonsHtml->script(array(
	'/net_commons/js/title_icon_picker.js',
));
$dir = new Folder(APP . 'Plugin/NetCommons/webroot/img/title_icon');
$iconFiles = Hash::format($dir->find('.*\.svg'), array('{n}'), '/net_commons/img/title_icon/%1$s');
$alts = array_map('__d', array_fill(0, count($iconFiles), 'net_commons'), $iconFiles);
$icons = json_encode(array_combine($iconFiles, $alts));
$ngModelAttribute = '';
if (isset($ngModel)) {
	$ngModelAttribute = ' ng-model="' . $ngModel . '" ';
}
?>

<div class="input-group" ng-controller="ncTitleIconPickerCtrl" title-icon='<?php echo $titleIcon; ?>'>

	<nc-title-icon-picker
		title-icon='<?php echo $titleIcon; ?>'
		<?php echo $ngModelAttribute; ?>
		icons="<?php echo str_replace('"', '\'', $icons); ?>"
		>

		<?php if (isset($name)): ?>
			<?php echo $this->NetCommonsForm->hidden($name, array(
				'value' => '{{titleIcon}}')); ?>
		<?php elseif (isset($ngAttrName)): ?>
			<input type="hidden"
			    ng-attr-name="<?php echo $ngAttrName; ?>"
			    ng-value="<?php echo $ngModel; ?>" />
		<?php endif ?>

	</nc-title-icon-picker>

</div>