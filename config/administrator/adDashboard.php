<?php

/**
 * Conversation model config
 */

return array(

	'title' => 'Dashboard',

	'single' => 'Topic',

	'model' => 'App\Conversation',

	/**
	 * The display columns
	 */
	'columns' => array('id','Title','Pending'),

	/**
	 * The filter set
	 */
	'filters' => array('id','Title','Pending'),

	/**
	 * The editable fields
	 */
	'edit_fields' => array('Title','Pending'),

);