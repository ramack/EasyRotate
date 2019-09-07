<?php
defined('PHPWG_ROOT_PATH') or die('Hacking attempt (maintain)!');

/**
 * This class is used to expose maintenance methods to the plugins manager
 * It must extends PluginMaintain and be named "PLUGINID_maintain"
 * where PLUGINID is the directory name of your plugin.
 */
class easyrotate_maintain extends PluginMaintain
{
  private $default_conf = array(
    'rotate_hd' => false
    );

  private $dir;
  private $rotateImage_installed;
  
  function __construct($plugin_id)
  {
    parent::__construct($plugin_id); // always call parent constructor

    // Class members can't be declared with computed values so initialization is done here
    $this->dir = PHPWG_ROOT_PATH . PWG_LOCAL_DIR . 'EasyRotate/';

    $this->rotateImage_installed = file_exists(PHPWG_PLUGINS_PATH . 'rotateImage/main.inc.php')?true:false;
  }

  /**
   * Add an error message about the imageRotate plugin not being installed.
   *
   * @param string[] $errors The error array to add to.
   */
  protected function addRotateImageError(&$errors)
  {
    load_language('plugin.lang', __DIR__ . '/');
    $msg = sprintf(l10n('To install this plugin, you need to install the rotateImage plugin first.'));
    if(is_array($errors))
    {
      array_push($errors, $msg);
    }
    else
    {
      $errors = array($msg);
    }
  }

  /**
   * Plugin installation
   *
   * Perform here all needed step for the plugin installation such as create default config,
   * add database tables, add fields to existing tables, create local folders...
   */
  function install($plugin_version, &$errors=array())
  {
    global $conf;

    if (!$this->rotateImage_installed)
    {
      $this->addRotateImageError($errors);
    }
    else
    {
        // add config parameter
        if (empty($conf['easyrotate']))
        {
          // conf_update_param well serialize and escape array before database insertion
          // the third parameter indicates to update $conf['easyrotate'] global variable as well
          conf_update_param('easyrotate', $this->default_conf, true);
        }
        else
        {
          $old_conf = safe_unserialize($conf['easyrotate']);
    
          conf_update_param('easyrotate', $old_conf, true);
        }
    
        // create a local directory
        if (!file_exists($this->dir))
        {
          mkdir($this->dir, 0755);
        }
    }
  }

  /**
   * Plugin activation
   *
   * This function is triggered after installation, by manual activation or after a plugin update
   * for this last case you must manage updates tasks of your plugin in this function
   */
  function activate($plugin_version, &$errors=array())
  {
    global $pwg_loaded_plugins;
    $rotateImage_active = false;
    
    if(array_key_exists('rotateImage', $pwg_loaded_plugins))
    {
        $rotateImage_active = $pwg_loaded_plugins['rotateImage']['state'] == "active";
    }
    
    if (!$this->rotateImage_installed || !$rotateImage_active)
    {
      $this->addRotateImageError($errors);
    }
  }

  /**
   * Plugin deactivation
   *
   * Triggered before uninstallation or by manual deactivation
   */
  function deactivate()
  {
  }

  /**
   * Plugin (auto)update
   *
   * This function is called when Piwigo detects that the registered version of
   * the plugin is older than the version exposed in main.inc.php
   * Thus it's called after a plugin update from admin panel or a manual update by FTP
   */
  function update($old_version, $new_version, &$errors=array())
  {
    $this->install($new_version, $errors);
  }

  /**
   * Plugin uninstallation
   *
   * Perform here all cleaning tasks when the plugin is removed
   * you should revert all changes made in 'install'
   */
  function uninstall()
  {
    // delete configuration
    conf_delete_param('easyrotate');

    // delete local folder
    // use a recursive function if you plan to have nested directories
    foreach (scandir($this->dir) as $file)
    {
      if ($file == '.' or $file == '..') continue;
      unlink($this->dir.$file);
    }
    rmdir($this->dir);
  }
}
