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

JHtml::addIncludePath(JPATH_COMPONENT . '/helpers/html');
JHtml::_('behavior.tooltip');
JHtml::_('behavior.formvalidation');
JHtml::_('formbehavior.chosen', 'select');
JHtml::_('behavior.keepalive');

// Import CSS
$document = JFactory::getDocument();
$document->addStyleSheet(JUri::root() . 'media/com_mundial_cosumel_2016/css/form.css');
?>
<script type="text/javascript">
	js = jQuery.noConflict();
	js(document).ready(function () {
		
	js('input:hidden.gender').each(function(){
		var name = js(this).attr('name');
		if(name.indexOf('genderhidden')){
			js('#jform_gender option[value="'+js(this).val()+'"]').attr('selected',true);
		}
	});
	js("#jform_gender").trigger("liszt:updated");
	js('input:hidden.event').each(function(){
		var name = js(this).attr('name');
		if(name.indexOf('eventhidden')){
			js('#jform_event option[value="'+js(this).val()+'"]').attr('selected',true);
		}
	});
	js("#jform_event").trigger("liszt:updated");
	js('input:hidden.tshirt').each(function(){
		var name = js(this).attr('name');
		if(name.indexOf('tshirthidden')){
			js('#jform_tshirt option[value="'+js(this).val()+'"]').attr('selected',true);
		}
	});
	js("#jform_tshirt").trigger("liszt:updated");
	js('input:hidden.blood_type').each(function(){
		var name = js(this).attr('name');
		if(name.indexOf('blood_typehidden')){
			js('#jform_blood_type option[value="'+js(this).val()+'"]').attr('selected',true);
		}
	});
	js("#jform_blood_type").trigger("liszt:updated");
	});

	Joomla.submitbutton = function (task) {
		if (task == 'inscription.cancel') {
			Joomla.submitform(task, document.getElementById('inscription-form'));
		}
		else {
			
			if (task != 'inscription.cancel' && document.formvalidator.isValid(document.id('inscription-form'))) {
				
				Joomla.submitform(task, document.getElementById('inscription-form'));
			}
			else {
				alert('<?php echo $this->escape(JText::_('JGLOBAL_VALIDATION_FORM_FAILED')); ?>');
			}
		}
	}
</script>

<form
	action="<?php echo JRoute::_('index.php?option=com_mundial_cosumel_2016&layout=edit&id=' . (int) $this->item->id); ?>"
	method="post" enctype="multipart/form-data" name="adminForm" id="inscription-form" class="form-validate">

	<div class="form-horizontal">
		<?php echo JHtml::_('bootstrap.startTabSet', 'myTab', array('active' => 'general')); ?>

		<?php echo JHtml::_('bootstrap.addTab', 'myTab', 'general', JText::_('COM_MUNDIAL_COSUMEL_2016_TITLE_INSCRIPTION', true)); ?>
		<div class="row-fluid">
			<div class="span10 form-horizontal">
				<fieldset class="adminform">

									<input type="hidden" name="jform[id]" value="<?php echo $this->item->id; ?>" />
				<input type="hidden" name="jform[ordering]" value="<?php echo $this->item->ordering; ?>" />
				<input type="hidden" name="jform[state]" value="<?php echo $this->item->state; ?>" />
				<input type="hidden" name="jform[checked_out]" value="<?php echo $this->item->checked_out; ?>" />
				<input type="hidden" name="jform[checked_out_time]" value="<?php echo $this->item->checked_out_time; ?>" />

				<?php if(empty($this->item->created_by)){ ?>
					<input type="hidden" name="jform[created_by]" value="<?php echo JFactory::getUser()->id; ?>" />

				<?php } 
				else{ ?>
					<input type="hidden" name="jform[created_by]" value="<?php echo $this->item->created_by; ?>" />

				<?php } ?>			<div class="control-group">
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

			<?php
				foreach((array)$this->item->gender as $value): 
					if(!is_array($value)):
						echo '<input type="hidden" class="gender" name="jform[genderhidden]['.$value.']" value="'.$value.'" />';
					endif;
				endforeach;
			?>			<div class="control-group">
				<div class="control-label"><?php echo $this->form->getLabel('birthdate'); ?></div>
				<div class="controls"><?php echo $this->form->getInput('birthdate'); ?></div>
			</div>
			<div class="control-group">
				<div class="control-label"><?php echo $this->form->getLabel('event'); ?></div>
				<div class="controls"><?php echo $this->form->getInput('event'); ?></div>
			</div>

			<?php
				foreach((array)$this->item->event as $value): 
					if(!is_array($value)):
						echo '<input type="hidden" class="event" name="jform[eventhidden]['.$value.']" value="'.$value.'" />';
					endif;
				endforeach;
			?>			<div class="control-group">
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

			<?php
				foreach((array)$this->item->tshirt as $value): 
					if(!is_array($value)):
						echo '<input type="hidden" class="tshirt" name="jform[tshirthidden]['.$value.']" value="'.$value.'" />';
					endif;
				endforeach;
			?>			<div class="control-group">
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

			<?php
				foreach((array)$this->item->blood_type as $value): 
					if(!is_array($value)):
						echo '<input type="hidden" class="blood_type" name="jform[blood_typehidden]['.$value.']" value="'.$value.'" />';
					endif;
				endforeach;
			?>			<div class="control-group">
				<div class="control-label"><?php echo $this->form->getLabel('hotel'); ?></div>
				<div class="controls"><?php echo $this->form->getInput('hotel'); ?></div>
			</div>


				</fieldset>
			</div>
		</div>
		<?php echo JHtml::_('bootstrap.endTab'); ?>

		

		<?php echo JHtml::_('bootstrap.endTabSet'); ?>

		<input type="hidden" name="task" value=""/>
		<?php echo JHtml::_('form.token'); ?>

	</div>
</form>
