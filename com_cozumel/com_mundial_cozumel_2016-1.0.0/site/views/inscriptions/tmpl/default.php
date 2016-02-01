<?php
/**
 * @version    CVS: 1.0.0
 * @package    Com_Mundial_cozumel_2016
 * @author     Arrighi <marrighi@gmail.com>
 * @copyright  Copyright (C) 2016. Todos los derechos reservados.
 * @license    Licencia Pública General GNU versión 2 o posterior. Consulte LICENSE.txt
 */
// No direct access
defined('_JEXEC') or die;

JHtml::addIncludePath(JPATH_COMPONENT . '/helpers/html');
JHtml::_('bootstrap.tooltip');
JHtml::_('behavior.multiselect');
JHtml::_('formbehavior.chosen', 'select');

$user       = JFactory::getUser();
$userId     = $user->get('id');
$listOrder  = $this->state->get('list.ordering');
$listDirn   = $this->state->get('list.direction');
$canCreate  = $user->authorise('core.create', 'com_mundial_cozumel_2016');
$canEdit    = $user->authorise('core.edit', 'com_mundial_cozumel_2016');
$canCheckin = $user->authorise('core.manage', 'com_mundial_cozumel_2016');
$canChange  = $user->authorise('core.edit.state', 'com_mundial_cozumel_2016');
$canDelete  = $user->authorise('core.delete', 'com_mundial_cozumel_2016');
?>

<form action="<?php echo JRoute::_('index.php?option=com_mundial_cozumel_2016&view=inscriptions'); ?>" method="post"
      name="adminForm" id="adminForm">

	<?php  echo JLayoutHelper::render('default_filter', array('view' => $this), dirname(__FILE__)); ?>
	<table class="table table-striped" id="inscriptionList">
		<thead>
		<tr>
	
							<th class=''>
				<?php echo JHtml::_('grid.sort',  'COM_MUNDIAL_cozumel_2016_INSCRIPTIONS_ID', 'a.id', $listDirn, $listOrder); ?>
				</th>
				<th class=''>
				<?php echo JHtml::_('grid.sort',  'COM_MUNDIAL_cozumel_2016_INSCRIPTIONS_LAST_NAME', 'a.last_name', $listDirn, $listOrder); ?>
				</th>
				<th class=''>
				<?php echo JHtml::_('grid.sort',  'COM_MUNDIAL_cozumel_2016_INSCRIPTIONS_NAME', 'a.name', $listDirn, $listOrder); ?>
				</th>
				<th class=''>
				<?php echo JHtml::_('grid.sort',  'COM_MUNDIAL_cozumel_2016_INSCRIPTIONS_GENDER', 'a.gender', $listDirn, $listOrder); ?>
				</th>
				<th class=''>
				<?php echo JHtml::_('grid.sort',  'COM_MUNDIAL_cozumel_2016_INSCRIPTIONS_EMAIL', 'a.email', $listDirn, $listOrder); ?>
				</th>
				<th class=''>
				<?php echo JHtml::_('grid.sort',  'COM_MUNDIAL_cozumel_2016_INSCRIPTIONS_BIRTHDATE', 'a.birthdate', $listDirn, $listOrder); ?>
				</th>
				<th class=''>
				<?php echo JHtml::_('grid.sort',  'COM_MUNDIAL_cozumel_2016_INSCRIPTIONS_EVENT', 'a.event', $listDirn, $listOrder); ?>
				</th>
				<th class=''>
				<?php echo JHtml::_('grid.sort',  'COM_MUNDIAL_cozumel_2016_INSCRIPTIONS_TSHIRT', 'a.tshirt', $listDirn, $listOrder); ?>
				</th>
				<th class=''>
				<?php echo JHtml::_('grid.sort',  'COM_MUNDIAL_cozumel_2016_INSCRIPTIONS_BLOOD_TYPE', 'a.blood_type', $listDirn, $listOrder); ?>
				</th>
				<th class=''>
				<?php echo JHtml::_('grid.sort',  'COM_MUNDIAL_cozumel_2016_INSCRIPTIONS_HOTEL', 'a.hotel', $listDirn, $listOrder); ?>
				</th>


							<?php if ($canEdit || $canDelete): ?>
					<th class="center">
				<?php echo JText::_('COM_MUNDIAL_cozumel_2016_INSCRIPTIONS_ACTIONS'); ?>
				</th>
				<?php endif; ?>

		</tr>
		</thead>
		<tfoot>
		<tr>
			<td colspan="<?php echo isset($this->items[0]) ? count(get_object_vars($this->items[0])) : 10; ?>">
				<?php echo $this->pagination->getListFooter(); ?>
			</td>
		</tr>
		</tfoot>
		<tbody>
		<?php foreach ($this->items as $i => $item) : ?>
			<?php $canEdit = $user->authorise('core.edit', 'com_mundial_cozumel_2016'); ?>

							<?php if (!$canEdit && $user->authorise('core.edit.own', 'com_mundial_cozumel_2016')): ?>
					<?php $canEdit = JFactory::getUser()->id == $item->created_by; ?>
				<?php endif; ?>

			<tr class="row<?php echo $i % 2; ?>">

				

								<td>

					<?php echo $item->id; ?>
				</td>
				<td>
				<?php if (isset($item->checked_out) && $item->checked_out) : ?>
					<?php echo JHtml::_('jgrid.checkedout', $i, $item->editor, $item->checked_out_time, 'inscriptions.', $canCheckin); ?>
				<?php endif; ?>
				<a href="<?php echo JRoute::_('index.php?option=com_mundial_cozumel_2016&view=inscription&id='.(int) $item->id); ?>">
				<?php echo $this->escape($item->last_name); ?></a>
				</td>
				<td>

					<?php echo $item->name; ?>
				</td>
				<td>

					<?php echo $item->gender; ?>
				</td>
				<td>

					<?php echo $item->email; ?>
				</td>
				<td>

					<?php echo $item->birthdate; ?>
				</td>
				<td>

					<?php echo $item->event; ?>
				</td>
				<td>

					<?php echo $item->tshirt; ?>
				</td>
				<td>

					<?php echo $item->blood_type; ?>
				</td>
				<td>

					<?php echo $item->hotel; ?>
				</td>


								<?php if ($canEdit || $canDelete): ?>
					<td class="center">
						<?php if ($canEdit): ?>
							<a href="<?php echo JRoute::_('index.php?option=com_mundial_cozumel_2016&task=inscriptionform.edit&id=' . $item->id, false, 2); ?>" class="btn btn-mini" type="button"><i class="icon-edit" ></i></a>
						<?php endif; ?>
						<?php if ($canDelete): ?>
							<button data-item-id="<?php echo $item->id; ?>" class="btn btn-mini delete-button" type="button"><i class="icon-trash" ></i></button>
						<?php endif; ?>
					</td>
				<?php endif; ?>

			</tr>
		<?php endforeach; ?>
		</tbody>
	</table>

	<?php if ($canCreate) : ?>
		<a href="<?php echo JRoute::_('index.php?option=com_mundial_cozumel_2016&task=inscriptionform.edit&id=0', false, 2); ?>"
		   class="btn btn-success btn-small"><i
				class="icon-plus"></i>
			<?php echo JText::_('COM_MUNDIAL_cozumel_2016_ADD_ITEM'); ?></a>
	<?php endif; ?>

	<input type="hidden" name="task" value=""/>
	<input type="hidden" name="boxchecked" value="0"/>
	<input type="hidden" name="filter_order" value="<?php echo $listOrder; ?>"/>
	<input type="hidden" name="filter_order_Dir" value="<?php echo $listDirn; ?>"/>
	<?php echo JHtml::_('form.token'); ?>
</form>

<script type="text/javascript">

	jQuery(document).ready(function () {
		jQuery('.delete-button').click(deleteItem);
	});

	function deleteItem() {
		var item_id = jQuery(this).attr('data-item-id');
		<?php if($canDelete) : ?>
		if (confirm("<?php echo JText::_('COM_MUNDIAL_cozumel_2016_DELETE_MESSAGE'); ?>")) {
			window.location.href = '<?php echo JRoute::_('index.php?option=com_mundial_cozumel_2016&task=inscriptionform.remove&id=', false, 2) ?>' + item_id;
		}
		<?php endif; ?>
	}
</script>


