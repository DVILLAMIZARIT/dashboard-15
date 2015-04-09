<?php

/**
 * Conversation model config
 */

return array(

	'title' => 'Threads',

	'single' => 'Threads',

	'model' => 'App\Thread',

	/**
	 * The display columns
	 */
	'columns' => array('Content','Pending',
						'NEXT' => array( 	'title' => 'Related Conversation', 
											'relationship' => "Conversation",
											'select'=>"(:table).Title" )
						),
	
	/**
	 * The filter set
	 */
	'filters' => array('Content','Pending'),

	/**
	 * The editable fields
	 */
	'edit_fields' => array('Content','Pending'),
	
	
	'action' => function(&$Conversation)
	{
		//
	}

);