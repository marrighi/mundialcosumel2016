<?php

/**
 * @version    CVS: 1.0.0
 * @package    Com_Mundial_cosumel_2016
 * @author     Arrighi <marrighi@gmail.com>
 * @copyright  Copyright (C) 2016. Todos los derechos reservados.
 * @license    Licencia Pública General GNU versión 2 o posterior. Consulte LICENSE.txt
 */

defined('JPATH_BASE') or die;

$data = $displayData;

// Receive overridable options
$data['options'] = !empty($data['options']) ? $data['options'] : array();

// Check if any filter field has been filled
$filters  = false;
$filtered = false;

if (isset($data['view']->filterForm))
{
	$filters = $data['view']->filterForm->getGroup('filter');
}

// Check if there are filters set.
if ($filters !== false)
{
	$filterFields = array_keys($filters);
	$filled       = false;

	foreach ($filterFields as $filterField)
	{
		$filterField = substr($filterField, 7);
		$filter      = $data['view']->getState('filter.' . $filterField);

		if (!empty($filter))
		{
			$filled = $filter;
		}

		if (!empty($filled))
		{
			$filtered = true;
			break;
		}
	}
}

$options = $data['options'];

// Set some basic options
$customOptions = array(
	'filtersHidden'       => isset($options['filtersHidden']) ? $options['filtersHidden'] : empty($data['view']->activeFilters) && !$filtered,
	'defaultLimit'        => isset($options['defaultLimit']) ? $options['defaultLimit'] : JFactory::getApplication()->get('list_limit', 20),
	'searchFieldSelector' => '#filter_search',
	'orderFieldSelector'  => '#list_fullordering'
);

$data['options'] = array_unique(array_merge($customOptions, $data['options']));

$formSelector = !empty($data['options']['formSelector']) ? $data['options']['formSelector'] : '#adminForm';

// Load search tools
JHtml::_('searchtools.form', $formSelector, $data['options']);
?>

<div class="js-stools clearfix">
	<div class="clearfix">
		<div class="js-stools-container-bar">
			<label for="filter_search" class="element-invisible"
				aria-invalid="false"><?php echo JText::_('COM_MUNDIAL_COSUMEL_2016_SEARCH_FILTER_SUBMIT'); ?></label>

			<div class="btn-wrapper input-append">
				<?php echo $filters['filter_search']->input; ?>
				<button type="submit" class="btn hasTooltip" title=""
					data-original-title="<?php echo JText::_('COM_MUNDIAL_COSUMEL_2016_SEARCH_FILTER_SUBMIT'); ?>">
					<i class="icon-search"></i>
				</button>
			</div>
			

			<div class="btn-wrapper">
				<button type="button" class="btn hasTooltip js-stools-btn-clear" title=""
					data-original-title="<?php echo JText::_('COM_MUNDIAL_COSUMEL_2016_SEARCH_FILTER_CLEAR'); ?>"
					onclick="jQuery(this).closest('form').find('input').val('');">
					<?php echo JText::_('COM_MUNDIAL_COSUMEL_2016_SEARCH_FILTER_CLEAR'); ?>
				</button>
			</div>
		</div>
	</div>
	<!-- Filters div -->
	
</div>