<?php
/* Smarty version 3.1.29, created on 2016-12-27 01:51:18
  from "C:\xampp7.0\htdocs\ihosting\whmcs\admin\templates\blend\homepage.tpl" */

if ($_smarty_tpl->smarty->ext->_validateCompiled->decodeProperties($_smarty_tpl, array (
  'has_nocache_code' => false,
  'version' => '3.1.29',
  'unifunc' => 'content_5861bb06c6ba63_78425408',
  'file_dependency' => 
  array (
    '5726e9032172d1b816b0a1c21dad2d74b0a0c1fe' => 
    array (
      0 => 'C:\\xampp7.0\\htdocs\\ihosting\\whmcs\\admin\\templates\\blend\\homepage.tpl',
      1 => 1475406296,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5861bb06c6ba63_78425408 ($_smarty_tpl) {
if ($_smarty_tpl->tpl_vars['viewincometotals']->value) {?>
    <div id="incometotals" class="home-income-stats">
        <a href="transactions.php">
            <img src="images/icons/transactions.png" align="absmiddle" border="0">
            <strong><?php echo $_smarty_tpl->tpl_vars['_ADMINLANG']->value['billing']['income'];?>
</strong>
        </a>
        <img src="images/loading.gif" align="absmiddle" />
        <?php echo $_smarty_tpl->tpl_vars['_ADMINLANG']->value['global']['loading'];?>

    </div>
<?php }?>

<div class="clearfix"></div>

<?php if ($_smarty_tpl->tpl_vars['maintenancemode']->value) {?>
    <div class="errorbox" style="font-size:14px;">
        <?php echo $_smarty_tpl->tpl_vars['_ADMINLANG']->value['home']['maintenancemode'];?>

    </div>
    <br />
<?php }?>

<?php echo $_smarty_tpl->tpl_vars['infobox']->value;?>


<p><?php echo $_smarty_tpl->tpl_vars['_ADMINLANG']->value['global']['welcomeback'];?>
 <?php echo $_smarty_tpl->tpl_vars['admin_username']->value;?>
!</p>

<?php
$_from = $_smarty_tpl->tpl_vars['addons_html']->value;
if (!is_array($_from) && !is_object($_from)) {
settype($_from, 'array');
}
$__foreach_addon_html_0_saved_item = isset($_smarty_tpl->tpl_vars['addon_html']) ? $_smarty_tpl->tpl_vars['addon_html'] : false;
$_smarty_tpl->tpl_vars['addon_html'] = new Smarty_Variable();
$_smarty_tpl->tpl_vars['addon_html']->_loop = false;
foreach ($_from as $_smarty_tpl->tpl_vars['addon_html']->value) {
$_smarty_tpl->tpl_vars['addon_html']->_loop = true;
$__foreach_addon_html_0_saved_local_item = $_smarty_tpl->tpl_vars['addon_html'];
?>
    <div class="addon-html-output-container">
        <?php echo $_smarty_tpl->tpl_vars['addon_html']->value;?>

    </div>
<?php
$_smarty_tpl->tpl_vars['addon_html'] = $__foreach_addon_html_0_saved_local_item;
}
if ($__foreach_addon_html_0_saved_item) {
$_smarty_tpl->tpl_vars['addon_html'] = $__foreach_addon_html_0_saved_item;
}
?>

<div class="row">
    <div class="col-sm-6">
        <div class="homecolumn left" id="homecol1">
            <div class="homewidget" id="sysinfo">
                <div class="widget-header"><?php echo $_smarty_tpl->tpl_vars['_ADMINLANG']->value['global']['systeminfo'];?>
</div>
                <div class="widget-content">
                    <table width="100%">
                        <tr>
                            <td width="20%" style="text-align:right;padding-right:5px;"><?php echo $_smarty_tpl->tpl_vars['_ADMINLANG']->value['license']['regto'];?>
</td>
                            <td width="35%"><?php echo $_smarty_tpl->tpl_vars['licenseinfo']->value['registeredname'];?>
</td>
                            <td width="10%" style="text-align:right;padding-right:5px;"><?php echo $_smarty_tpl->tpl_vars['_ADMINLANG']->value['license']['expires'];?>
</td>
                            <td width="35%"><?php echo $_smarty_tpl->tpl_vars['licenseinfo']->value['expires'];?>
</td>
                        </tr>
                        <tr>
                            <td style="text-align:right;padding-right:5px;"><?php echo $_smarty_tpl->tpl_vars['_ADMINLANG']->value['license']['type'];?>
</td>
                            <td><?php echo $_smarty_tpl->tpl_vars['licenseinfo']->value['productname'];?>
</td>
                            <td style="text-align:right;padding-right:5px;"><?php echo $_smarty_tpl->tpl_vars['_ADMINLANG']->value['global']['version'];?>
</td>
                            <td><?php echo $_smarty_tpl->tpl_vars['licenseinfo']->value['currentversion'];
if ($_smarty_tpl->tpl_vars['licenseinfo']->value['updateavailable']) {?> <span class="textred"><strong><?php echo $_smarty_tpl->tpl_vars['_ADMINLANG']->value['license']['updateavailable'];?>
</strong></span><?php }?></td>
                        </tr>
                        <tr>
                            <td style="text-align:right;padding-right:5px;"><?php echo $_smarty_tpl->tpl_vars['_ADMINLANG']->value['global']['staffonline'];?>
</td>
                            <td colspan="3"><?php echo $_smarty_tpl->tpl_vars['adminsonline']->value;?>
</td>
                        </tr>
                    </table>
                </div>
            </div>

            <?php
$_from = $_smarty_tpl->tpl_vars['widgets']->value;
if (!is_array($_from) && !is_object($_from)) {
settype($_from, 'array');
}
$__foreach_widget_1_saved_item = isset($_smarty_tpl->tpl_vars['widget']) ? $_smarty_tpl->tpl_vars['widget'] : false;
$_smarty_tpl->tpl_vars['widget'] = new Smarty_Variable();
$_smarty_tpl->tpl_vars['widget']->_loop = false;
foreach ($_from as $_smarty_tpl->tpl_vars['widget']->value) {
$_smarty_tpl->tpl_vars['widget']->_loop = true;
$__foreach_widget_1_saved_local_item = $_smarty_tpl->tpl_vars['widget'];
?>
                <div class="homewidget" id="<?php echo $_smarty_tpl->tpl_vars['widget']->value['name'];?>
">
                    <div class="widget-header"><?php echo $_smarty_tpl->tpl_vars['widget']->value['title'];?>
</div>
                    <div class="widget-content">
                        <?php echo $_smarty_tpl->tpl_vars['widget']->value['content'];?>

                    </div>
                </div>
            <?php
$_smarty_tpl->tpl_vars['widget'] = $__foreach_widget_1_saved_local_item;
}
if ($__foreach_widget_1_saved_item) {
$_smarty_tpl->tpl_vars['widget'] = $__foreach_widget_1_saved_item;
}
?>

        </div>
    </div>
    <div class="col-sm-6">
        <div class="homecolumn right" id="homecol2">
        </div>
    </div>
</div>

<?php echo $_smarty_tpl->tpl_vars['generateInvoices']->value;?>

<?php echo $_smarty_tpl->tpl_vars['creditCardCapture']->value;?>

<?php }
}
