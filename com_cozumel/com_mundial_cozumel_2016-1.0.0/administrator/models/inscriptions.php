<?php

/**
 * @version    CVS: 1.0.0
 * @package    Com_Mundial_cozumel_2016
 * @author     Arrighi <marrighi@gmail.com>
 * @copyright  Copyright (C) 2016. Todos los derechos reservados.
 * @license    Licencia Pública General GNU versión 2 o posterior. Consulte LICENSE.txt
 */
defined('_JEXEC') or die;

jimport('joomla.application.component.modellist');

/**
 * Methods supporting a list of Mundial_cozumel_2016 records.
 *
 * @since  1.6
 */
class Mundial_cozumel_2016ModelInscriptions extends JModelList
{
/**
	* Constructor.
	*
	* @param   array  $config  An optional associative array of configuration settings.
	*
	* @see        JController
	* @since      1.6
	*/
	public function __construct($config = array())
	{
		if (empty($config['filter_fields']))
		{
			$config['filter_fields'] = array(
				'id', 'a.`id`',
				'ordering', 'a.`ordering`',
				'state', 'a.`state`',
				'created_by', 'a.`created_by`',
				'last_name', 'a.`last_name`',
				'name', 'a.`name`',
				'gender', 'a.`gender`',
				'birthdate', 'a.`birthdate`',
				'event', 'a.`event`',
				'email', 'a.`email`',
				'phone', 'a.`phone`',
				'tshirt', 'a.`tshirt`',
				'emergency_contact', 'a.`emergency_contact`',
				'emergency_phone', 'a.`emergency_phone`',
				'allergies', 'a.`allergies`',
				'blood_type', 'a.`blood_type`',
				'hotel', 'a.`hotel`',
			);
		}

		parent::__construct($config);
	}

	/**
	 * Method to auto-populate the model state.
	 *
	 * Note. Calling getState in this method will result in recursion.
	 *
	 * @param   string  $ordering   Elements order
	 * @param   string  $direction  Order direction
	 *
	 * @return void
	 *
	 * @throws Exception
	 */
	protected function populateState($ordering = null, $direction = null)
	{
		// Initialise variables.
		$app = JFactory::getApplication('administrator');

		// Load the filter state.
		$search = $app->getUserStateFromRequest($this->context . '.filter.search', 'filter_search');
		$this->setState('filter.search', $search);

		$published = $app->getUserStateFromRequest($this->context . '.filter.state', 'filter_published', '', 'string');
		$this->setState('filter.state', $published);
		// Filtering tshirt
		$this->setState('filter.tshirt', $app->getUserStateFromRequest($this->context.'.filter.tshirt', 'filter_tshirt', '', 'string'));

		// Filtering blood_type
		$this->setState('filter.blood_type', $app->getUserStateFromRequest($this->context.'.filter.blood_type', 'filter_blood_type', '', 'string'));


		// Load the parameters.
		$params = JComponentHelper::getParams('com_mundial_cozumel_2016');
		$this->setState('params', $params);

		// List state information.
		parent::populateState('a.last_name', 'asc');
	}

	/**
	 * Method to get a store id based on model configuration state.
	 *
	 * This is necessary because the model is used by the component and
	 * different modules that might need different sets of data or different
	 * ordering requirements.
	 *
	 * @param   string  $id  A prefix for the store id.
	 *
	 * @return   string A store id.
	 *
	 * @since    1.6
	 */
	protected function getStoreId($id = '')
	{
		// Compile the store id.
		$id .= ':' . $this->getState('filter.search');
		$id .= ':' . $this->getState('filter.state');

		return parent::getStoreId($id);
	}

	/**
	 * Build an SQL query to load the list data.
	 *
	 * @return   JDatabaseQuery
	 *
	 * @since    1.6
	 */
	protected function getListQuery()
	{
		// Create a new query object.
		$db    = $this->getDbo();
		$query = $db->getQuery(true);

		// Select the required fields from the table.
		$query->select(
			$this->getState(
				'list.select', 'DISTINCT a.*'
			)
		);
		$query->from('`#__mc2016_inscripcion` AS a');

		// Join over the users for the checked out user
		$query->select("uc.name AS editor");
		$query->join("LEFT", "#__users AS uc ON uc.id=a.checked_out");

		// Join over the user field 'created_by'
		$query->select('`created_by`.name AS `created_by`');
		$query->join('LEFT', '#__users AS `created_by` ON `created_by`.id = a.`created_by`');
		// Join over the foreign key 'gender'
		$query->select('#__contact_details_2231319.`name` AS contact_details_name_2231319');
		$query->join('LEFT', '#__contact_details AS #__contact_details_2231319 ON #__contact_details_2231319.`id` = a.`gender`');
		// Join over the foreign key 'event'
		$query->select('#__contact_details_2231327.`name` AS contact_details_name_2231327');
		$query->join('LEFT', '#__contact_details AS #__contact_details_2231327 ON #__contact_details_2231327.`id` = a.`event`');
		// Join over the foreign key 'tshirt'
		$query->select('#__contact_details_2231334.`name` AS contact_details_name_2231334');
		$query->join('LEFT', '#__contact_details AS #__contact_details_2231334 ON #__contact_details_2231334.`id` = a.`tshirt`');
		// Join over the foreign key 'blood_type'
		$query->select('#__contact_details_2231362.`name` AS contact_details_name_2231362');
		$query->join('LEFT', '#__contact_details AS #__contact_details_2231362 ON #__contact_details_2231362.`id` = a.`blood_type`');

		// Filter by published state
		$published = $this->getState('filter.state');

		if (is_numeric($published))
		{
			$query->where('a.state = ' . (int) $published);
		}
		elseif ($published === '')
		{
			$query->where('(a.state IN (0, 1))');
		}

		// Filter by search in title
		$search = $this->getState('filter.search');

		if (!empty($search))
		{
			if (stripos($search, 'id:') === 0)
			{
				$query->where('a.id = ' . (int) substr($search, 3));
			}
			else
			{
				$search = $db->Quote('%' . $db->escape($search, true) . '%');
				$query->where('( a.`last_name` LIKE ' . $search . '  OR  a.`name` LIKE ' . $search . '  OR  a.`hotel` LIKE ' . $search . ' )');
			}
		}


		//Filtering tshirt
		$filter_tshirt = $this->state->get("filter.tshirt");
		if ($filter_tshirt)
		{
			$query->where("a.`tshirt` = '".$db->escape($filter_tshirt)."'");
		}

		//Filtering blood_type
		$filter_blood_type = $this->state->get("filter.blood_type");
		if ($filter_blood_type)
		{
			$query->where("a.`blood_type` = '".$db->escape($filter_blood_type)."'");
		}
		// Add the list ordering clause.
		$orderCol  = $this->state->get('list.ordering');
		$orderDirn = $this->state->get('list.direction');

		if ($orderCol && $orderDirn)
		{
			$query->order($db->escape($orderCol . ' ' . $orderDirn));
		}

		return $query;
	}

	/**
	 * Get an array of data items
	 *
	 * @return mixed Array of data items on success, false on failure.
	 */
	public function getItems()
	{
		$items = parent::getItems();

		foreach ($items as $oneItem) {

			if (isset($oneItem->gender)) {
				$values = explode(',', $oneItem->gender);

				$textValue = array();
				foreach ($values as $value){
					$db = JFactory::getDbo();
					$query = $db->getQuery(true);
					$query
							->select($db->quoteName('name'))
							->from('`#__contact_details`')
							->where($db->quoteName('id') . ' = '. $db->quote($db->escape($value)));
					$db->setQuery($query);
					$results = $db->loadObject();
					if ($results) {
						$textValue[] = $results->name;
					}
				}

			$oneItem->gender = !empty($textValue) ? implode(', ', $textValue) : $oneItem->gender;

			}

			if (isset($oneItem->event)) {
				$values = explode(',', $oneItem->event);

				$textValue = array();
				foreach ($values as $value){
					$db = JFactory::getDbo();
					$query = $db->getQuery(true);
					$query
							->select($db->quoteName('name'))
							->from('`#__contact_details`')
							->where($db->quoteName('id') . ' = '. $db->quote($db->escape($value)));
					$db->setQuery($query);
					$results = $db->loadObject();
					if ($results) {
						$textValue[] = $results->name;
					}
				}

			$oneItem->event = !empty($textValue) ? implode(', ', $textValue) : $oneItem->event;

			}

			if (isset($oneItem->tshirt)) {
				$values = explode(',', $oneItem->tshirt);

				$textValue = array();
				foreach ($values as $value){
					$db = JFactory::getDbo();
					$query = $db->getQuery(true);
					$query
							->select($db->quoteName('name'))
							->from('`#__contact_details`')
							->where($db->quoteName('id') . ' = '. $db->quote($db->escape($value)));
					$db->setQuery($query);
					$results = $db->loadObject();
					if ($results) {
						$textValue[] = $results->name;
					}
				}

			$oneItem->tshirt = !empty($textValue) ? implode(', ', $textValue) : $oneItem->tshirt;

			}

			if (isset($oneItem->blood_type)) {
				$values = explode(',', $oneItem->blood_type);

				$textValue = array();
				foreach ($values as $value){
					$db = JFactory::getDbo();
					$query = $db->getQuery(true);
					$query
							->select($db->quoteName('name'))
							->from('`#__contact_details`')
							->where($db->quoteName('id') . ' = '. $db->quote($db->escape($value)));
					$db->setQuery($query);
					$results = $db->loadObject();
					if ($results) {
						$textValue[] = $results->name;
					}
				}

			$oneItem->blood_type = !empty($textValue) ? implode(', ', $textValue) : $oneItem->blood_type;

			}
		}
		return $items;
	}
}
