<?php
/* This class is part of the XP framework
 *
 * $Id: ShortMapping.class.php 10594 2007-06-11 10:04:54Z friebe $ 
 */

  namespace remote::protocol;

  uses('lang.types.Short', 'remote.protocol.SerializerMapping');

  /**
   * Mapping for lang.types.Short
   *
   * @see      xp://remote.protocol.Serializer
   * @purpose  Mapping
   */
  class ShortMapping extends lang::Object implements SerializerMapping {

    /**
     * Returns a value for the given serialized string
     *
     * @param   server.protocol.Serializer serializer
     * @param   remote.protocol.SerializedData serialized
     * @param   array<string, mixed> context default array()
     * @return  mixed
     */
    public function valueOf($serializer, $serialized, $context= array()) {
      $value= new lang::types::Short($serialized->consumeWord());
      return $value;
    }

    /**
     * Returns an on-the-wire representation of the given value
     *
     * @param   server.protocol.Serializer serializer
     * @param   lang.Object value
     * @param   array<string, mixed> context default array()
     * @return  string
     */
    public function representationOf($serializer, $value, $context= array()) {
      return 'S:'.$value->value.';';
    }
    
    /**
     * Return XPClass object of class supported by this mapping
     *
     * @return  lang.XPClass
     */
    public function handledClass() {
      return lang::XPClass::forName('lang.types.Short');
    }
  } 
?>