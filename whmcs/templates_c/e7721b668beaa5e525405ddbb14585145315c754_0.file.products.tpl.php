<?php
/* Smarty version 3.1.29, created on 2016-12-23 05:33:03
  from "C:\xampp7.0\htdocs\whmcs\templates\orderforms\premium_comparison\products.tpl" */

if ($_smarty_tpl->smarty->ext->_validateCompiled->decodeProperties($_smarty_tpl, array (
  'has_nocache_code' => false,
  'version' => '3.1.29',
  'unifunc' => 'content_585ca8ff5ad5a5_91066822',
  'file_dependency' => 
  array (
    'e7721b668beaa5e525405ddbb14585145315c754' => 
    array (
      0 => 'C:\\xampp7.0\\htdocs\\whmcs\\templates\\orderforms\\premium_comparison\\products.tpl',
      1 => 1475406298,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:orderforms/standard_cart/sidebar-categories.tpl' => 1,
  ),
),false)) {
function content_585ca8ff5ad5a5_91066822 ($_smarty_tpl) {
?>
<link rel="stylesheet" type="text/css" href="<?php echo $_smarty_tpl->tpl_vars['WEB_ROOT']->value;?>
/templates/orderforms/<?php echo $_smarty_tpl->tpl_vars['carttpl']->value;?>
/css/style.css" property="stylesheet" />
<?php echo '<script'; ?>
>
jQuery(document).ready(function () {
    jQuery('#btnShowSidebar').click(function () {
        if (jQuery(".product-selection-sidebar").is(":visible")) {
            jQuery('.row-product-selection').css('left','0');
            jQuery('.product-selection-sidebar').fadeOut();
            jQuery('#btnShowSidebar').html('<i class="fa fa-arrow-circle-right"></i> <?php echo $_smarty_tpl->tpl_vars['LANG']->value['showMenu'];?>
');
        } else {
            jQuery('.product-selection-sidebar').fadeIn();
            jQuery('.row-product-selection').css('left','300px');
            jQuery('#btnShowSidebar').html('<i class="fa fa-arrow-circle-left"></i> <?php echo $_smarty_tpl->tpl_vars['LANG']->value['hideMenu'];?>
');
        }
    });
});
<?php echo '</script'; ?>
>

<?php if ($_smarty_tpl->tpl_vars['showSidebarToggle']->value) {?>
    <button type="button" class="btn btn-default btn-sm" id="btnShowSidebar">
        <i class="fa fa-arrow-circle-right"></i>
        <?php echo $_smarty_tpl->tpl_vars['LANG']->value['showMenu'];?>

    </button>
<?php }?>

<div class="row row-product-selection">
    <div class="col-xs-3 product-selection-sidebar" id="premiumComparisonSidebar">
        <?php $_smarty_tpl->smarty->ext->_subtemplate->render($_smarty_tpl, "file:orderforms/standard_cart/sidebar-categories.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

    </div>
    <div class="col-xs-12">

        <div id="order-premium_comparison">
            <div class="main-container price-01">
                <div class="txt-center">
                    <h3 id="headline">
                        <?php if ($_smarty_tpl->tpl_vars['productGroup']->value['headline']) {?>
                            <?php echo $_smarty_tpl->tpl_vars['productGroup']->value['headline'];?>

                        <?php } else { ?>
                            <?php echo $_smarty_tpl->tpl_vars['productGroup']->value['name'];?>

                        <?php }?>
                    </h3>
                    <?php if ($_smarty_tpl->tpl_vars['productGroup']->value['tagline']) {?>
                        <h5 id="tagline">
                            <?php echo $_smarty_tpl->tpl_vars['productGroup']->value['tagline'];?>

                        </h5>
                    <?php }?>
                    <?php if ($_smarty_tpl->tpl_vars['errormessage']->value) {?>
                        <div class="alert alert-danger">
                            <?php echo $_smarty_tpl->tpl_vars['errormessage']->value;?>

                        </div>
                    <?php }?>
                </div>
                <div id="products" class="price-table-container">
                    <ul>
                        <?php
$_from = $_smarty_tpl->tpl_vars['products']->value;
if (!is_array($_from) && !is_object($_from)) {
settype($_from, 'array');
}
$__foreach_product_0_saved_item = isset($_smarty_tpl->tpl_vars['product']) ? $_smarty_tpl->tpl_vars['product'] : false;
$_smarty_tpl->tpl_vars['product'] = new Smarty_Variable();
$_smarty_tpl->tpl_vars['product']->iteration=0;
$_smarty_tpl->tpl_vars['product']->_loop = false;
foreach ($_from as $_smarty_tpl->tpl_vars['product']->value) {
$_smarty_tpl->tpl_vars['product']->_loop = true;
$_smarty_tpl->tpl_vars['product']->iteration++;
$__foreach_product_0_saved_local_item = $_smarty_tpl->tpl_vars['product'];
?>
                            <li id="product<?php echo $_smarty_tpl->tpl_vars['product']->iteration;?>
">
                                <div class="price-table">
                                    <div class="top-head">
                                        <div class="top-area">
                                            <h4 id="product<?php echo $_smarty_tpl->tpl_vars['product']->iteration;?>
-name"><?php echo $_smarty_tpl->tpl_vars['product']->value['name'];?>
</h4>
                                        </div>
                                        <?php if ($_smarty_tpl->tpl_vars['product']->value['tagLine']) {?>
                                            <p id="product<?php echo $_smarty_tpl->tpl_vars['product']->iteration;?>
-tag-line"><?php echo $_smarty_tpl->tpl_vars['product']->value['tagLine'];?>
</p>
                                        <?php }?>
                                        <?php if ($_smarty_tpl->tpl_vars['product']->value['isFeatured']) {?>
                                            <div class="popular-plan">
                                                <?php echo mb_strtoupper($_smarty_tpl->tpl_vars['LANG']->value['featuredProduct'], 'UTF-8');?>

                                            </div>
                                        <?php }?>

                                        <div class="price-area">
                                            <div class="price" id="product<?php echo $_smarty_tpl->tpl_vars['product']->iteration;?>
-price">
                                                <?php if ($_smarty_tpl->tpl_vars['product']->value['bid']) {?>
                                                    <?php echo $_smarty_tpl->tpl_vars['LANG']->value['bundledeal'];?>

                                                    <?php if ($_smarty_tpl->tpl_vars['product']->value['displayprice']) {?>
                                                        <br /><br /><span><?php echo $_smarty_tpl->tpl_vars['product']->value['displayPriceSimple'];?>
</span>
                                                    <?php }?>
                                                <?php } elseif ($_smarty_tpl->tpl_vars['product']->value['paytype'] == "free") {?>
                                                    <?php echo $_smarty_tpl->tpl_vars['LANG']->value['orderfree'];?>

                                                <?php } elseif ($_smarty_tpl->tpl_vars['product']->value['paytype'] == "onetime") {?>
                                                    <?php echo $_smarty_tpl->tpl_vars['product']->value['pricing']['onetime'];?>
 <?php echo $_smarty_tpl->tpl_vars['LANG']->value['orderpaymenttermonetime'];?>

                                                <?php } else { ?>
                                                    <?php if ($_smarty_tpl->tpl_vars['product']->value['pricing']['hasconfigoptions']) {?>
                                                        <?php echo $_smarty_tpl->tpl_vars['LANG']->value['from'];?>

                                                    <?php }?>
                                                    <?php echo $_smarty_tpl->tpl_vars['product']->value['pricing']['minprice']['cycleText'];?>

                                                <?php }?>
                                            </div>
                                            <?php if ($_smarty_tpl->tpl_vars['product']->value['qty'] == "0") {?>
                                                <span id="product<?php echo $_smarty_tpl->tpl_vars['product']->iteration;?>
-unavailable" class="order-button unavailable"><?php echo $_smarty_tpl->tpl_vars['LANG']->value['outofstock'];?>
</span>
                                            <?php } else { ?>
                                                <a href="<?php echo $_SERVER['PHP_SELF'];?>
?a=add&amp;<?php if ($_smarty_tpl->tpl_vars['product']->value['bid']) {?>bid=<?php echo $_smarty_tpl->tpl_vars['product']->value['bid'];
} else { ?>pid=<?php echo $_smarty_tpl->tpl_vars['product']->value['pid'];
}?>" class="order-button" id="product<?php echo $_smarty_tpl->tpl_vars['product']->iteration;?>
-order-button">
                                                    <?php echo $_smarty_tpl->tpl_vars['LANG']->value['ordernowbutton'];?>

                                                </a>
                                            <?php }?>

                                        </div>
                                    </div>
                                    <ul>
                                        <?php
$_from = $_smarty_tpl->tpl_vars['product']->value['features'];
if (!is_array($_from) && !is_object($_from)) {
settype($_from, 'array');
}
$__foreach_value_1_saved_item = isset($_smarty_tpl->tpl_vars['value']) ? $_smarty_tpl->tpl_vars['value'] : false;
$__foreach_value_1_saved_key = isset($_smarty_tpl->tpl_vars['feature']) ? $_smarty_tpl->tpl_vars['feature'] : false;
$_smarty_tpl->tpl_vars['value'] = new Smarty_Variable();
$_smarty_tpl->tpl_vars['feature'] = new Smarty_Variable();
$_smarty_tpl->tpl_vars['value']->iteration=0;
$_smarty_tpl->tpl_vars['value']->_loop = false;
foreach ($_from as $_smarty_tpl->tpl_vars['feature']->value => $_smarty_tpl->tpl_vars['value']->value) {
$_smarty_tpl->tpl_vars['value']->_loop = true;
$_smarty_tpl->tpl_vars['value']->iteration++;
$__foreach_value_1_saved_local_item = $_smarty_tpl->tpl_vars['value'];
?>
                                            <li id="product<?php echo $_smarty_tpl->tpl_vars['product']->iteration;?>
-feature<?php echo $_smarty_tpl->tpl_vars['value']->iteration;?>
">
                                                <?php echo $_smarty_tpl->tpl_vars['value']->value;?>
 <?php echo $_smarty_tpl->tpl_vars['feature']->value;?>

                                            </li>
                                        <?php
$_smarty_tpl->tpl_vars['value'] = $__foreach_value_1_saved_local_item;
}
if (!$_smarty_tpl->tpl_vars['value']->_loop) {
?>
                                            <li id="product<?php echo $_smarty_tpl->tpl_vars['product']->iteration;?>
-description">
                                                <?php echo $_smarty_tpl->tpl_vars['product']->value['description'];?>

                                            </li>
                                        <?php
}
if ($__foreach_value_1_saved_item) {
$_smarty_tpl->tpl_vars['value'] = $__foreach_value_1_saved_item;
}
if ($__foreach_value_1_saved_key) {
$_smarty_tpl->tpl_vars['feature'] = $__foreach_value_1_saved_key;
}
?>
                                    </ul>
                                </div>
                            </li>
                        <?php
$_smarty_tpl->tpl_vars['product'] = $__foreach_product_0_saved_local_item;
}
if ($__foreach_product_0_saved_item) {
$_smarty_tpl->tpl_vars['product'] = $__foreach_product_0_saved_item;
}
?>
                    </ul>
                </div>
            </div>
            <?php if (count($_smarty_tpl->tpl_vars['productGroup']->value['features']) > 0) {?>
                <div class="includes-features">
                    <div class="row clearfix">
                        <div class="col-md-12">
                            <div class="head-area">
                                <span>
                                    <?php echo $_smarty_tpl->tpl_vars['LANG']->value['orderForm']['includedWithPlans'];?>

                                </span>
                            </div>
                            <ul class="list-features">
                                <?php
$_from = $_smarty_tpl->tpl_vars['productGroup']->value['features'];
if (!is_array($_from) && !is_object($_from)) {
settype($_from, 'array');
}
$__foreach_features_2_saved_item = isset($_smarty_tpl->tpl_vars['features']) ? $_smarty_tpl->tpl_vars['features'] : false;
$_smarty_tpl->tpl_vars['features'] = new Smarty_Variable();
$_smarty_tpl->tpl_vars['features']->_loop = false;
foreach ($_from as $_smarty_tpl->tpl_vars['features']->value) {
$_smarty_tpl->tpl_vars['features']->_loop = true;
$__foreach_features_2_saved_local_item = $_smarty_tpl->tpl_vars['features'];
?>
                                    <li><?php echo $_smarty_tpl->tpl_vars['features']->value['feature'];?>
</li>
                                <?php
$_smarty_tpl->tpl_vars['features'] = $__foreach_features_2_saved_local_item;
}
if ($__foreach_features_2_saved_item) {
$_smarty_tpl->tpl_vars['features'] = $__foreach_features_2_saved_item;
}
?>
                            </ul>
                        </div>
                    </div>
                </div>
            <?php }?>
        </div>

    </div>
</div>
<?php }
}
