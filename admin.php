<?php
/**
 * This is the main administration page, if you have only one admin page you can put
 * directly its code here or using the tabsheet system like bellow
 *
 * Copyright (C) 2016-2017  Raphael Mack

 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.

 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.

 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

defined('EASYROTATE_PATH') or die('Hacking attempt!');

global $template, $page, $conf;

// save config
if (isset($_POST['save_config']))
{
  $conf['easyrotate'] = array(
    'rotate_hd' => boolval($_POST['rotate_hd'])
    );

  conf_update_param('easyrotate', $conf['easyrotate']);
  $page['infos'][] = l10n('Information data registered in database');
}

// send config to template
$template->assign(array(
  'easyrotate' => $conf['easyrotate']
  ));

// define template file
$template->set_filename('easyrotate_content', realpath(EASYROTATE_PATH . 'template/admin_config.tpl'));

// template vars
$template->assign(array(
  'EASYROTATE_PATH'=> EASYROTATE_PATH, // used for images, scripts, ... access
  'EASYROTATE_ABS_PATH'=> realpath(EASYROTATE_PATH), // used for template inclusion (Smarty needs a real path)
  'EASYROTATE_ADMIN' => EASYROTATE_ADMIN,
  ));

// send page content
$template->assign_var_from_handle('ADMIN_CONTENT', 'easyrotate_content');
