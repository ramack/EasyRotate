<?php
/*
Plugin Name: EasyRotate
Version: 0.8
Description: This plugin allows easy rotation of pictures from the picture page.
Plugin URI: http://piwigo.org/ext/extension_view.php?eid=847
Author: ramack
Author URI: http://www.raphael-mack.de


    Copyright (C) 2016,2017,2019 Raphael Mack
    Copyright (C) 2019 Sam Wilson
    Copyright (C) 2019 Thomas Ekstand

    This program is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program.  If not, see <http://www.gnu.org/licenses/>.

*/

defined('PHPWG_ROOT_PATH') or die('Hacking attempt (main)!');


// +-----------------------------------------------------------------------+
// | Define plugin constants                                               |
// +-----------------------------------------------------------------------+
global $prefixTable;

define('EASYROTATE_ID',      basename(dirname(__FILE__)));
define('EASYROTATE_PATH' ,   PHPWG_PLUGINS_PATH . EASYROTATE_ID . '/');
define('EASYROTATE_ADMIN',   get_root_url() . 'admin.php?page=plugin-' . EASYROTATE_ID);
define('EASYROTATE_DIR',     PHPWG_ROOT_PATH . PWG_LOCAL_DIR . 'EasyRotate/');


// +-----------------------------------------------------------------------+
// | Add event handlers                                                    |
// +-----------------------------------------------------------------------+
// init the plugin
add_event_handler('init', 'easyrotate_init');

/*
 * this is the common way to define event functions: create a new function for each event you want to handle
 */
if (defined('IN_ADMIN'))
{
  // file containing all admin handlers functions
  $admin_file = EASYROTATE_PATH . 'include/admin_events.inc.php';

  // admin plugins menu link
  add_event_handler('get_admin_plugin_menu_links', 'easyrotate_admin_plugin_menu_links',
    EVENT_HANDLER_PRIORITY_NEUTRAL, $admin_file);

}
else
{
  // file containing all public handlers functions
  $public_file = EASYROTATE_PATH . 'include/public_events.inc.php';

  // add button on photos pages
  add_event_handler('loc_end_picture', 'easyrotate_add_buttons',
    EVENT_HANDLER_PRIORITY_NEUTRAL, $public_file);

  // Retrieve the current user theme
  $query = 'SELECT theme FROM ' . USER_INFOS_TABLE . ';';
  $theme = strtolower(pwg_db_fetch_assoc(pwg_query($query))['theme']);

  switch ($theme) {
    case 'bootstrap_darkroom':
      define('ROTATE_BOOTSTRAP', 1);
      break;

    case 'bootstrapdefault':
      define('ROTATE_BOOTSTRAP', 1);
      break;

    default:
      define('ROTATE_BOOTSTRAP', 0);
      break;
  }
}

/**
 * plugin initialization
 *   - check for upgrades
 *   - unserialize configuration
 *   - load language
 */
function easyrotate_init()
{
  global $conf;

  // load plugin language file
  load_language('plugin.lang', EASYROTATE_PATH);

  // prepare plugin configuration
  $conf['easyrotate'] = safe_unserialize($conf['easyrotate']);
}
