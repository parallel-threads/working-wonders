<?php
  $link_oldsite = mysql_connect('localhost', 'drupal6', 'drupal6123');
  mysql_select_db('oldsite', $link_oldsite);

  $query = "SELECT DISTINCT scName FROM tblSizeColor WHERE scName != '' AND itemIdFK != 0 ORDER BY scName";
  $result = mysql_query($query,$link_oldsite);

  while ($row = mysql_fetch_array($result)) {

    //print $row['scName'] . "<br />";

    $query = "INSERT INTO uc_attribute_options (aid, name) VALUES (2, '" . str_replace("'", "\'", $row['scName']) . "');";
    print $query . "<br />";

  }

?>
