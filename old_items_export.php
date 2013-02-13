<?php
  $link = mysql_connect('localhost', 'drupal6', 'drupal6123');
  $db_selected = mysql_select_db('oldsite', $link);

  print "ItemID,CatalogID,ManufactuerID,Name,Description,Note,Dimensions,Price,Cost,Shipping,Site,Custom,CustomContact,Taxable,FreeShipping,GreenGuide1,GreenGuide2,GreenGuide3,GreenGuide4,GreenGuide5,GreenGuide6,GreenGuide7,GreenGuide8,Image1,Image2,Image3,Image4,Image5,Image6,Image7,Image8,Image9,Category1,Category2,Category3,Category4,Category5,Category6,Category7,Category8,Brand,Document1,Document2,Document3,Document4,Document5,Document6,Document7,Document8,Relation1,Relation2,Relation3,Relation4,Relation5,Relation6,Relation7,Relation8\r\n";


  $query = "SELECT * FROM tblItems ORDER BY itemID";
  $result = mysql_query($query);
  while ($row = mysql_fetch_array($result)) {
    if ($row['itemId'] != 0) {

      $greenguides = array();
      if ($row['itemGreenies']) {
        $greenguidesquery = "SELECT greenyName FROM tblGreenies WHERE greenyId IN (" . $row['itemGreenies'] . ")";
        $greenguidesresult = mysql_query($greenguidesquery);
        while ($greenguidesrow = mysql_fetch_array($greenguidesresult)) {
          if (strstr($greenguidesrow['greenyName'], 'Manufacturing Location')) {
            if (!in_array('Manufacturing Location', $greenguides)) {
              $greenguides[] = 'Manufacturing Location';
            }
          } else {
            $greenguides[] = $greenguidesrow['greenyName'];
          }
        }
      }

      $images = array();
      $imagesquery = "SELECT imageFile FROM tblImages WHERE itemIdFK = " . $row['itemId'] . " ORDER BY imagePriItem DESC";
      $imagesresult = mysql_query($imagesquery);
      while ($imagesrow = mysql_fetch_array($imagesresult)) {
        $images[] = $imagesrow['imageFile'];
      }

      $categories = array();
      $categoriesquery = "SELECT subName FROM tblSubCategories WHERE tblSubCategories.subId IN (" . $row['subIdFKList'] . ")";
      $categoriesresult = mysql_query($categoriesquery);
      while ($categoriesrow = mysql_fetch_array($categoriesresult)) {
        $categories[] = $categoriesrow['subName'];
      }

      $brandname = "";
      $brandquery = "SELECT brandName FROM tblBrands WHERE tblBrands.brandId = " . $row['brandIdFK'];
      $brandresult = mysql_query($brandquery);
      $brandrow = mysql_fetch_array($brandresult);
      $brandname = $brandrow['brandName'];

      $documents = array();
      $documentsquery = "SELECT documentFile FROM tblDocuments WHERE itemIdFKList LIKE '" . $row['itemId'] . "' OR itemIdFKList LIKE '%," . $row['itemId'] . ",%' OR itemIdFKList LIKE '" . $row['itemId'] . ",%' OR itemIdFKList LIKE '%," . $row['itemId'] . "'";
      $documentsresult = mysql_query($documentsquery);
      while ($documentsrow = mysql_fetch_array($documentsresult)) {
        $documents[] = $documentsrow['documentFile'];
      }

      $relations = array();
      $relations_values = explode(",",$row['itemRelation']);
      foreach ($relations_values as $relations_value) {
        $relations[] = strtolower(trim($relations_value));
      }

      print strip_for_csv($row['itemId']) . ",";
      print strip_for_csv($row['itemCatalogId']) . ",";
      print strip_for_csv($row['itemManufacturerId']) . ",";
      print strip_for_csv($row['itemName']) . ",";
      print strip_for_csv($row['itemDesc']) . ",";
      print strip_for_csv($row['itemNote']) . ",";
      print strip_for_csv($row['itemDimensions']) . ",";
      print strip_for_csv($row['itemPublicPrice']) . ",";
      print strip_for_csv($row['itemTradePrice']) . ",";
      print strip_for_csv($row['itemShipping']) . ",";
      print strip_for_csv($row['itemSite']) . ",";
      print strip_for_csv(convert_to_int($row['itemCustom'])) . ",";
      print strip_for_csv($row['itemCustomContact']) . ",";
      print strip_for_csv(convert_to_int($row['itemTaxable'])) . ",";
      print strip_for_csv(convert_to_int($row['itemFreeShipping'])) . ",";
      for ($i = 0; $i<8; $i++) {
        print strip_for_csv($greenguides[$i]) . ",";
      }
      for ($i = 0; $i<9; $i++) {
        print strip_for_csv(($images[$i] ? "http://www.workingwondersus.com" : "") . $images[$i]) . ",";
      }
      for ($i = 0; $i<8; $i++) {
        print strip_for_csv($categories[$i]) . ",";
      }
      print strip_for_csv($brandname) . ",";
      for ($i = 0; $i<8; $i++) {
        print strip_for_csv(($documents[$i] ? "http://www.workingwondersus.com" : "") . $documents[$i]) . ",";
      }
      for ($i = 0; $i<8; $i++) {
        print strip_for_csv($relations[$i]) . ",";
      }
      print "\r\n";
    }
  }

  function strip_for_csv($text) {
    $text = str_replace(",","&comma;",$text);
    $text = str_replace("\r\n","&newline;",$text);
    $text = str_replace("\r","&newline;",$text);
    $text = str_replace("\n","&newline;",$text);
    $text = str_replace('"',"&quot;",$text);
    return $text;
  }

  function convert_to_int($value) {
    switch ($value) {
      case 'Y':
        return 1;
        break;
      case 'N':
        return 0;
        break;
      default:
        return $value;
        break;
    }
  }
?>
