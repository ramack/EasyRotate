<?php
defined('EASYROTATE_PATH') or die('Hacking attempt!');

/*
 * buttons on photos pages
 */
function easyrotate_add_buttons()
{
  global $template, $page, $user, $conf;

  if (script_basename()=='picture' and $user['status'] != 'guest')
  {
    $imageId = $page['image_id'];

    $rotate_hd = $conf['easyrotate']['rotate_hd'];

    $template->assign(array(
      'EASYROTATE_PATH' => EASYROTATE_PATH,
      'EASYROTATE_PWG_TOKEN' => get_pwg_token(),
      'EASYROTATE_IMAGE_ID' => $imageId,
      'EASYROTATE_ROTATE_HD' => $rotate_hd
    ));

    $template->set_filename('easyrotate_button', realpath(EASYROTATE_PATH.'template/rotate_buttons.tpl'));
    $button = $template->parse('easyrotate_button', true);

    $template->add_picture_button($button, BUTTONS_RANK_NEUTRAL);
  }
}
