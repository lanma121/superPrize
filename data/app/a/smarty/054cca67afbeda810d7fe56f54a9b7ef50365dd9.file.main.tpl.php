<?php /* Smarty version Smarty-3.1.21-dev, created on 2015-12-08 17:18:49
         compiled from "D:\client\php\pdp\template\a\page\index\index\main.tpl" */ ?>
<?php /*%%SmartyHeaderCode:20628566293ff9f95d0-13740469%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '054cca67afbeda810d7fe56f54a9b7ef50365dd9' => 
    array (
      0 => 'D:\\client\\php\\pdp\\template\\a\\page\\index\\index\\main.tpl',
      1 => 1449371021,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '20628566293ff9f95d0-13740469',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.21-dev',
  'unifunc' => 'content_566293ffa2c252_56308165',
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_566293ffa2c252_56308165')) {function content_566293ffa2c252_56308165($_smarty_tpl) {?><?php echo $_smarty_tpl->getSubTemplate ("a/widgets/header/header.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

<?php echo '<script'; ?>
 type="text/javascript">
if($('#dllk').val()!=''){
	window.location.href=$('#dllk').val();
}
<?php echo '</script'; ?>
>	
<?php echo $_smarty_tpl->getSubTemplate ("a/widgets/footer/footer.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

<?php }} ?>
