<!-- custom search block -->
<form action="<?php echo $base_path; ?>search/node" accept-charset="UTF-8" method="post" id="search-block-form">

<div>
<div class="container-inline">
  <div class="form-item" id="edit-search-block-form-1-wrapper">
    <label for="edit-search-block-form-1">Search this site: </label>
    <input id="edit-search-block-form-1" class="form-text" type="text" title="Enter the terms you wish to search for." value="" size="15" name="search_block_form" maxlength="128">
  </div>
<input name="" type="image" value="submit" src="/<?php print $directory; ?>/images/search.png" alt="search this site" style="padding-left: .5em; padding-top: 1em;" />
<input id="form-<?php print drupal_get_token('search_form'); ?>" type="hidden" value="form-<?php print drupal_get_token('search_form'); ?>" name="form_build_id">
<input id="edit-search-block-form-form-token" type="hidden" value="cfb5fcd8585c1539e805b427cbf35719" name="form_token">
<input id="edit-search-block-form" type="hidden" value="search_block_form" name="form_id">
</div>
</div></form>
<!-- block -->

