<?php
/* Smarty version 3.1.30, created on 2017-03-21 13:55:14
  from "/home/vagrant/Code/wechat-ahnu/application/views/test.html" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_58d130c22e09b1_11163899',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'b63f38198da6ee0d6f4591e39c0539f05b2172fc' => 
    array (
      0 => '/home/vagrant/Code/wechat-ahnu/application/views/test.html',
      1 => 1490104406,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_58d130c22e09b1_11163899 (Smarty_Internal_Template $_smarty_tpl) {
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php echo '<script'; ?>
 src='<?php echo $_smarty_tpl->tpl_vars['base_url']->value;?>
/js/jquery-2.1.1.min.js' type='text/javascript' ><?php echo '</script'; ?>
>
<link href="<?php echo $_smarty_tpl->tpl_vars['base_url']->value;?>
/css/bootstrap.css" rel="stylesheet" type="text/css" />
<title>smarty安装测试</title>
</head>
    <body>
    <h1><?php echo $_smarty_tpl->tpl_vars['title']->value;?>
</h1>
    <p><?php echo $_smarty_tpl->tpl_vars['body']->value;?>
</p>
        <ul>
            <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['myarray']->value, 'v');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['v']->value) {
?>
            <li><?php echo $_smarty_tpl->tpl_vars['v']->value;?>
</li>
            <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>

        </ul>
    </body>
</html><?php }
}
