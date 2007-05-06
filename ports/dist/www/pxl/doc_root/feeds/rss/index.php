<?php
/* This file is part of the XP framework's port "Album"
 *
 * $Id: index.php 4695 2005-02-20 00:57:14Z friebe $ 
 */
  require('lang.base.php');
  xp::sapi('scriptlet.development', 'cgi');
  uses(
    'name.kiesel.pxl.scriptlet.RssFeedScriptlet',
    'util.PropertyManager',
    'rdbms.ConnectionManager'
  );
  
  // {{{ main
  chdir(dirname(__FILE__).'/../../');
  
  $pm= PropertyManager::getInstance();
  $pm->configure('../etc/');
  Logger::getInstance()->configure($pm->getProperties('log'));
  ConnectionManager::getInstance()->configure($pm->getProperties('database'));

  scriptlet::run(new RssFeedScriptlet());
  // }}}  
?>
