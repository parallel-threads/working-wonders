<?php
// $Id$

/**
 * @file
 * views_handler_argument_search
 */

/*************************************************************************
* Views hooks                                                            *
*************************************************************************/

/**
 * Implementation of hook_views_handlers()
 */
function views_handler_argument_search_views_handlers() {
  return array(
    'info' => array(
      'path' => drupal_get_path('module', 'views_handler_argument_search').'/handlers',
    ),
    'handlers' => array(
      'views_handler_argument_search' => array(
        'parent' => 'views_handler_argument',
      ),
    ),
  );
}

/**
 * Implementation of hook_views_data()
 */
function views_handler_argument_search_views_data() {

  // search filter
  $data['search_index']['keys']['argument'] = array(
    'handler' => 'views_handler_argument_search',
  );

  return $data;
}