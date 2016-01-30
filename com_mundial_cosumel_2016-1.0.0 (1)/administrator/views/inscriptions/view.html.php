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

jimport('joomla.application.component.view');

/**
 * View class for a list of Mundial_cosumel_2016.
 *
 * @since  1.6
 */
class Mundial_cosumel_2016ViewInscriptions extends JViewLegacy
{
	protected $items;

	protected $pagination;

	protected $state;

	/**
	 * Display the view
	 *
	 * @param   string  $tpl  Template name
	 *
	 * @return void
	 *
	 * @throws Exception
	 */
	public function display($tpl = null)
	{
		$this->state = $this->get('State');
		$this->items = $this->get('Items');
		$this->pagination = $this->get('Pagination');

		// Check for errors.
		if (count($errors = $this->get('Errors')))
		{
			throw new Exception(implode("\n", $errors));
		}

		Mundial_cosumel_2016Helper::addSubmenu('inscriptions');

		$this->addToolbar();

		$this->sidebar = JHtmlSidebar::render();
		parent::display($tpl);
	}

	/**
	 * Add the page title and toolbar.
	 *
	 * @return void
	 *
	 * @since    1.6
	 */
	protected function addToolbar()
	{
		require_once JPATH_COMPONENT . '/helpers/mundial_cosumel_2016.php';

		$state = $this->get('State');
		$canDo = Mundial_cosumel_2016Helper::getActions($state->get('filter.category_id'));

		JToolBarHelper::title(JText::_('COM_MUNDIAL_COSUMEL_2016_TITLE_INSCRIPTIONS'), 'inscriptions.png');

		// Check if the form exists before showing the add/edit buttons
		$formPath = JPATH_COMPONENT_ADMINISTRATOR . '/views/inscription';

		if (file_exists($formPath))
		{
			if ($canDo->get('core.create'))
			{
				JToolBarHelper::addNew('inscription.add', 'JTOOLBAR_NEW');
				JToolbarHelper::custom('inscriptions.duplicate', 'copy.png', 'copy_f2.png', 'JTOOLBAR_DUPLICATE', true);
			}

			if ($canDo->get('core.edit') && isset($this->items[0]))
			{
				JToolBarHelper::editList('inscription.edit', 'JTOOLBAR_EDIT');
			}
		}

		if ($canDo->get('core.edit.state'))
		{
			if (isset($this->items[0]->state))
			{
				JToolBarHelper::divider();
				JToolBarHelper::custom('inscriptions.publish', 'publish.png', 'publish_f2.png', 'JTOOLBAR_PUBLISH', true);
				JToolBarHelper::custom('inscriptions.unpublish', 'unpublish.png', 'unpublish_f2.png', 'JTOOLBAR_UNPUBLISH', true);
			}
			elseif (isset($this->items[0]))
			{
				// If this component does not use state then show a direct delete button as we can not trash
				JToolBarHelper::deleteList('', 'inscriptions.delete', 'JTOOLBAR_DELETE');
			}

			if (isset($this->items[0]->state))
			{
				JToolBarHelper::divider();
				JToolBarHelper::archiveList('inscriptions.archive', 'JTOOLBAR_ARCHIVE');
			}

			if (isset($this->items[0]->checked_out))
			{
				JToolBarHelper::custom('inscriptions.checkin', 'checkin.png', 'checkin_f2.png', 'JTOOLBAR_CHECKIN', true);
			}
		}

		// Show trash and delete for components that uses the state field
		if (isset($this->items[0]->state))
		{
			if ($state->get('filter.state') == -2 && $canDo->get('core.delete'))
			{
				JToolBarHelper::deleteList('', 'inscriptions.delete', 'JTOOLBAR_EMPTY_TRASH');
				JToolBarHelper::divider();
			}
			elseif ($canDo->get('core.edit.state'))
			{
				JToolBarHelper::trash('inscriptions.trash', 'JTOOLBAR_TRASH');
				JToolBarHelper::divider();
			}
		}

		if ($canDo->get('core.admin'))
		{
			JToolBarHelper::preferences('com_mundial_cosumel_2016');
		}

		// Set sidebar action - New in 3.0
		JHtmlSidebar::setAction('index.php?option=com_mundial_cosumel_2016&view=inscriptions');

		$this->extra_sidebar = '';
		JHtmlSidebar::addFilter(

			JText::_('JOPTION_SELECT_PUBLISHED'),

			'filter_published',

			JHtml::_('select.options', JHtml::_('jgrid.publishedOptions'), "value", "text", $this->state->get('filter.state'), true)

		);                                                
        //Filter for the field tshirt;
        jimport('joomla.form.form');
        $options = array();
        JForm::addFormPath(JPATH_COMPONENT . '/models/forms');
        $form = JForm::getInstance('com_mundial_cosumel_2016.inscription', 'inscription');

        $field = $form->getField('tshirt');

        $query = $form->getFieldAttribute('filter_tshirt','query');
        $translate = $form->getFieldAttribute('filter_tshirt','translate');
        $key = $form->getFieldAttribute('filter_tshirt','key_field');
        $value = $form->getFieldAttribute('filter_tshirt','value_field');

        // Get the database object.
        $db = JFactory::getDBO();

        // Set the query and get the result list.
        $db->setQuery($query);
        $items = $db->loadObjectlist();

        // Build the field options.
        if (!empty($items))
        {
            foreach ($items as $item)
            {
                if ($translate == true)
                {
                    $options[] = JHtml::_('select.option', $item->$key, JText::_($item->$value));
                }
                else
                {
                    $options[] = JHtml::_('select.option', $item->$key, $item->$value);
                }
            }
        }

        JHtmlSidebar::addFilter(
            '$T-Shirt',
            'filter_tshirt',
            JHtml::_('select.options', $options, "value", "text", $this->state->get('filter.tshirt')),
            true
        );                                                
        //Filter for the field blood_type;
        jimport('joomla.form.form');
        $options = array();
        JForm::addFormPath(JPATH_COMPONENT . '/models/forms');
        $form = JForm::getInstance('com_mundial_cosumel_2016.inscription', 'inscription');

        $field = $form->getField('blood_type');

        $query = $form->getFieldAttribute('filter_blood_type','query');
        $translate = $form->getFieldAttribute('filter_blood_type','translate');
        $key = $form->getFieldAttribute('filter_blood_type','key_field');
        $value = $form->getFieldAttribute('filter_blood_type','value_field');

        // Get the database object.
        $db = JFactory::getDBO();

        // Set the query and get the result list.
        $db->setQuery($query);
        $items = $db->loadObjectlist();

        // Build the field options.
        if (!empty($items))
        {
            foreach ($items as $item)
            {
                if ($translate == true)
                {
                    $options[] = JHtml::_('select.option', $item->$key, JText::_($item->$value));
                }
                else
                {
                    $options[] = JHtml::_('select.option', $item->$key, $item->$value);
                }
            }
        }

        JHtmlSidebar::addFilter(
            '$Blood Type',
            'filter_blood_type',
            JHtml::_('select.options', $options, "value", "text", $this->state->get('filter.blood_type')),
            true
        );
	}

	/**
	 * Method to order fields 
	 *
	 * @return void 
	 */
	protected function getSortFields()
	{
		return array(
			'a.`id`' => JText::_('JGRID_HEADING_ID'),
			'a.`ordering`' => JText::_('JGRID_HEADING_ORDERING'),
			'a.`state`' => JText::_('JSTATUS'),
			'a.`last_name`' => JText::_('COM_MUNDIAL_COSUMEL_2016_INSCRIPTIONS_LAST_NAME'),
			'a.`name`' => JText::_('COM_MUNDIAL_COSUMEL_2016_INSCRIPTIONS_NAME'),
			'a.`gender`' => JText::_('COM_MUNDIAL_COSUMEL_2016_INSCRIPTIONS_GENDER'),
			'a.`birthdate`' => JText::_('COM_MUNDIAL_COSUMEL_2016_INSCRIPTIONS_BIRTHDATE'),
			'a.`event`' => JText::_('COM_MUNDIAL_COSUMEL_2016_INSCRIPTIONS_EVENT'),
			'a.`tshirt`' => JText::_('COM_MUNDIAL_COSUMEL_2016_INSCRIPTIONS_TSHIRT'),
			'a.`blood_type`' => JText::_('COM_MUNDIAL_COSUMEL_2016_INSCRIPTIONS_BLOOD_TYPE'),
			'a.`hotel`' => JText::_('COM_MUNDIAL_COSUMEL_2016_INSCRIPTIONS_HOTEL'),
		);
	}
}
