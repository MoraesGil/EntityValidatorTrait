<?php
/*
* @author Gilberto Prudêncio Vaz de Moraes <moraesdev@gmail.com>
* @copyright Copyright (c) 2017
* @category PHP Trait
* @version [1.0]
* @date     2017-01-22
* @license M.I.T
*/
namespace Traits\Entities;

use Validator;

trait EntityValidatorTrait {
  public $errors;

  public function hasRules(){
    return isset($this->rules) && is_array($this->rules);
  }

  public function validate($data, $id = null,$rules=null) {

    $rules = isset($rules) && is_array($rules) ? $rules : $this->rules;

    #this section is for except update rule dinamicly.
    $id = $id ? $id : 'NULL';
    $rules = json_encode($rules);
    $rules = str_replace('@except',$id,$rules);
    $rules = json_decode($rules,true);
    #end secion

    $this->custom_messages = isset($this->custom_messages) ? $this->custom_messages : [];
    $this->attributeNames = isset($this->attributeNames) ? $this->attributeNames : [];

    $validator = Validator::make($data, $rules, $this->custom_messages);

    $validator->setAttributeNames($this->attributeNames);

     if ($validator->fails()) {
      $this->errors = $validator->errors();
      return false;
    }
    return true;
  }
}
