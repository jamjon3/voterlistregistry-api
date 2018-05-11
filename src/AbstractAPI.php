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
  private $host;
  private $jwtuser;
  private $jwtpassword;
  protected $entities = [
    'Identity' => null
  ];
  public function __get(string $entity): object {
    if(\array_key_exists($entity, $this->entities)) {
      if(!isset($this->entities[$entity])) {
        $this->entities[$entity] = new \join("\\", ['\YMD\VoterListRegistryAPI\entities',$entity]);
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
  public function getJWT() {
    $request = \json_encode([
      'username' => $this->jwtuser,
      'password' => $this->jwtpassword
    ]);
    $ch = \curl_init($this->host);
    \curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
    \curl_setopt($ch, CURLOPT_POSTFIELDS, $request);
    \curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    \curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Content-Type: application/json',
        'Content-Length: ' . strlen($request))
    );    
    \curl_setopt($ch, CURLOPT_TIMEOUT, 5);
    \curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
    //enable headers
    \curl_setopt($ch, CURLOPT_HEADER, 1);
    //get only headers
    \curl_setopt($ch, CURLOPT_NOBODY, 1);
    //execute post
    $result = \curl_exec($ch);
    //close connection
    \curl_close($ch);
    $headers = $this->headersToArray($result);
    if (!empty($headers['Authorization'])) {
      return explode(" ", $headers['Authorization'])[1];
    }
    return null;
  }
  private function headersToArray($raw) {
    $headers=array();
    $data=\explode("\n",$raw);
    $headers['status']=$data[0];
    \array_shift($data);
    foreach($data as $part){
      $middle=\explode(":",$part);
      $headers[trim($middle[0])] = trim($middle[1]);
    }
    return $headers;
  }
}
