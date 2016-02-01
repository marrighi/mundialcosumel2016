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

require_once JPATH_COMPONENT . '/controller.php';

/**
 * Inscription controller class.
 *
 * @since  1.6
 */
class Mundial_cozumel_2016ControllerInscriptionForm extends Mundial_cozumel_2016Controller
{
	/**
	 * Method to check out an item for editing and redirect to the edit form.
	 *
	 * @return void
	 *
	 * @since    1.6
	 */
	public function edit()
	{
		$app = JFactory::getApplication();

		// Get the previous edit id (if any) and the current edit id.
		$previousId = (int) $app->getUserState('com_mundial_cozumel_2016.edit.inscription.id');
		$editId     = $app->input->getInt('id', 0);

		// Set the user id for the user to edit in the session.
		$app->setUserState('com_mundial_cozumel_2016.edit.inscription.id', $editId);

		// Get the model.
		$model = $this->getModel('InscriptionForm', 'Mundial_cozumel_2016Model');

		// Check out the item
		if ($editId)
		{
			$model->checkout($editId);
		}

		// Check in the previous user.
		if ($previousId)
		{
			$model->checkin($previousId);
		}

		// Redirect to the edit screen.
		$this->setRedirect(JRoute::_('index.php?option=com_mundial_cozumel_2016&view=inscriptionform&layout=edit', false));
	}

	/**
	 * Method to save a user's profile data.
	 *
	 * @return void
	 *
	 * @throws Exception
	 * @since  1.6
	 */
	public function save()
	{
		// Check for request forgeries.
		JSession::checkToken() or jexit(JText::_('JINVALID_TOKEN'));

		// Initialise variables.
		$app   = JFactory::getApplication();
		$model = $this->getModel('InscriptionForm', 'Mundial_cozumel_2016Model');

		// Get the user data.
		$data = JFactory::getApplication()->input->get('jform', array(), 'array');

		// Validate the posted data.
		$form = $model->getForm();

		if (!$form)
		{
			throw new Exception($model->getError(), 500);
		}

		// Validate the posted data.
		$data = $model->validate($form, $data);

		// Check for errors.
		if ($data === false)
		{
			// Get the validation messages.
			$errors = $model->getErrors();

			// Push up to three validation messages out to the user.
			for ($i = 0, $n = count($errors); $i < $n && $i < 3; $i++)
			{
				if ($errors[$i] instanceof Exception)
				{
					$app->enqueueMessage($errors[$i]->getMessage(), 'warning');
				}
				else
				{
					$app->enqueueMessage($errors[$i], 'warning');
				}
			}

			$input = $app->input;
			$jform = $input->get('jform', array(), 'ARRAY');

			// Save the data in the session.
			$app->setUserState('com_mundial_cozumel_2016.edit.inscription.data', $jform);

			// Redirect back to the edit screen.
			$id = (int) $app->getUserState('com_mundial_cozumel_2016.edit.inscription.id');
			$this->setRedirect(JRoute::_('index.php?option=com_mundial_cozumel_2016&view=inscriptionform&layout=edit&id=' . $id, false));
		}
		else
		{

		// Attempt to save the data.
		$return = $model->save($data);

		// Check for errors.
		if ($return === false)
		{
			// Save the data in the session.
			$app->setUserState('com_mundial_cozumel_2016.edit.inscription.data', $data);

			// Redirect back to the edit screen.
			$id = (int) $app->getUserState('com_mundial_cozumel_2016.edit.inscription.id');
			$this->setMessage(JText::sprintf('Save failed', $model->getError()), 'warning');
			$this->setRedirect(JRoute::_('index.php?option=com_mundial_cozumel_2016&view=inscriptionform&layout=edit&id=' . $id, false));
		}

		// Check in the profile.
		if ($return)
		{
			$model->checkin($return);
		}

		// Clear the profile id from the session.
		$app->setUserState('com_mundial_cozumel_2016.edit.inscription.id', null);

		// Redirect to the list screen.
		$this->setMessage(JText::_('COM_MUNDIAL_COZUMEL_2016_ITEM_SAVED_SUCCESSFULLY'));
		$menu = JFactory::getApplication()->getMenu();
		$item = $menu->getActive();
		$url  = (empty($item->link) ? 'index.php?option=com_mundial_cozumel_2016&view=inscriptions' : $item->link);
		$this->setRedirect(JRoute::_($url, false));

		// Flush the data from the session.
		$app->setUserState('com_mundial_cozumel_2016.edit.inscription.data', null);
	}}

	/**
	 * Method to abort current operation
	 *
	 * @return void
	 *
	 * @throws Exception
	 */
	public function cancel()
	{
		$app = JFactory::getApplication();

		// Get the current edit id.
		$editId = (int) $app->getUserState('com_mundial_cozumel_2016.edit.inscription.id');

		// Get the model.
		$model = $this->getModel('InscriptionForm', 'Mundial_cozumel_2016Model');

		// Check in the item
		if ($editId)
		{
			$model->checkin($editId);
		}

		$menu = JFactory::getApplication()->getMenu();
		$item = $menu->getActive();
		$url  = (empty($item->link) ? 'index.php?option=com_mundial_cozumel_2016&view=inscriptions' : $item->link);
		$this->setRedirect(JRoute::_($url, false));
	}

	/**
	 * Method to remove data
	 *
	 * @return void
	 *
	 * @throws Exception
	 */
	public function remove()
	{
		// Initialise variables.
		$app   = JFactory::getApplication();
		$model = $this->getModel('InscriptionForm', 'Mundial_cozumel_2016Model');

		// Get the user data.
		$data       = array();
		$data['id'] = $app->input->getInt('id');

		// Check for errors.
		if (empty($data['id']))
		{
			// Get the validation messages.
			$errors = $model->getErrors();

			// Push up to three validation messages out to the user.
			for ($i = 0, $n = count($errors); $i < $n && $i < 3; $i++)
			{
				if ($errors[$i] instanceof Exception)
				{
					$app->enqueueMessage($errors[$i]->getMessage(), 'warning');
				}
				else
				{
					$app->enqueueMessage($errors[$i], 'warning');
				}
			}

			// Save the data in the session.
			$app->setUserState('com_mundial_cozumel_2016.edit.inscription.data', $data);

			// Redirect back to the edit screen.
			$id = (int) $app->getUserState('com_mundial_cozumel_2016.edit.inscription.id');
			$this->setRedirect(JRoute::_('index.php?option=com_mundial_cozumel_2016&view=inscription&layout=edit&id=' . $id, false));
		}

		// Attempt to save the data.
		$return = $model->delete($data);

		// Check for errors.
		if ($return === false)
		{
			// Save the data in the session.
			$app->setUserState('com_mundial_cozumel_2016.edit.inscription.data', $data);

			// Redirect back to the edit screen.
			$id = (int) $app->getUserState('com_mundial_cozumel_2016.edit.inscription.id');
			$this->setMessage(JText::sprintf('Delete failed', $model->getError()), 'warning');
			$this->setRedirect(JRoute::_('index.php?option=com_mundial_cozumel_2016&view=inscription&layout=edit&id=' . $id, false));
		}

		// Check in the profile.
		if ($return)
		{
			$model->checkin($return);
		}

		// Clear the profile id from the session.
		$app->setUserState('com_mundial_cozumel_2016.edit.inscription.id', null);

		// Redirect to the list screen.
		$this->setMessage(JText::_('COM_MUNDIAL_COZUMEL_2016_ITEM_DELETED_SUCCESSFULLY'));
		$menu = JFactory::getApplication()->getMenu();
		$item = $menu->getActive();
		$url  = (empty($item->link) ? 'index.php?option=com_mundial_cozumel_2016&view=inscriptions' : $item->link);
		$this->setRedirect(JRoute::_($url, false));

		// Flush the data from the session.
		$app->setUserState('com_mundial_cozumel_2016.edit.inscription.data', null);
	}
}
