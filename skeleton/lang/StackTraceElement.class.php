<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  /**
   * An element in a stack trace, as returned by Throwable::getStackTrace(). 
   * Each element represents a single stack frame.
   *
   * @see      xp://lang.Throwable#getStackTrace()
   * @purpose  purpose
   */
  class StackTraceElement extends Object {
    var
      $file     = '',
      $class    = '',
      $method   = '',
      $line     = 0,
      $args     = array(),
      $messages = array();
      
    /**
     * Constructor
     *
     * @access  public
     * @param   string file
     * @param   string class
     * @param   string method
     * @param   int line
     * @param   array args
     * @param   array messages
     */
    function __construct($file, $class, $method, $line, $args, $messages) {
      $this->file     = $file;  
      $this->class    = $class; 
      $this->method   = $method;
      $this->line     = $line;
      $this->args     = $args;
      $this->messages = $messages;
    }
    
    /**
     * Create string representation
     *
     * @access  public
     * @return  string
     */
    function toString() {
      $args= array();
      if (isset($this->args)) {
        for ($j= 0, $a= sizeof($this->args); $j < $a; $j++) {
          if (is_array($this->args[$j])) {
            $args[]= 'array['.sizeof($this->args[$j]).']';
          } elseif (is_object($this->args[$j])) {
            $args[]= get_class($this->args[$j]).'{}';
          } elseif (is_string($this->args[$j])) {
            $args[]= (
              '(0x'.dechex(strlen($this->args[$j])).")'".
              addcslashes(substr($this->args[$j], 0, 0x7F), "\0..\17")."'"
            );
          } else {
            $args[]= var_export($this->args[$j], 1);
          }
        }
      }
      $fmt= sprintf(
        "  at %s::%s(%s) [line %%3\$d of %s] %%2\$s\n",
        isset($this->class) ? xp::nameOf($this->class) : '<main>',
        isset($this->method) ? $this->method : '<main>',
        implode(', ', $args),
        basename(isset($this->file) ? $this->file : __FILE__)
      );
      
      if (!$this->messages) {
        return sprintf(
          $fmt, 
          E_USER_NOTICE, 
          '', 
          isset($this->line) ? $this->line : __LINE__
        );
      }
      
      $str= '';
      for ($i= 0, $s= sizeof($this->messages); $i < $s; $i++) {
        $str.= vsprintf($fmt, $this->messages[$i]);
      }
      return $str;
    }
  
  }
?>
