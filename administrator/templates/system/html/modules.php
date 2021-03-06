<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  Template.system
 *
 * @copyright   Copyright (C) 2005 - 2015 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

/*
 * none (output raw module content)
 */
function modChrome_none($module, &$params, &$attribs)
{
	echo $module->content;
}

/*
 * html5 (chosen html5 tag and font header tags)
 */
function modChrome_html5($module, &$params, &$attribs)
{
	$moduleTag      = $params->get('module_tag');
	$headerTag      = htmlspecialchars($params->get('header_tag'));
	$headerClass    = $params->get('header_class');
	$bootstrapSize  = $params->get('bootstrap_size');
	$moduleClass    = !empty($bootstrapSize) ? ' span' . (int) $bootstrapSize . '' : '';
	$moduleClassSfx = htmlspecialchars($params->get('moduleclass_sfx'));

	if (!empty ($module->content))
	{
		$html  = "<{$moduleTag} class=\"moduletable{$moduleClassSfx} {$moduleClass}\">";

		if ((bool) $module->showtitle)
		{
			$html .= "<{$headerTag} class=\"{$headerClass}\">{$module->title}</{$headerTag}>";
		}

		$html .= $module->content;
		$html .= "</{$moduleTag}>";

		echo $html;
	}
}

/*
 * xhtml (divs and font header tags)
 * With the new advanced parameter it does the same as the html5 chrome
 */
function modChrome_xhtml($module, &$params, &$attribs)
{
	$moduleTag      = $params->get('module_tag', 'div');
	$headerTag      = htmlspecialchars($params->get('header_tag', 'h3'));
	$bootstrapSize  = (int) $params->get('bootstrap_size', 0);
	$moduleClass    = $bootstrapSize != 0 ? ' span' . $bootstrapSize : '';

	// Temporarily store header class in variable
	$headerClass    = $params->get('header_class');
	$headerClass    = ($headerClass) ? ' class="' . htmlspecialchars($headerClass) . '"' : '';

	$content = trim($module->content);

	if (!empty ($content)) : ?>
		<<?php echo $moduleTag; ?> class="module<?php echo htmlspecialchars($params->get('moduleclass_sfx')) . $moduleClass; ?>">
			<?php if ($module->showtitle != 0) : ?>
				<<?php echo $headerTag . $headerClass . '>' . $module->title; ?></<?php echo $headerTag; ?>>
			<?php endif; ?>
			<?php echo $content; ?>
		</<?php echo $moduleTag; ?>>
	<?php endif;
}

/*
 * allows sliders
 */
function modChrome_sliders($module, &$params, &$attribs)
{
	$content = trim($module->content);
	if (!empty($content))
	{
		if ($params->get('automatic_title', '0') == '0')
		{
			echo JHtml::_('sliders.panel', $module->title, 'module' . $module->id);
		}
		elseif (method_exists('mod' . $module->name . 'Helper', 'getTitle'))
		{
			echo JHtml::_('sliders.panel', call_user_func_array(array('mod' . $module->name . 'Helper', 'getTitle'), array($params, $module)), 'module' . $module->id);
		}
		else
		{
			echo JHtml::_('sliders.panel', JText::_('MOD_' . $module->name . '_TITLE'), 'module' . $module->id);
		}
		echo $content;
	}
}

/*
 * allows tabs
 */
function modChrome_tabs($module, &$params, &$attribs)
{
	$content = trim($module->content);
	if (!empty($content))
	{
		if ($params->get('automatic_title', '0') == '0')
		{
			echo JHtml::_('tabs.panel', $module->title, 'module' . $module->id);
		}
		elseif (method_exists('mod' . $module->name . 'Helper', 'getTitle'))
		{
			echo JHtml::_('tabs.panel', call_user_func_array(array('mod' . $module->name . 'Helper', 'getTitle'), array($params)), 'module' . $module->id);
		}
		else
		{
			echo JHtml::_('tabs.panel', JText::_('MOD_' . $module->name . '_TITLE'), 'module' . $module->id);
		}
		echo $content;
	}
}
