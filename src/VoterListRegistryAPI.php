<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace YMD\VoterListRegistryAPI;

/**
 * Description of VoterListRegistryAPI
 *
 * @author jam
 */
class VoterListRegistryAPI extends AbstractAPI {
  public function __construct() {

    // VOTERLISTREGISTRY_HOST_param from civicrm.settings.php
    $this->host = config('voterlistregistry-api.voterlistregistry_host');

    // VOTERLISTREGISTRY_USER param for JWT.
    $this->jwtuser = config('voterlistregistry-api.voterlistregistry_user');

    // VOTERLISTREGISTRY_PASSWORD param for JWT.
    $this->jwtpassword = config('voterlistregistry-api.voterlistregistry_password');
  }
}
