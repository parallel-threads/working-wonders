----------------------
Ubercart Product Import
----------------------
  Developed by Dan Ziemecki - http://www.zimecki.net

SUMMARY:

  Ubercart Product Import was developed by Dan Ziemecki for Diversified Metal Fabricators. Its purpose is to allow 
store admins to import product lists.

REQUIREMENTS:
  -Ubercart
  -Drupal 6
  -Price quotes
  -Product
  
INSTALLATION:
  If you have not already done so, install Ubercart. Also make sure that the
  Ubercart Product & Price quotes modules are installed. Copy the unzipped uc_prodimport 
  folder to the modules/ubercart/contrib folder.   Enable the module via the Administer >> 
  Site Building >> Modules page.
  
  Note that, due to the inherent risk associated with this module, it should be left disabled
  when not in use.
  
CONFIGURATION:
  No configuration is required.  There *is* a variable "$amt" in uc_prodimport_purge_nodes
  that you may wish to change to enable more or less product deletes in a single pass.  The
  default is 8000.
  
USAGE:
  Drill to the module by navigating to Administer >> Store administration >> Products >> 
  Import products.  Select a CSV file in the requisite format in the Upload Data field.  In 
  most cases, you'll need to select the "Delete current product set" checkbox.  If you need to
  break the import up into multiple files, then you will only want to select it the first time.
  Hit the "Import File" button.
  
CONTACT:
   Developers:
   * Dan Ziemecki (dziemecki) - dan@ziemecki.com
   
   Maintainers:
   * Dan Ziemecki (dziemecki) - dan@ziemecki.com



