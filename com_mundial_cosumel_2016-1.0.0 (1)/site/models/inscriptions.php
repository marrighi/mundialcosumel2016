<?php

/**
 * @version    CVS: 1.0.0
 * @package    Com_Mundial_cosumel_2016
 * @author     Arrighi <marrighi@gmail.com>
 * @copyright  Copyright (C) 2016. Todos los derechos reservados.
 * @license    Licencia Pública General GNU versión 2 o posterior. Consulte LICENSE.txt
 */
defined('_JEXEC') or die;

jimport('joomla.application.component.modellist');

/**
 * Methods supporting a list of Mundial_cosumel_2016 records.
 *
 * @since  1.6
 */
class Mundial_cosumel_2016ModelInscriptions extends JModelList
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
				'id', 'a.id',
				'ordering', 'a.ordering',
				'state', 'a.state',
				'created_by', 'a.created_by',
				'last_name', 'a.last_name',
				'name', 'a.name',
				'gender', 'a.gender',
				'birthdate', 'a.birthdate',
				'event', 'a.event',
				'email', 'a.email',
				'phone', 'a.phone',
				'tshirt', 'a.tshirt',
				'emergency_contact', 'a.emergency_contact',
				'emergency_phone', 'a.emergency_phone',
				'allergies', 'a.allergies',
				'blood_type', 'a.blood_type',
				'hotel', 'a.hotel',
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
	 *
	 * @since    1.6
	 */
	protected function populateState($ordering = null, $direction = null)
	{
		// Initialise variables.
		$app = JFactory::getApplication();

		// List state information
		$limit = $app->getUserStateFromRequest('global.list.limit', 'limit', $app->get('list_limit'));
		$this->setState('list.limit', $limit);

		$limitstart = $app->getUserStateFromRequest('limitstart', 'limitstart', 0);
		$this->setState('list.start', $limitstart);

		if ($list = $app->getUserStateFromRequest($this->context . '.list', 'list', array(), 'array'))
		{
			foreach ($list as $name => $value)
			{
				// Extra validations
				switch ($name)
				{
					case 'fullordering':
						$orderingParts = explode(' ', $value);

						if (count($orderingParts) >= 2)
						{
							// Latest part will be considered the direction
							$fullDirection = end($orderingParts);

							if (in_array(strtoupper($fullDirection), array('ASC', 'DESC', '')))
							{
								$this->setState('list.direction', $fullDirection);
							}

							unset($orderingParts[count($orderingParts) - 1]);

							// The rest will be the ordering
							$fullOrdering = implode(' ', $orderingParts);

							if (in_array($fullOrdering, $this->filter_fields))
							{
								$this->setState('list.ordering', $fullOrdering);
							}
						}
						else
						{
							$this->setState('list.ordering', $ordering);
							$this->setState('list.direction', $direction);
						}
						break;

					case 'ordering':
						if (!in_array($value, $this->filter_fields))
						{
							$value = $ordering;
						}
						break;

					case 'direction':
						if (!in_array(strtoupper($value), array('ASC', 'DESC', '')))
						{
							$value = $direction;
						}
						break;

					case 'limit':
						$limit = $value;
						break;

					// Just to keep the default case
					default:
						$value = $value;
						break;
				}

				$this->setState('list.' . $name, $value);
			}
		}

		// Receive & set filters
		if ($filters = $app->getUserStateFromRequest($this->context . '.filter', 'filter', array(), 'array'))
		{
			foreach ($filters as $name => $value)
			{
				$this->setState('filter.' . $name, $value);
			}
		}

		$ordering = $app->input->get('filter_order');

		if (!empty($ordering))
		{
			$list             = $app->getUserState($this->context . '.list');
			$list['ordering'] = $app->input->get('filter_order');
			$app->setUserState($this->context . '.list', $list);
		}

		$orderingDirection = $app->input->get('filter_order_Dir');

		if (!empty($orderingDirection))
		{
			$list              = $app->getUserState($this->context . '.list');
			$list['direction'] = $app->input->get('filter_order_Dir');
			$app->setUserState($this->context . '.list', $list);
		}

		$list = $app->getUserState($this->context . '.list');

		if (empty($list['ordering']))
{
	$list['ordering'] = 'ordering';
}

if (empty($list['direction']))
{
	$list['direction'] = 'asc';
}

		if (isset($list['ordering']))
		{
			$this->setState('list.ordering', $list['ordering']);
		}

		if (isset($list['direction']))
		{
			$this->setState('list.direction', $list['direction']);
		}
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
		$user =& JFactory::getUser();
		$userId = $user->get( 'id' );
		// Create a new query object.
		$db    = $this->getDbo();
		$query = $db->getQuery(true);

		// Select the required fields from the table.
		$query
			->select(
				$this->getState(
					'list.select', 'DISTINCT a.*'
				)
			);

		$query->from('`#__mc2016_inscripcion` AS a');
		
		// Join over the users for the checked out user.
		$query->select('uc.name AS editor');
		$query->join('LEFT', '#__users AS uc ON uc.id=a.checked_out');

		// Join over the created by field 'created_by'
		$query->join('LEFT', '#__users AS created_by ON created_by.id = a.created_by');
		// Join over the foreign key 'gender'
		$query->select('#__mc2016_gender.name AS gender');
		$query->join('LEFT', '#__mc2016_gender ON #__mc2016_gender.id = a.gender');
		// Join over the foreign key 'event'
		$query->select('#__mc2016_event.name AS event');
		$query->join('LEFT', '#__mc2016_event  ON #__mc2016_event.id = a.event');
		// Join over the foreign key 'tshirt'
		$query->select('#__mc2016_tshirt.name AS tshirt');
		$query->join('LEFT', '#__mc2016_tshirt  ON #__mc2016_tshirt.id = a.tshirt');
		// Join over the foreign key 'blood_type'
		$query->select('#__mc2016_blood_type.name AS blood_type');
		$query->join('LEFT', '#__mc2016_blood_type ON #__mc2016_blood_type.id = a.blood_type');
			$query->where('a.created_by = ' . $userId);
		if (!JFactory::getUser()->authorise('core.edit', 'com_mundial_cosumel_2016'))
		{
			$query->where('a.state = 1');
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
$query->where('( a.last_name LIKE '.$search.'  OR  a.name LIKE '.$search.'  OR  a.hotel LIKE '.$search.' )');
			}
		}
		

		// Filtering tshirt
		$filter_tshirt = $this->state->get("filter.tshirt");
		if ($filter_tshirt != '') {
			$query->where("a.tshirt = '".$db->escape($filter_tshirt)."'");
		}

		// Filtering blood_type
		$filter_blood_type = $this->state->get("filter.blood_type");
		if ($filter_blood_type != '') {
			$query->where("a.blood_type = '".$db->escape($filter_blood_type)."'");
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
	 * Method to get an array of data items
	 *
	 * @return  mixed An array of data on success, false on failure.
	 */
	public function getItems()
	{
		$items = parent::getItems();
		
		foreach ($items as $item)
		{
			if (isset($item->gender) && $item->gender != '')
			{
				if (is_object($item->gender))
				{
					$item->gender = ArrayHelper::fromObject($item->gender);
				}

				$values = (is_array($item->gender)) ? $item->gender : explode(',', $item->gender);
				$textValue = array();

				foreach ($values as $value)
				{
					$db = JFactory::getDbo();
					$query = $db->getQuery(true);
					$query
							->select($db->quoteName('name'))
							->from('`#__mc2016_gender`')
							->where($db->quoteName('id') . ' = ' . $db->quote($db->escape($value)));
					$db->setQuery($query);
					$results = $db->loadObject();

					if ($results)
					{
						$textValue[] = $results->name;
					}
				}

				$item->gender = !empty($textValue) ? implode(', ', $textValue) : $item->gender;
			}			if (isset($item->event) && $item->event != '')
			{
				if (is_object($item->event))
				{
					$item->event = ArrayHelper::fromObject($item->event);
				}

				$values = (is_array($item->event)) ? $item->event : explode(',', $item->event);
				$textValue = array();

				foreach ($values as $value)
				{
					$db = JFactory::getDbo();
					$query = $db->getQuery(true);
					$query
							->select($db->quoteName('name'))
							->from('`#__mc2016_event`')
							->where($db->quoteName('id') . ' = ' . $db->quote($db->escape($value)));
					$db->setQuery($query);
					$results = $db->loadObject();

					if ($results)
					{
						$textValue[] = $results->name;
					}
				}

				$item->event = !empty($textValue) ? implode(', ', $textValue) : $item->event;
			}			if (isset($item->tshirt) && $item->tshirt != '')
			{
				if (is_object($item->tshirt))
				{
					$item->tshirt = ArrayHelper::fromObject($item->tshirt);
				}

				$values = (is_array($item->tshirt)) ? $item->tshirt : explode(',', $item->tshirt);
				$textValue = array();

				foreach ($values as $value)
				{
					$db = JFactory::getDbo();
					$query = $db->getQuery(true);
					$query
							->select($db->quoteName('name'))
							->from('`#__mc2016_tshirt`')
							->where($db->quoteName('id') . ' = ' . $db->quote($db->escape($value)));
					$db->setQuery($query);
					$results = $db->loadObject();

					if ($results)
					{
						$textValue[] = $results->name;
					}
				}

				$item->tshirt = !empty($textValue) ? implode(', ', $textValue) : $item->tshirt;
			}			if (isset($item->blood_type) && $item->blood_type != '')
			{
				if (is_object($item->blood_type))
				{
					$item->blood_type = ArrayHelper::fromObject($item->blood_type);
				}

				$values = (is_array($item->blood_type)) ? $item->blood_type : explode(',', $item->blood_type);
				$textValue = array();

				foreach ($values as $value)
				{
					$db = JFactory::getDbo();
					$query = $db->getQuery(true);
					$query
							->select($db->quoteName('name'))
							->from('`#__mc2016_blood_type`')
							->where($db->quoteName('id') . ' = ' . $db->quote($db->escape($value)));
					$db->setQuery($query);
					$results = $db->loadObject();

					if ($results)
					{
						$textValue[] = $results->name;
					}
				}

				$item->blood_type = !empty($textValue) ? implode(', ', $textValue) : $item->blood_type;
			}
		}

		return $items;
	}

	/**
	 * Overrides the default function to check Date fields format, identified by
	 * "_dateformat" suffix, and erases the field if it's not correct.
	 *
	 * @return void
	 */
	protected function loadFormData()
	{
		$app              = JFactory::getApplication();
		$filters          = $app->getUserState($this->context . '.filter', array());
		$error_dateformat = false;

		foreach ($filters as $key => $value)
		{
			if (strpos($key, '_dateformat') && !empty($value) && $this->isValidDate($value) == null)
			{
				$filters[$key]    = '';
				$error_dateformat = true;
			}
		}

		if ($error_dateformat)
		{
			$app->enqueueMessage(JText::_("COM_MUNDIAL_COSUMEL_2016_SEARCH_FILTER_DATE_FORMAT"), "warning");
			$app->setUserState($this->context . '.filter', $filters);
		}

		return parent::loadFormData();
	}

	/**
	 * Checks if a given date is valid and in a specified format (YYYY-MM-DD)
	 *
	 * @param   string  $date  Date to be checked
	 *
	 * @return bool
	 */
	private function isValidDate($date)
	{
		$date = str_replace('/', '-', $date);
		return (date_create($date)) ? JFactory::getDate($date)->format("Y-m-d") : null;
	}
}
