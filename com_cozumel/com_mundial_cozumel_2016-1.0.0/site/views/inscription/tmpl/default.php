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

$canEdit = JFactory::getUser()->authorise('core.edit', 'com_mundial_cozumel_2016');
if (!$canEdit && JFactory::getUser()->authorise('core.edit.own', 'com_mundial_cozumel_2016')) {
	$canEdit = JFactory::getUser()->id == $this->item->created_by;
}
?>
<?php if ($this->item) : ?>

	<div class="item_fields">
		<table class="table">
			<tr>
			<th><?php echo JText::_('COM_MUNDIAL_COZUMEL_2016_FORM_LBL_INSCRIPTION_STATE'); ?></th>
			<td>
			<i class="icon-<?php echo ($this->item->state == 1) ? 'publish' : 'unpublish'; ?>"></i></td>
</tr>
<tr>
			<th><?php echo JText::_('COM_MUNDIAL_COZUMEL_2016_FORM_LBL_INSCRIPTION_CREATED_BY'); ?></th>
			<td><?php echo $this->item->created_by_name; ?></td>
</tr>
<tr>
			<th><?php echo JText::_('COM_MUNDIAL_COZUMEL_2016_FORM_LBL_INSCRIPTION_LAST_NAME'); ?></th>
			<td><?php echo $this->item->last_name; ?></td>
</tr>
<tr>
			<th><?php echo JText::_('COM_MUNDIAL_COZUMEL_2016_FORM_LBL_INSCRIPTION_NAME'); ?></th>
			<td><?php echo $this->item->name; ?></td>
</tr>
<tr>
			<th><?php echo JText::_('COM_MUNDIAL_COZUMEL_2016_FORM_LBL_INSCRIPTION_GENDER'); ?></th>
			<td><?php echo $this->item->gender; ?></td>
</tr>
<tr>
			<th><?php echo JText::_('COM_MUNDIAL_COZUMEL_2016_FORM_LBL_INSCRIPTION_BIRTHDATE'); ?></th>
			<td><?php echo $this->item->birthdate; ?></td>
</tr>
<tr>
			<th><?php echo JText::_('COM_MUNDIAL_COZUMEL_2016_FORM_LBL_INSCRIPTION_EVENT'); ?></th>
			<td><?php echo $this->item->event; ?></td>
</tr>
<tr>
			<th><?php echo JText::_('COM_MUNDIAL_COZUMEL_2016_FORM_LBL_INSCRIPTION_EMAIL'); ?></th>
			<td><?php echo $this->item->email; ?></td>
</tr>
<tr>
			<th><?php echo JText::_('COM_MUNDIAL_COZUMEL_2016_FORM_LBL_INSCRIPTION_PHONE'); ?></th>
			<td><?php echo $this->item->phone; ?></td>
</tr>
<tr>
			<th><?php echo JText::_('COM_MUNDIAL_COZUMEL_2016_FORM_LBL_INSCRIPTION_TSHIRT'); ?></th>
			<td><?php echo $this->item->tshirt; ?></td>
</tr>
<tr>
			<th><?php echo JText::_('COM_MUNDIAL_COZUMEL_2016_FORM_LBL_INSCRIPTION_EMERGENCY_CONTACT'); ?></th>
			<td><?php echo $this->item->emergency_contact; ?></td>
</tr>
<tr>
			<th><?php echo JText::_('COM_MUNDIAL_COZUMEL_2016_FORM_LBL_INSCRIPTION_EMERGENCY_PHONE'); ?></th>
			<td><?php echo $this->item->emergency_phone; ?></td>
</tr>
<tr>
			<th><?php echo JText::_('COM_MUNDIAL_COZUMEL_2016_FORM_LBL_INSCRIPTION_ALLERGIES'); ?></th>
			<td><?php echo $this->item->allergies; ?></td>
</tr>
<tr>
			<th><?php echo JText::_('COM_MUNDIAL_COZUMEL_2016_FORM_LBL_INSCRIPTION_BLOOD_TYPE'); ?></th>
			<td><?php echo $this->item->blood_type; ?></td>
</tr>
<tr>
			<th><?php echo JText::_('COM_MUNDIAL_COZUMEL_2016_FORM_LBL_INSCRIPTION_HOTEL'); ?></th>
			<td><?php echo $this->item->hotel; ?></td>
</tr>

		</table>
	</div>
	<?php if($canEdit && $this->item->checked_out == 0): ?>
		<a class="btn" href="<?php echo JRoute::_('index.php?option=com_mundial_cozumel_2016&task=inscription.edit&id='.$this->item->id); ?>"><?php echo JText::_("COM_MUNDIAL_COZUMEL_2016_EDIT_ITEM"); ?></a>
	<?php endif; ?>
								<?php if(JFactory::getUser()->authorise('core.delete','com_mundial_cozumel_2016')):?>
									<a class="btn" href="<?php echo JRoute::_('index.php?option=com_mundial_cozumel_2016&task=inscription.remove&id=' . $this->item->id, false, 2); ?>"><?php echo JText::_("COM_MUNDIAL_COZUMEL_2016_DELETE_ITEM"); ?></a>
								<?php endif; ?>
	<?php
else:
	echo JText::_('COM_MUNDIAL_COZUMEL_2016_ITEM_NOT_LOADED');
endif;
