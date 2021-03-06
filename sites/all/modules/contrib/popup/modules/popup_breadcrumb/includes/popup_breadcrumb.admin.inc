<?php



/* ----- Forms ---- */



function popup_breadcrumb_settings($form_state){

  drupal_add_css(drupal_get_path('module', 'popup_ui').'/popup-ui.css');
  module_load_include('inc', 'popup_ui', 'includes/popup_ui.api');
  module_load_include('inc', 'popup_ui', 'includes/popup_ui.admin');

  $form = array(
    '#tree' => TRUE,
  );
  $settings = _popup_breadcrumb_settings();
  
  $views = views_get_all_views();
  $views = array_keys(array_filter($views, '_popup_breadcrumb_view_enabled'));
  $view_options = array_combine($views, $views);

  $arguments = range(1, substr_count($settings['argument-template'], '%'));
  $argument_options = array_combine($arguments, $arguments);

  $format_options = array_keys(_popup_ui_formatter_settings());
  array_unshift($format_options, 'Default');
  $display_format_options = array_combine($format_options, $format_options);

  $form['popup-breadcrumb-argument-template'] = array(
    '#default_value' => $settings['argument-template'],
    '#description' => 'Arguments my be represented with % eg. my/path/<strong>%</strong>/string/<strong>%</strong> or node/<strong>%</strong>',
    '#title' => 'Argument path template',
    '#type' => 'textfield',
    '#weight' => -3,
  );

  $form['popup-breadcrumb-argument-alias'] = array(
    '#default_value' => $settings['argument-alias'],
    '#title' => 'Get arguments from the path alias',
    '#type' => 'checkbox',
    '#weight' => -3,
  );

  $form['popup-breadcrumb-append-title'] = array(
    '#default_value' => $settings['append-title'],
    '#title' => 'Append the breadcrumb with the page title',
    '#type' => 'checkbox',
    '#weight' => -3,
  );

  $form['popup-breadcrumb-home-link'] = array(
    '#default_value' => $settings['home-link'],
    '#title' => 'Prefix the breadcrumb with a link to the homepage',
    '#type' => 'checkbox',
    '#weight' => -3,
  );
  
  $form['popup-breadcrumb-format'] = array(
    '#default_value' => $settings['format'],
    '#title' => 'Display format',
    '#type' => 'select',
    '#options' => $display_format_options,
    '#description' => t('Select the format in which to display popups. You may manage popup formats !here.', array('!here' => l('here', 'admin/settings/popup/formats'))),
    '#weight' => -2,
  );

  $form['rows'] = array();

  if (count($settings['views'])){
    foreach($settings['views'] as $name => $view_data){

      $view = views_get_view($view_data['view']);
      $display_keys = $view ? array_keys($view->display) : array('default');
      $display_options = array_combine($display_keys, $display_keys);

      $form['rows'][$name] = _popup_breadcrumb_row(
        $name,
        $view_data,
        array(
          'views' => $view_options,
          'displays' => $display_options,
          'arguments' => $argument_options,
        )
      );
      
      $weight = $view_data['weight'] + 1;
    }
  }

  $form['rows']['new'] = _popup_breadcrumb_row(
    'new',
    array('weight' => $weight),
    array(
      'views' => $view_options,
      'displays' => array(),
      'arguments' => $argument_options,
    )
  );

  $form['buttons']= array(

    array('#value' => '<div class="form-item form-buttons">'),

    'submit' => array(
      '#type'=>'submit',
      '#value'=>t('Save'),
    ),

    array(
    	'#value' => popup_ui_confirm(
				'Reset to defaults', 
				'Are you sure you want to reset to defaults?<br /> This action cannot be undone!', 
				'admin/settings/popup/breadcrumb/reset',
				array(
					'origin' => 'top-left',
					'expand' => 'top-right',
				)
			)
		),

    array('#value' => '</div>'),

    '#weight' => 2,
  );

  return $form;
}



function _popup_breadcrumb_row($key, $values, $options){

  $row = array(

    'name' => array(
      '#default_value' => $values['name'],
      '#type' => 'textfield',
      '#size' => 20,
    ),

    'view' => array(
      '#default_value' => $values['view'],
      '#options' => $options['views'],
      '#type' => 'select',
    ),

    'display' => array(),

    'arguments' => array(
      '#options' => $options['arguments'],
      '#type' => 'checkboxes',
    ),

    'title_type' => array(
      '#default_value' => $values['title_type'],
      '#options' => array(0 => 'View title', 'node' => 'Node title', 'user' => 'User title', 'term' => 'Term title',),
      '#type' => 'select',
    ),

    'title_link_argument' => array(
      '#default_value' => $values['title_link_argument'],
      '#options' => $options['arguments'],
      '#type' => 'select',
    ),

    'weight' => array(
      '#attributes' => array('class'=>'row-weight'),
      '#default_value' => $values['weight'],
      '#size' => 5,
      '#type' => 'textfield',
    ),

    array(
      '#value' => (
        $key == 'new' 
          ? '&nbsp;'
          : popup_ui_confirm(
							'Delete', 
							'Are you sure you want to delete this breadcrumb level? It cannot be undone!',
							'admin/settings/popup/breadcrumb/delete/'.$key,
							array(
								'origin' => 'bottom-right',
								'expand' => 'bottom-left',
							)
						)
      ), 
    ),

  );

  if ($options['displays']){
    $row['display'] = array(
      '#default_value' => $values['display'],
      '#options' => $options['displays'],
      '#type' => 'select',
    );
  } else {
    $row['display'] = array(
      '#value' => 'Default',
      '#type' => 'value',
    );
  }

  if ($values['arguments']){
    $row['arguments']['#default_value'] = array_filter($values['arguments']);
  }

  return $row;
}



function popup_breadcrumb_settings_submit(&$form, &$form_state){

  $settings = array(
    'argument-template' => $form_state['values']['popup-breadcrumb-argument-template'],
    'argument-alias' => $form_state['values']['popup-breadcrumb-argument-alias'],
    'home-link' => $form_state['values']['popup-breadcrumb-home-link'],
    'append-title' => $form_state['values']['popup-breadcrumb-append-title'],
    'format' => $form_state['values']['popup-breadcrumb-format'],
  );

  foreach($form_state['values']['rows'] as $name=>$row){
    if ($row['name']){
      $settings['views'][$row['name']] = $row;
    }
  }

  if (is_array($settings['views'])){
    uasort($settings['views'], '_popup_breadcrumb_compare');
  }

  _popup_breadcrumb_settings($settings);

  drupal_set_message('The settings have been saved.');
}



/* ----- Settings ---- */



function _popup_breadcrumb_default_settings(){

  return array (
    'argument-template' => 'node/%',
    'argument-alias' => 0,
    'home-link' => 1,
    'append-title' => '1',
    'format' => 'Default',
    'views' => array (
      'Nodes' => array (
        'name' => 'Nodes',
        'view' => 'popup_breadcrumb_nodes',
        'display' => 'default',
        'arguments' => array (
          1 => 1,
        ),
        'title_type' => 'node',
        'title_link_argument' => '1',
        'weight' => '',
      ),
    ),
  );

}



function _popup_breadcrumb_settings($new_settings = FALSE){

  static $settings = FALSE;
  if ($new_settings){
    $settings = $new_settings;
    variable_set('popup-breadcrumb-settings', $settings);
  }

  if (!$settings){
    $settings = variable_get('popup-breadcrumb-settings', _popup_breadcrumb_default_settings());
  }

  return $settings;
}



/* ---- Actions ---- */



function _popup_breadcrumb_delete($name){

  $settings = _popup_breadcrumb_settings();

  unset($settings['views'][$name]);

  _popup_breadcrumb_settings($settings);

  drupal_set_message('Breadcrumb level deleted.');

  drupal_goto('admin/settings/popup/breadcrumb');
}



function _popup_breadcrumb_reset(){

  _popup_breadcrumb_settings(_popup_breadcrumb_default_settings());

  drupal_set_message('Default settings restored.');

  drupal_goto('admin/settings/popup/breadcrumb');
}



/* ---- Utilities ----- */



function _popup_breadcrumb_title_attributes($title_type, $link_argument){

  $space_link_argument = str_replace('-', ' ', $link_argument);
  $underscore_link_argument = str_replace('-', '_', $link_argument);
  $attributes = array();
  
  switch ($title_type){

    case 'node':
      $result = db_fetch_array(
        db_query(
          'SELECT title, nid FROM {node} WHERE title="%s" OR title="%s" OR title LIKE "%s" OR nid=%d', 
          $link_argument,
          $space_link_argument,
          $underscore_link_argument,
          $link_argument
        )
      );
      $attributes['title'] = $result['title'];
      $attributes['link'] = drupal_get_path_alias('node/'.$result['nid']);
    break;

    case 'user':
      $result = db_fetch_array(
        db_query(
          'SELECT name, uid FROM {users} WHERE name="%s" OR name="%s" OR name LIKE "%s" OR uid=%d', 
          $link_argument,
          $space_link_argument,
          $underscore_link_argument,
          $link_argument
        )
      );
      $attributes['title'] = $result['name'];
      $attributes['link'] = drupal_get_path_alias('user/'.$result['nid']);
    break;

    case 'term':
      $result = db_fetch_array(
        db_query(
          'SELECT name, tid FROM {term_data} WHERE name="%s" OR name="%s" OR name LIKE "%s" OR tid=%d', 
          $link_argument,
          $space_link_argument,
          $underscore_link_argument,
          $link_argument
        )
      );
      $attributes['title'] = $result['name'];
      $attributes['link'] = drupal_get_path_alias('taxonomy/term/'.$result['tid']);
    break;

  }

  return $attributes;
}



function _popup_breadcrumb_arguments($settings){

  $argument_template = $settings['argument-template'];

  $path = $settings['argument-alias']
    ? drupal_get_path_alias($_GET['q'])
    : $_GET['q'];

  $parts = explode('%', $argument_template);
  $regex_fragment = '';
  $regexes = array();

  foreach($parts as $part){
    $regex_fragment .= $part.'([0-9a-zA-Z\-\_\.]*)';
    $regexes[] = $regex_fragment;
  }

  $regexes = array_reverse($regexes);
  $regex = '/(?:'.
    preg_replace(
      array('/\//',),
      array('\\/',),
      implode(')|(?:', $regexes)
    ).
    ')/';

  preg_match($regex, $path ,$arguments);
  $arguments = array_values(array_filter($arguments));
	array_shift($arguments);

  return $arguments;
}



function _popup_breadcrumb_view_enabled($view){
  return !$view->disabled;
}



function _popup_breadcrumb_compare($a, $b){
  
  $a_int = intval($a['weight']);
  $b_int = intval($b['weight']);

  if ($a_int == $b_int) {
      return 0;
  }

  return ($a_int < $b_int) ? -1 : 1;
}


