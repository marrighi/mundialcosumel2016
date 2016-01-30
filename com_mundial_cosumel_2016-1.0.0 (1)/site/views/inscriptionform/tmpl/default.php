<?php
/**
 * @version    CVS: 1.0.0
 * @package    Com_Mundial_cosumel_2016
 * @author     Arrighi <marrighi@gmail.com>
 * @copyright  Copyright (C) 2016. Todos los derechos reservados.
 * @license    Licencia Pública General GNU versión 2 o posterior. Consulte LICENSE.txt
 */
// No direct access
defined('_JEXEC') or die;

JHtml::_('behavior.keepalive');
JHtml::_('behavior.tooltip');
JHtml::_('behavior.formvalidation');
JHtml::_('formbehavior.chosen', 'select');

// Load admin language file
$lang = JFactory::getLanguage();
$lang->load('com_mundial_cosumel_2016', JPATH_SITE);
$doc = JFactory::getDocument();
$doc->addScript(JUri::base() . '/media/com_mundial_cosumel_2016/js/form.js');

/**/
?>
<script type="text/javascript">
	if (jQuery === 'undefined') {
		document.addEventListener("DOMContentLoaded", function (event) {
			jQuery('#form-inscription').submit(function (event) {
				
			});

			
			jQuery('input:hidden.gender').each(function(){
				var name = jQuery(this).attr('name');
				if(name.indexOf('genderhidden')){
					jQuery('#jform_gender option[value="' + jQuery(this).val() + '"]').attr('selected',true);
				}
			});
					jQuery("#jform_gender").trigger("liszt:updated");
			jQuery('input:hidden.event').each(function(){
				var name = jQuery(this).attr('name');
				if(name.indexOf('eventhidden')){
					jQuery('#jform_event option[value="' + jQuery(this).val() + '"]').attr('selected',true);
				}
			});
					jQuery("#jform_event").trigger("liszt:updated");
			jQuery('input:hidden.tshirt').each(function(){
				var name = jQuery(this).attr('name');
				if(name.indexOf('tshirthidden')){
					jQuery('#jform_tshirt option[value="' + jQuery(this).val() + '"]').attr('selected',true);
				}
			});
					jQuery("#jform_tshirt").trigger("liszt:updated");
			jQuery('input:hidden.blood_type').each(function(){
				var name = jQuery(this).attr('name');
				if(name.indexOf('blood_typehidden')){
					jQuery('#jform_blood_type option[value="' + jQuery(this).val() + '"]').attr('selected',true);
				}
			});
					jQuery("#jform_blood_type").trigger("liszt:updated");
		});
	} else {
		jQuery(document).ready(function () {
			jQuery('#form-inscription').submit(function (event) {
				
			});

			
			jQuery('input:hidden.gender').each(function(){
				var name = jQuery(this).attr('name');
				if(name.indexOf('genderhidden')){
					jQuery('#jform_gender option[value="' + jQuery(this).val() + '"]').attr('selected',true);
				}
			});
					jQuery("#jform_gender").trigger("liszt:updated");
			jQuery('input:hidden.event').each(function(){
				var name = jQuery(this).attr('name');
				if(name.indexOf('eventhidden')){
					jQuery('#jform_event option[value="' + jQuery(this).val() + '"]').attr('selected',true);
				}
			});
					jQuery("#jform_event").trigger("liszt:updated");
			jQuery('input:hidden.tshirt').each(function(){
				var name = jQuery(this).attr('name');
				if(name.indexOf('tshirthidden')){
					jQuery('#jform_tshirt option[value="' + jQuery(this).val() + '"]').attr('selected',true);
				}
			});
					jQuery("#jform_tshirt").trigger("liszt:updated");
			jQuery('input:hidden.blood_type').each(function(){
				var name = jQuery(this).attr('name');
				if(name.indexOf('blood_typehidden')){
					jQuery('#jform_blood_type option[value="' + jQuery(this).val() + '"]').attr('selected',true);
				}
			});
					jQuery("#jform_blood_type").trigger("liszt:updated");
		});
	}
</script>

<div class="inscription-edit front-end-edit">
	<?php if (!empty($this->item->id)): ?>
		<h1>Edit <?php echo $this->item->id; ?></h1>
	<?php else: ?>
		<h1>Add</h1>
	<?php endif; ?>

	<form id="form-inscription"
		  action="<?php echo JRoute::_('index.php?option=com_mundial_cosumel_2016&task=inscription.save'); ?>"
		  method="post" class="form-validate form-horizontal" enctype="multipart/form-data">
		
	<input type="hidden" name="jform[id]" value="<?php echo $this->item->id; ?>" />

	<input type="hidden" name="jform[ordering]" value="<?php echo $this->item->ordering; ?>" />

	<input type="hidden" name="jform[state]" value="<?php echo $this->item->state; ?>" />

	<input type="hidden" name="jform[checked_out]" value="<?php echo $this->item->checked_out; ?>" />

	<input type="hidden" name="jform[checked_out_time]" value="<?php echo $this->item->checked_out_time; ?>" />

	<?php if(empty($this->item->created_by)): ?>
		<input type="hidden" name="jform[created_by]" value="<?php echo JFactory::getUser()->id; ?>" />
	<?php else: ?>
		<input type="hidden" name="jform[created_by]" value="<?php echo $this->item->created_by; ?>" />
	<?php endif; ?>
	<div class="control-group">
		<div class="control-label"><?php echo $this->form->getLabel('last_name'); ?></div>
		<div class="controls"><?php echo $this->form->getInput('last_name'); ?></div>
	</div>
	<div class="control-group">
		<div class="control-label"><?php echo $this->form->getLabel('name'); ?></div>
		<div class="controls"><?php echo $this->form->getInput('name'); ?></div>
	</div>
	<div class="control-group">
		<div class="control-label"><?php echo $this->form->getLabel('gender'); ?></div>
		<div class="controls"><?php echo $this->form->getInput('gender'); ?></div>
	</div>
	<?php foreach((array)$this->item->gender as $value): ?>
		<?php if(!is_array($value)): ?>
			<input type="hidden" class="gender" name="jform[genderhidden][<?php echo $value; ?>]" value="<?php echo $value; ?>" />
		<?php endif; ?>
	<?php endforeach; ?>
	<div class="control-group">
		<div class="control-label"><?php echo $this->form->getLabel('birthdate'); ?></div>
		<div class="controls"><?php echo $this->form->getInput('birthdate'); ?></div>
	</div>
	<div class="control-group">
		<div class="control-label"><?php echo $this->form->getLabel('event'); ?></div>
		<div class="controls"><?php echo $this->form->getInput('event'); ?></div>
	</div>
	<?php foreach((array)$this->item->event as $value): ?>
		<?php if(!is_array($value)): ?>
			<input type="hidden" class="event" name="jform[eventhidden][<?php echo $value; ?>]" value="<?php echo $value; ?>" />
		<?php endif; ?>
	<?php endforeach; ?>
	<div class="control-group">
		<div class="control-label"><?php echo $this->form->getLabel('email'); ?></div>
		<div class="controls"><?php echo $this->form->getInput('email'); ?></div>
	</div>
	<div class="control-group">
		<div class="control-label"><?php echo $this->form->getLabel('phone'); ?></div>
		<div class="controls"><?php echo $this->form->getInput('phone'); ?></div>
	</div>
	<div class="control-group">
		<div class="control-label"><?php echo $this->form->getLabel('tshirt'); ?></div>
		<div class="controls"><?php echo $this->form->getInput('tshirt'); ?></div>
	</div>
	<?php foreach((array)$this->item->tshirt as $value): ?>
		<?php if(!is_array($value)): ?>
			<input type="hidden" class="tshirt" name="jform[tshirthidden][<?php echo $value; ?>]" value="<?php echo $value; ?>" />
		<?php endif; ?>
	<?php endforeach; ?>
	<div class="control-group">
		<div class="control-label"><?php echo $this->form->getLabel('emergency_contact'); ?></div>
		<div class="controls"><?php echo $this->form->getInput('emergency_contact'); ?></div>
	</div>
	<div class="control-group">
		<div class="control-label"><?php echo $this->form->getLabel('emergency_phone'); ?></div>
		<div class="controls"><?php echo $this->form->getInput('emergency_phone'); ?></div>
	</div>
	<div class="control-group">
		<div class="control-label"><?php echo $this->form->getLabel('allergies'); ?></div>
		<div class="controls"><?php echo $this->form->getInput('allergies'); ?></div>
	</div>
	<div class="control-group">
		<div class="control-label"><?php echo $this->form->getLabel('blood_type'); ?></div>
		<div class="controls"><?php echo $this->form->getInput('blood_type'); ?></div>
	</div>
	<?php foreach((array)$this->item->blood_type as $value): ?>
		<?php if(!is_array($value)): ?>
			<input type="hidden" class="blood_type" name="jform[blood_typehidden][<?php echo $value; ?>]" value="<?php echo $value; ?>" />
		<?php endif; ?>
	<?php endforeach; ?>
	<div class="control-group">
		<div class="control-label"><?php echo $this->form->getLabel('hotel'); ?></div>
		<div class="controls"><?php echo $this->form->getInput('hotel'); ?></div>
	</div>
		<div class="control-group">
			<div class="controls">

				<?php if ($this->canSave): ?>
					<button type="submit" class="validate btn btn-primary">
						<?php echo JText::_('JSUBMIT'); ?>
					</button>
				<?php endif; ?>
				<a class="btn"
				   href="<?php echo JRoute::_('index.php?option=com_mundial_cosumel_2016&task=inscriptionform.cancel'); ?>"
				   title="<?php echo JText::_('JCANCEL'); ?>">
					<?php echo JText::_('JCANCEL'); ?>
				</a>
			</div>
		</div>

		<input type="hidden" name="option" value="com_mundial_cosumel_2016"/>
		<input type="hidden" name="task"
			   value="inscriptionform.save"/>
		<?php echo JHtml::_('form.token'); ?>
	</form>
</div>
