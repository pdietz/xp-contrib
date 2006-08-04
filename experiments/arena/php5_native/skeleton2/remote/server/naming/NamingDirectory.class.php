<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  uses(
    'util.Hashmap',
    'util.log.Logger',
    'remote.NameNotFoundException'
  );

  /**
   * (Insert class' description here)
   *
   * @ext      extension
   * @see      reference
   * @purpose  purpose
   */
  class NamingDirectory extends Object {
    public
      $_map   = NULL,
      $_cat   = NULL;

    /**
     * (Insert method's description here)
     *
     * @access  
     * @param   
     * @return  
     */
    public function __construct() {
      $this->_map= new Hashmap();
      
      $log= &Logger::getInstance();
      $this->_cat= &$log->getCategory($this->getClassName());
    }
      
    /**
     * (Insert method's description here)
     *
     * @access  
     * @param   
     * @return  
     */
    public function &getInstance() {
      static $instance= NULL;
      
      if (NULL === $instance) {
        $instance= new NamingDirectory();
      }
      
      return $instance;
    }
    
    /**
     * (Insert method's description here)
     *
     * @access  
     * @param   
     * @return  
     */
    public function bind($name, &$object) {
      $this->_cat->info($this->getClassName(), 'binding new naming entry', $name);
      $this->_map->putref($name, $object);
    }
    
    /**
     * (Insert method's description here)
     *
     * @access  
     * @param   
     * @return  
     */
    public function &lookup($name) {
      if (!$this->_map->containsKey($name)) throw(new NameNotFoundException(
        $name.' not bound.'
      ));
      
      $this->_cat->debug($this->getClassName(), 'looked up naming entry', $name);
      return $this->_map->get($name);
    }
  }
?>
