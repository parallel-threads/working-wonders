<?php
  $link_oldsite = mysql_connect('localhost', 'drupal6', 'drupal6123');
  mysql_select_db('oldsite', $link_oldsite);

  $query = "SELECT * FROM tblColors ORDER BY colorName";
  $result = mysql_query($query,$link_oldsite);

  while ($row = mysql_fetch_array($result)) {

    $query = "INSERT INTO uc_attribute_options (aid, name) VALUES (1, '" . addslashes($row['colorName']) . "');";
    print $query . "<br />";

  }

?>
