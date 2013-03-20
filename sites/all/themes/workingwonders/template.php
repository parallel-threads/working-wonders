<?php
// $Id$

/**
 * @file
 * Contains theme override functions and preprocess functions for the theme.
 *
 * ABOUT THE TEMPLATE.PHP FILE
 *
 *   The template.php file is one of the most useful files when creating or
 *   modifying Drupal themes. You can add new regions for block content, modify
 *   or override Drupal's theme functions, intercept or make additional
 *   variables available to your theme, and create custom PHP logic. For more
 *   information, please visit the Theme Developer's Guide on Drupal.org:
 *   http://drupal.org/theme-guide
 *
 * OVERRIDING THEME FUNCTIONS
 *
 *   The Drupal theme system uses special theme functions to generate HTML
 *   output automatically. Often we wish to customize this HTML output. To do
 *   this, we have to override the theme function. You have to first find the
 *   theme function that generates the output, and then "catch" it and modify it
 *   here. The easiest way to do it is to copy the original function in its
 *   entirety and paste it here, changing the prefix from theme_ to workingwonders_.
 *   For example:
 *
 *     original: theme_breadcrumb()
 *     theme override: workingwonders_breadcrumb()
 *
 *   where workingwonders is the name of your sub-theme. For example, the
 *   zen_classic theme would define a zen_classic_breadcrumb() function.
 *
 *   If you would like to override any of the theme functions used in Zen core,
 *   you should first look at how Zen core implements those functions:
 *     theme_breadcrumbs()      in zen/template.php
 *     theme_menu_item_link()   in zen/template.php
 *     theme_menu_local_tasks() in zen/template.php
 *
 *   For more information, please visit the Theme Developer's Guide on
 *   Drupal.org: http://drupal.org/node/173880
 *
 * CREATE OR MODIFY VARIABLES FOR YOUR THEME
 *
 *   Each tpl.php template file has several variables which hold various pieces
 *   of content. You can modify those variables (or add new ones) before they
 *   are used in the template files by using preprocess functions.
 *
 *   This makes THEME_preprocess_HOOK() functions the most powerful functions
 *   available to themers.
 *
 *   It works by having one preprocess function for each template file or its
 *   derivatives (called template suggestions). For example:
 *     THEME_preprocess_page    alters the variables for page.tpl.php
 *     THEME_preprocess_node    alters the variables for node.tpl.php or
 *                              for node-forum.tpl.php
 *     THEME_preprocess_comment alters the variables for comment.tpl.php
 *     THEME_preprocess_block   alters the variables for block.tpl.php
 *
 *   For more information on preprocess functions and template suggestions,
 *   please visit the Theme Developer's Guide on Drupal.org:
 *   http://drupal.org/node/223440
 *   and http://drupal.org/node/190815#template-suggestions
 */


/**
 * Implementation of HOOK_theme().
 */
function workingwonders_theme(&$existing, $type, $theme, $path) {
  $hooks = zen_theme($existing, $type, $theme, $path);
  // Add your theme hooks like this:
  /*
  $hooks['hook_name_here'] = array( // Details go here );
  */
  // @TODO: Needs detailed comments. Patches welcome!
  return $hooks;
}

/**
 * Override or insert variables into all templates.
 *
 * @param $vars
 *   An array of variables to pass to the theme template.
 * @param $hook
 *   The name of the template being rendered (name of the .tpl.php file.)
 */
/* -- Delete this line if you want to use this function
function workingwonders_preprocess(&$vars, $hook) {
  $vars['sample_variable'] = t('Lorem ipsum.');
}
// */

/**
 * Override or insert variables into the page templates.
 *
 * @param $vars
 *   An array of variables to pass to the theme template.
 * @param $hook
 *   The name of the template being rendered ("page" in this case.)
 */
/* -- Delete this line if you want to use this function
function workingwonders_preprocess_page(&$vars, $hook) {
  $vars['sample_variable'] = t('Lorem ipsum.');
}
// */

/**
 * Override or insert variables into the node templates.
 *
 * @param $vars
 *   An array of variables to pass to the theme template.
 * @param $hook
 *   The name of the template being rendered ("node" in this case.)
 */
/* -- Delete this line if you want to use this function
function workingwonders_preprocess_node(&$vars, $hook) {
  $vars['sample_variable'] = t('Lorem ipsum.');

  // Optionally, run node-type-specific preprocess functions, like
  // workingwonders_preprocess_node_page() or workingwonders_preprocess_node_story().
  $function = __FUNCTION__ . '_' . $vars['node']->type;
  if (function_exists($function)) {
    $function($vars, $hook);
  }
}
// */

/**
 * Override or insert variables into the comment templates.
 *
 * @param $vars
 *   An array of variables to pass to the theme template.
 * @param $hook
 *   The name of the template being rendered ("comment" in this case.)
 */
/* -- Delete this line if you want to use this function
function workingwonders_preprocess_comment(&$vars, $hook) {
  $vars['sample_variable'] = t('Lorem ipsum.');
}
// */

/**
 * Override or insert variables into the block templates.
 *
 * @param $vars
 *   An array of variables to pass to the theme template.
 * @param $hook
 *   The name of the template being rendered ("block" in this case.)
 */
/* -- Delete this line if you want to use this function
function workingwonders_preprocess_block(&$vars, $hook) {
  $vars['sample_variable'] = t('Lorem ipsum.');
}
// */

function workingwonders_node_submitted($node) {
  return t('by !username on @date', array(
    '!username' => theme('username', $node),
    '@date' => format_date($node->created, 'custom', 'd M Y')
  ));
}

function workingwonders_breadcrumb($breadcrumb) {
        $show_breadcrumb = theme_get_setting('zen_breadcrumb');
        if ($show_breadcrumb !== 'yes') { return; }

	// Get URL arguments
	$arguments = explode('/', request_uri());
	//process product breadcrumbs
	if($arguments[1] == 'product' || $arguments[1] == 'products' || $arguments[1] == 'shop'){
		$links = array();
		$path = '';
		$parent[] = null;

		// Add 'Home' breadcrumb
		$links[] = l(t('Home'), '<front>');

		// Remove empty values
		foreach ($arguments as $key => $value) {
			if (empty($value)) {
				unset($arguments[$key]);
			}
		}
		$arguments = array_values($arguments);

		//get the referring url to determine which taxonomy term to use for breadcrumbs
		if($arguments[0] == 'product'){
			//can't get the term from a product url so ???
			if (arg(0) == 'node' && is_numeric(arg(1))) $nodeid = arg(1);
			//drupal_set_message('node id is '.$nodeid);
			$node = node_load($nodeid);
			//find out where they came from and serve up taxonomy breadcrumb based on lastpage
			$referer = $_SERVER['HTTP_REFERER']; //TODO
			$lastpage = str_replace('%20', ' ', (urldecode(end(explode('/', $referer)))));
			//drupal_set_message($lastpage);
			$term = $lastpage;
		} else {
			$term = urldecode (end($arguments));
		}

		//get parent item. restrict to "product types" vocabulary
		$result = db_query("SELECT tid FROM {term_data} WHERE vid = '5' AND name LIKE '%s'", $term);
		while ($record = db_fetch_object($result)) {
			// Perform operations on $record->title, etc. here.
			$parent = taxonomy_get_parents($record->tid, $key = 'tid');
		}

		$parent_term = end($parent)->name;
		// Add other breadcrumbs
		if (!empty($arguments)) {
			foreach ($arguments as $key => $value) {
				//drupal_set_message('COUNT is '.count($arguments).'KEY is '.$key.' => '.$value);
				// Don't make last breadcrumb a link
				if ($key == (count($arguments) - 1)) {
					//some views don't have a title get the link value from the view arg
					if(drupal_get_title()){
						if ($arguments[0] == 'products' || $arguments[0] == 'product' || substr(drupal_get_title(), 0, 7) == 'shop by') {
							$links[] = drupal_get_title();
						}else{
							$links[] = 'shop by '.drupal_get_title();
						}
					} else {
						$links[] = 'shop by ' . $value;
					}
				} else {
					//drupal_set_message('Middle crumbs');
					//build the middle breadcrumb link(s)
					if (!empty($path)) {
						//drupal_set_message('NOT empty path');
						$path .= '/'. $value;
					} else {
						//drupal_set_message('empty path');
						//For taxonomy terms build links for parent items
						if($value == 'shop'){
							//only one parent term
							$value = $parent_term;
							$path .= 'shop/'.$parent_term;
						} else if ($value == 'product' || $value == 'products'){
							//landed on a product
							//drupal_set_message('term is '.str_replace('-', ' ', urldecode($term)));
							$result = db_query("SELECT tid FROM {term_data} WHERE vid = '5' AND name LIKE '%s'", str_replace('-', ' ', urldecode($term)));
								
							while ($record = db_fetch_object($result)) {
								// Perform operations on $record->title, etc. here.
								$parent = taxonomy_get_parents($record->tid, $key = 'tid');
								//drupal_set_message('With '.$record->tid.' GOT parent '.end($parent)->name);
								$subresult = db_query("SELECT tid FROM {term_data} WHERE vid = '5' AND name LIKE '%s'", str_replace('-', ' ', urldecode(end($parent)->name)));
								while ($subrecord = db_fetch_object($subresult)) {
									$subparent = taxonomy_get_parents($subrecord->tid, $key = 'tid');
									//drupal_set_message('With '.$subrecord->tid.' GOT parent '.end($subparent)->name);
								}
								if(end($subparent)->name){
									$links[] = l(t(end($subparent)->name), 'shop/'.end($subparent)->name);
								}

							}
							//prepend "shop by " to product taxonomies
							if ((is_array($parent) && substr(end($parent)->name, 0, 7) == 'shop by') || is_array($subparent) && end($subparent)->name) {
								$value = end($parent)->name;
							}else{
								$value = 'Shop by '.end($parent)->name;
							}
							$path .= 'shop/'.end($parent)->name;
							if(!end($parent)->name){
								$links[] = l(drupal_ucfirst('shop by category'), 'shop/shop by category');								}
						} else {
							$path .= $value;
						}
					}
					//set middle breadcrumb links
					//drupal_set_message('set link to '.$value.' => ' .$path);
					if(end($parent)->name){
						$links[] = l(drupal_ucfirst($value), $path);
					}
					if($lastpage){
						$links[] = l(t($lastpage), 'shop/'.$lastpage);
					}
				}
			}
		}
		drupal_set_breadcrumb($links);
	}
	// Get custom breadcrumbs
	$breadcrumb = drupal_get_breadcrumb();

	// Hide breadcrumbs if only 'Home' exists
	//if (count($breadcrumb) > 1) {
		return '<div class="breadcrumb">'. implode(' &raquo; ', $breadcrumb) .'</div>';
	//}

  // Added a comment.
}

function workingwonders_views_mini_pager__uc_products_new ($tags = array(), $limit = 10, $element = 0, $parameters = array(), $quantity = 9) {
  global $pager_page_array, $pager_total;

  // Calculate various markers within this pager piece:
  // Middle is used to "center" pages around the current page.
  $pager_middle = ceil($quantity / 2);
  // current is the page we are currently paged to
  $pager_current = $pager_page_array[$element] + 1;
  // first is the first page listed by this pager piece (re quantity)
  $pager_first = $pager_current - $pager_middle + 1;
  // last is the last page listed by this pager piece (re quantity)
  $pager_last = $pager_current + $quantity - $pager_middle;
  // max is the maximum page number
  $pager_max = $pager_total[$element];
  // End of marker calculations.

  // Prepare for generation loop.
  $i = $pager_first;
  if ($pager_last > $pager_max) {
    // Adjust "center" if at end of query.
    $i = $i + ($pager_max - $pager_last);
    $pager_last = $pager_max;
  }
  if ($i <= 0) {
    // Adjust "center" if at start of query.
    $pager_last = $pager_last + (1 - $i);
    $i = 1;
  }
  // End of generation loop preparation.

  $li_first = theme('pager_first', (isset($tags[0]) ? $tags[0] : t('« first')), $limit, $element, $parameters);
  $li_previous = theme('pager_previous', (isset($tags[1]) ? $tags[1] : t('‹ previous')), $limit, $element, 1, $parameters);
  $li_next = theme('pager_next', (isset($tags[3]) ? $tags[3] : t('next ›')), $limit, $element, 1, $parameters);
  $li_last = theme('pager_last', (isset($tags[4]) ? $tags[4] : t('last »')), $limit, $element, $parameters);

  if ($pager_total[$element] > 1) {
    if ($li_first) {
      $items[] = array(
        'class' => 'pager-first',
        'data' => $li_first,
      );
    }
    if ($li_previous) {
      $items[] = array(
        'class' => 'pager-previous',
        'data' => $li_previous,
      );
    }
    $items[] = array (
      'class' => 'pager-all',
      'data'  => l ('All', 'products_all/' . arg (1))
    );

    // When there is more than one page, create the pager list.
    if ($i != $pager_max) {
      if ($i > 1) {
        $items[] = array(
          'class' => 'pager-ellipsis',
          'data' => '…',
        );
      }
      // Now generate the actual pager piece.
      for (; $i <= $pager_last && $i <= $pager_max; $i++) {
        if ($i < $pager_current) {
          $items[] = array(
            'class' => 'pager-item',
            'data' => theme('pager_previous', $i, $limit, $element, ($pager_current - $i), $parameters),
          );
        }
        if ($i == $pager_current) {
          $items[] = array(
            'class' => 'pager-current',
            'data' => $i,
          );
        }
        if ($i > $pager_current) {
          $items[] = array(
            'class' => 'pager-item',
            'data' => theme('pager_next', $i, $limit, $element, ($i - $pager_current), $parameters),
          );
        }
      }
      if ($i < $pager_max) {
        $items[] = array(
          'class' => 'pager-ellipsis',
          'data' => '…',
        );
      }
    }
    // End generation.
    if ($li_next) {
      $items[] = array(
        'class' => 'pager-next',
        'data' => $li_next,
      );
    }
    if ($li_last) {
      $items[] = array(
        'class' => 'pager-last',
        'data' => $li_last,
      );
    }
    return theme('item_list', $items, NULL, 'ul', array('class' => 'pager'));
  }
}
