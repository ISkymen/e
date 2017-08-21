<?php

class s_exposed_filter_handler_filter_year extends views_handler_filter_in_operator {

  /**
   * Override parent get_value_options() function.
   *
   * @return
   *   Return the stored values in $this->value_options if someone expects it.
   */
//  function get_value_options() {
//
//    $query = db_select('node', 'n')
//      ->condition('status', 1)
//      ->condition('type', 'news')
//      ->orderBy('created', 'DESC');
//    $query->addExpression('YEAR(FROM_UNIXTIME(created))', 'created');
//    $query->groupBy('YEAR(FROM_UNIXTIME(created))');
//    $query->addExpression('COUNT(*)', 'count');
//    $results = $query->execute();
//    $years = $results->fetchAll();
//
//    $options = array();
//    foreach ($years as $year) {
//      $options[$year->created] = $year->created . " (" . $year->count . ")";
//    }
//
//    $this->value_options = $options;
//    return $options;
//  }

  /**
   * Options form subform for setting exposed filter options.
   */
  function value_form(&$form, &$form_state) {
//    parent::value_form($form, $form_state);

    $query = db_select('node', 'n')
      ->condition('status', 1)
      ->condition('type', 'news')
      ->orderBy('created', 'DESC');
    $query->addExpression('YEAR(FROM_UNIXTIME(created))', 'created');
    $query->groupBy('YEAR(FROM_UNIXTIME(created))');
    $query->addExpression('COUNT(*)', 'count');
    $results = $query->execute();
    $years = $results->fetchAll();
    $options = array();
    foreach ($years as $year) {
      $options[$year->created] = $year->created . " (" . $year->count . ")";
    }

    $form['value']['year'] = array(
      '#type' => 'radios',
      '#options' => $options,
//    '#default_value' => end($options),
      '#validated' => TRUE
    );
  }


  /**
   * Alters Views query when filter is used.
   */
  function query() {

    $this->ensure_my_table();

//    $value = $this->view->exposed_data[$real_field_name];

    if (isset($this->value[0])) {
      $value = $this->value[0];
    }
    else {
      $value = 'all';
    }

    if (is_numeric($value) && $value != 0) {
      $this->query->add_where_expression($this->options['group'],
        "FROM_UNIXTIME(node.created, '%Y') = :filtername_value",
        array(':filtername_value' => $value));
    }
  }
}