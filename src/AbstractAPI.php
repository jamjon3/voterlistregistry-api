<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace YMD\VoterListRegistryAPI;

/**
 * Description of AbstractAPI
 *
 * @author jam
 */
abstract class AbstractAPI {
  protected $entities = [
    'Identity' => null,
    'IdentifierType' => null
  ];
  public function __get(string $entity): object {
    if(\array_key_exists($entity, $this->entities)) {
      if(!isset($this->entities[$entity])) {
        $this->entities[$entity] = new \implode("\\", ['\YMD\VoterListRegistryAPI\entities',$entity]);
      }
      return $this->entities[$entity];
    }
    $trace = debug_backtrace();
    trigger_error(
        'Undefined property via __get(): ' . $entity .
        ' in ' . $trace[0]['file'] .
        ' on line ' . $trace[0]['line'],
        E_USER_NOTICE);
    return null;
  }
  public function __set($entity, $value) {
    $this->entities[$entity] = $value;
  }
}
