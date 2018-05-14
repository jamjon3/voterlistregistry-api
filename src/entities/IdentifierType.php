<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace YMD\VoterListRegistryAPI\entities;

/**
 * Description of IdentifierType
 *
 * @author jam
 */
class IdentifierType extends BasicEntity {
  public function __construct() {
    parent::__construct();
  }
  public function getIdentifierTypes(int $limit=5000) {
    return $this->apiRequest("GET", "/api/type/identifier");
  }
}
