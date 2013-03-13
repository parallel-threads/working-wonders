<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php print $language->language; ?>" lang="<?php print $language->language; ?>" dir="<?php print $language->dir; ?>">

<head>
    <title><?php print $head_title; ?></title>
    <?php print $head; ?>
    <?php print $styles; ?>

	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <?php print $scripts; ?>
</head>

<body>
<div id="mainwrapper">

<div id="header" class="clearfix">
<div id="headerL"><a href="/"><img src="/<?php print $directory; ?>/images/logo-header.png" alt="working wonders: come home to a better world" width="300" height="94"  /></a></div>

<div id="headerR">
<div class="phone">866.569.0339</div>
<div class="head-nav">
<div>
<ul>
   	<li><a href="/wishlist">wish list</a></li>
   	<li class="last"><a href="/user/login">sign in</a></li>
   	<li class="spec"><a href="/cart"><img src="/<?php print $directory; ?>/images/cart.png" width="95" height="25" alt="shopping cart" /></a></li>
   	<li class="spec"><a href="/cart/checkout"><img src="/<?php print $directory; ?>/images/checkout.png" width="71" height="25" alt="checkout" /></a></li>
</ul>
</div> 
</div>
<?php if ($search_box): ?>
<div class="search">   
	<?php print $search_box; ?>
</div>
<?php endif; ?>
</div>
</div> <!--closes header -->

<div id="nav" class="clearfix">
	
	    <?php if ($top_navigation): ?>
              <?php print $top_navigation; ?>
    	    <?php endif; ?>
	<ul class="menu">
	</ul>
	</div> <!--closes nav -->
	 <?php if (!$content_top): ?>
    <div class="line"></div>
	<?php endif; ?>
	<?php if ($breadcrumb): ?>
  			<div id="crumbs">
    			<?php print $breadcrumb; ?>
  			</div>
	<?php endif; ?>
    <!-- ______________________ MAIN _______________________ -->


<?php if ($column_left): ?>
   <div id="column-left" class="column">
      <?php print $column_left; ?>
   </div> <!-- /#column-left -->
<?php endif; ?>

<div id="contentwrapper clearfix">
 <?php if ($content_top): ?>
          <div id="content-top" class="region region-content_top">
        <?php print $content_top; ?>
          </div> <!-- /#content-top -->
        <?php endif; ?>

        <?php if ($title || $tabs || $help || $messages): ?>
        	<?php if ($tabs): ?>
              <div class="tabs"><?php print $tabs; ?></div>
            <?php endif; ?>
            <?php print $help; ?>    
            <?php print $messages; ?>
        	<?php if (($title) && !($node->type == "product")): ?>
              <h1 class="title"><?php print $title; ?></h1>
            <?php endif; ?>
	  <?php endif; ?>

        <div id="content-area">
          <?php print $content; ?>
        </div>

        <?php if ($feed_icons): ?>
          <div class="feed-icons"><?php print $feed_icons; ?></div>
        <?php endif; ?>

        <?php if ($content_bottom): ?>
          <div id="content-bottom" class="region region-content_bottom">
            <?php print $content_bottom; ?>
          </div> <!-- /#content-bottom -->
        <?php endif; ?>

		<?php if ($column_right): ?>
          <div id="column-right" class="column">
            <?php print $column_right; ?>
          </div> <!-- /#column-right -->
        <?php endif; ?>

<div id="footer" class="clearfix">
<div class="line-bot"></div>
  <div class="c1"><a href="/"><img src="/<?php print $directory; ?>/images/logo-footer.png" width="208" height="78" alt="working wonders: come home top a better world" /></a>
  <div class="copy">&copy; Working Wonders 2011 All Rights Reserved</div>
  </div>
  
  	<?php if ($footer_col_mid): ?>
          <div id="footer_col_mid" class="region region-footer_col_mid c2">
            <?php print $footer_col_mid; ?>
          </div> <!-- /#footer_col_mid -->
    <?php endif; ?>
  
 	<?php if ($footer_col_right): ?>
          <div id="footer_col_right" class="region region-footer_col_right c3">
            <?php print $footer_col_right; ?>
          </div> <!-- /#footer_col_mid -->
    <?php endif; ?>
</div> <!--closes footer-->

</div> <!--closes mainwrapper -->

<?php print $closure; ?>
  </body>
</html>
