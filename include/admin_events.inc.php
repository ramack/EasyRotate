<?php
defined('EASYROTATE_PATH') or die('Hacking attempt!');

/**
 * admin plugins menu link
 */
function easyrotate_admin_plugin_menu_links($menu)
{
  $menu[] = array(
    'NAME' => l10n('EasyRotate'),
    'URL' => EASYROTATE_ADMIN,
    );

  return $menu;
}

