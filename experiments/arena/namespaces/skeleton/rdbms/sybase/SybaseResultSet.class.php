<?php
/* This class is part of the XP framework
 *
 * $Id: SybaseResultSet.class.php 8971 2006-12-27 15:27:10Z friebe $ 
 */

  namespace rdbms::sybase;

  uses('rdbms.ResultSet');

  /**
   * Result set
   *
   * @ext      sybase_ct
   * @purpose  Resultset wrapper
   */
  class SybaseResultSet extends rdbms::ResultSet {
  
    /**
     * Constructor
     *
     * @param   resource handle
     */
    public function __construct($result) {
      $fields= array();
      if (is_resource($result)) {
        for ($i= 0, $num= sybase_num_fields($result); $i < $num; $i++) {
          $field= sybase_fetch_field($result, $i);
          $fields[$field->name]= $field->type;
        }
      }
      parent::__construct($result, $fields);
    }

    /**
     * Seek
     *
     * @param   int offset
     * @return  bool success
     * @throws  rdbms.SQLException
     */
    public function seek($offset) { 
      if (!sybase_data_seek($this->handle, $offset)) {
        throw(new rdbms::SQLException('Cannot seek to offset '.$offset));
      }
      return TRUE;
    }
    
    /**
     * Iterator function. Returns a rowset if called without parameter,
     * the fields contents if a field is specified or FALSE to indicate
     * no more rows are available.
     *
     * @param   string field default NULL
     * @return  mixed
     */
    public function next($field= ) {
      if (
        !is_resource($this->handle) ||
        FALSE === ($row= sybase_fetch_assoc($this->handle))
      ) {
        return FALSE;
      }

      foreach (array_keys($row) as $key) {
        if (NULL === $row[$key] || !isset($this->fields[$key])) continue;
        if ('datetime' == $this->fields[$key]) {
          $row[$key]= util::Date::fromString($row[$key]);
        }
      }
      
      if ($field) return $row[$field]; else return $row;
    }
    
    /**
     * Close resultset and free result memory
     *
     * @return  bool success
     */
    public function close() { 
      return sybase_free_result($this->handle);
    }
  }
?>