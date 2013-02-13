<?php
  $link_oldsite = mysql_connect('localhost', 'drupal6', 'drupal6123');
  $link_drupal6 = mysql_connect('localhost', 'root', '**VEDB0000!');
  $db_oldsite = mysql_select_db('oldsite', $link_oldsite);
  $db_drupal6 = mysql_select_db('drupal6', $link_drupal6);

  $query = "SELECT itemIdFK, colorIdList FROM tblSizeColor WHERE itemIdFK != 0 AND colorIdList is not NULL ORDER BY itemIdFK";
  $result = mysql_query($query,$link_oldsite) or die(mysql_error());

  while ($row = mysql_fetch_array($result)) {

    print $row['itemIdFK'] . "<br />";
    print $row['colorIdList'] . "<br />";

    $nidquery = "SELECT nid FROM content_type_product WHERE field_old_id_value = '" . $row['itemIdFK'] . "'";
    $nidresult = mysql_query($nidquery, $link_drupal6) or die(mysql_error());
    while( $nidrow = mysql_fetch_array($nidresult, $link_drupal6) ) {
      print "NID: " . $nidrow['nid'] . "<br />";
    }
    $colors = explode(",",$row['colorIdList']);
    foreach ($colors as $color) {
      $colorquery = "SELECT colorName FROM tblColors WHERE colorId = " . $color;
      $colorresult = mysql_query($colorquery, $link_oldsite) or die(mysql_error($link_oldsite));
      while( $colorrow = mysql_fetch_array($colorresult) ) {
        $colorattquery = "SELECT oid FROM uc_attribute_options WHERE name = '" . addslashes($colorrow['colorName']) . "'";
        $colorattresult = mysql_query($colorattquery, $link_drupal6);
        print "-<br />";
        while ($colorattrow = mysql_fetch_array($colorattresult)) {
          print $colorrow['colorName'] . "<br />";
          print $colorattrow['oid'] . "<br />";
        }
      }
    } 
    print "--------<br />";
   
  }

?>
