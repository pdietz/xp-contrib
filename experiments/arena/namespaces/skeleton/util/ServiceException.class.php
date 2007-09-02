<?php
/* This class is part of the XP framework
 *
 * $Id: ServiceException.class.php 10977 2007-08-27 17:14:26Z friebe $ 
 */

  namespace util;

  ::uses('lang.ChainedException');

  /**
   * Indicates a certain fault occurred. Service methods may throw
   * this exception to indicate a well-known, categorised exceptional
   * situation has been met.
   *
   * The faultcode set within this exception object will be propagated into
   * the server's fault message's faultcode. This code can be used by clients
   * to recognize the type of error (other than by looking at the message).
   *
   * @see      xp://webservices.soap.rpc.SoapRpcRouter#doPost
   * @purpose  Custom service exception.
   */
  class ServiceException extends lang::ChainedException {
    public
      $faultcode;

    /**
     * Constructor
     *
     * @param   mixed faultcode faultcode (can be int or string)
     * @param   string message
     * @param   lang.Throwable default NULL cause causing exception
     */
    public function __construct($faultcode, $message, $cause= NULL) {
      $this->faultcode= $faultcode;
      parent::__construct($message, $cause);
    }

    /**
     * Set Faultcode
     *
     * @param   mixed faultcode
     */
    public function setFaultcode($faultcode) {
      $this->faultcode= $faultcode;
    }

    /**
     * Get Faultcode
     *
     * @return  mixed
     */
    public function getFaultcode() {
      return $this->faultcode;
    }
    
    /**
     * Retrieve stacktrace from cause if set or from self otherwise.
     *
     * @return  lang.StackTraceElement[] array of stack trace elements
     * @see     xp://lang.StackTraceElement
     */
    public function getStackTrace() {
      if (NULL !== $this->cause) return $this->cause->getStackTrace();
      
      return parent::getStackTrace();
    }
  }
?>