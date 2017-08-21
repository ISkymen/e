<?php

function s_exposed_filter_views_data_alter(&$data) {
  $data['node']['year']['title'] = 'Year';
  $data['node']['year']['help'] = 'Year';
  $data['node']['year']['filter']['handler'] = 's_exposed_filter_handler_filter_year';
}
//
//function s_exposed_filter_views_data() {
//  return array(
//    'node' => array(
//      'year' => array(
//        'group' => t('Content'),
//        'title' => t('Author UID (select list)'),
//        'help' => t('Filter by author, choosing from dropdown list.'),
//        'filter' => array('handler' => 's_exposed_filter_handler_filter_year'),
//        'real field' => 'uid',
//      )
//    )
//  );
//}