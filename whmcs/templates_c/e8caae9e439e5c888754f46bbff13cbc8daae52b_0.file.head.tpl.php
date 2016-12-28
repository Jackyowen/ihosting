<?php
/* Smarty version 3.1.29, created on 2016-12-26 11:37:50
  from "C:\xampp7.0\htdocs\ihosting\whmcs\templates\six\includes\head.tpl" */

if ($_smarty_tpl->smarty->ext->_validateCompiled->decodeProperties($_smarty_tpl, array (
  'has_nocache_code' => false,
  'version' => '3.1.29',
  'unifunc' => 'content_5860f2fef184b6_61087079',
  'file_dependency' => 
  array (
    'e8caae9e439e5c888754f46bbff13cbc8daae52b' => 
    array (
      0 => 'C:\\xampp7.0\\htdocs\\ihosting\\whmcs\\templates\\six\\includes\\head.tpl',
      1 => 1475406298,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5860f2fef184b6_61087079 ($_smarty_tpl) {
?>
<!-- Bootstrap -->
<link href="<?php echo $_smarty_tpl->tpl_vars['BASE_PATH_CSS']->value;?>
/bootstrap.min.css" rel="stylesheet">
<link href="<?php echo $_smarty_tpl->tpl_vars['BASE_PATH_CSS']->value;?>
/font-awesome.min.css" rel="stylesheet">

<!-- Styling -->
<link href="<?php echo $_smarty_tpl->tpl_vars['WEB_ROOT']->value;?>
/templates/<?php echo $_smarty_tpl->tpl_vars['template']->value;?>
/css/overrides.css" rel="stylesheet">
<link href="<?php echo $_smarty_tpl->tpl_vars['WEB_ROOT']->value;?>
/templates/<?php echo $_smarty_tpl->tpl_vars['template']->value;?>
/css/styles.css" rel="stylesheet">

<!-- jQuery -->
<?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['BASE_PATH_JS']->value;?>
/jquery.min.js"><?php echo '</script'; ?>
>

<!-- Custom Styling -->
<link rel="stylesheet" href="<?php echo $_smarty_tpl->tpl_vars['WEB_ROOT']->value;?>
/templates/<?php echo $_smarty_tpl->tpl_vars['template']->value;?>
/css/custom.css">

<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
  <?php echo '<script'; ?>
 src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"><?php echo '</script'; ?>
>
  <?php echo '<script'; ?>
 src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"><?php echo '</script'; ?>
>
<![endif]-->

<?php if (!empty($_smarty_tpl->tpl_vars['loadMarkdownEditor']->value)) {?>
    <!-- Markdown Editor -->
    <link href="<?php echo $_smarty_tpl->tpl_vars['BASE_PATH_CSS']->value;?>
/bootstrap-markdown.min.css" rel="stylesheet" />
    <?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['BASE_PATH_JS']->value;?>
/bootstrap-markdown.js"><?php echo '</script'; ?>
>
    <?php if (!empty($_smarty_tpl->tpl_vars['mdeLocale']->value)) {?>
        <?php echo $_smarty_tpl->tpl_vars['mdeLocale']->value;?>

    <?php }
}?>

<?php if ($_smarty_tpl->tpl_vars['templatefile']->value == "viewticket" && !$_smarty_tpl->tpl_vars['loggedin']->value) {?>
  <meta name="robots" content="noindex" />
<?php }
}
}
