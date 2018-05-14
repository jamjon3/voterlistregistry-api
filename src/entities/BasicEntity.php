<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace YMD\VoterListRegistryAPI\entities;

/**
 * Description of AbstractEntity
 *
 * @author jam
 */
class BasicEntity {
  private $host;
  private $jwtuser;
  private $jwtpassword;  
  private $jwt;
  public function __construct() {

    // VOTERLISTREGISTRY_HOST_param from civicrm.settings.php
    $this->host = config('voterlistregistry-api.voterlistregistry_host');

    // VOTERLISTREGISTRY_USER param for JWT.
    $this->jwtuser = config('voterlistregistry-api.voterlistregistry_user');

    // VOTERLISTREGISTRY_PASSWORD param for JWT.
    $this->jwtpassword = config('voterlistregistry-api.voterlistregistry_password');
  }    
  /**
   * Retrieves the existing or makes a request to obtain the JWT
   * 
   * @return string
   */
  public function getJWT(): string {
    if(isset($this->jwt)) {
      return $this->jwt;
    } else {
      $request = \json_encode([
        'username' => $this->jwtuser,
        'password' => $this->jwtpassword
      ]);
      //  Initiate curl
      $ch = curl_init();
      // Disable SSL verification
      \curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
      // Will return the response, if false it print the response
      \curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
      // Set the url
      \curl_setopt($ch, CURLOPT_URL,$this->host."/login");
      \curl_setopt($ch, CURLOPT_TIMEOUT, 5);
      \curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);

      \curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
      \curl_setopt($ch, CURLOPT_POSTFIELDS, $request);
      \curl_setopt($ch, CURLOPT_HTTPHEADER, array(
          'Content-Type: application/json',
          'Content-Length: ' . strlen($request)
      ));        
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
        $this->jwt = \explode(" ", $headers['Authorization'])[1];
      }
      return $this->jwt;
    }
  }
  /**
   * Parses raw headers into an array
   * 
   * @param string $raw
   * @return array
   */
  private function headersToArray(string $raw): array {
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
  /**
   * API Request handler
   * 
   * @param string $method
   * @param string $path
   * @param array $query
   * @param array $body
   * @return array
   */
  public function apiRequest(string $method, string $path, array $query=[], array $body=[]): array {
    $ch = curl_init();                                                                      
    // Disable SSL verification
    \curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    // Will return the response, if false it print the response
		\curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 
    // Set the url
    \curl_setopt($ch, CURLOPT_URL,(empty($query))?$this->host.$path:\join("?", [ $this->host.$path, \http_build_query($query) ]));
    \curl_setopt($ch, CURLOPT_TIMEOUT, 5);
    \curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
		\curl_setopt($ch, CURLOPT_CUSTOMREQUEST, \strtoupper($method)); 
    if(\in_array(\strtoupper($method), ["PUT","POST"])) {
      $data_string = \json_encode($body);
  		\curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);                                                                  
      \curl_setopt($ch, CURLOPT_HTTPHEADER, array(                                                                          
          'Content-Type: application/json',                                                                                
          'Content-Length: ' . strlen($data_string),
          'Authorization: Bearer '.$this->getJWT()
      ));                                                                                                                         
  		\curl_setopt($ch, CURLOPT_FAILONERROR, true);                                                                    
    } else {
      \curl_setopt($ch, CURLOPT_HTTPHEADER, array(                                                                          
          'Content-Type: application/json',                                                                                
          'Authorization: Bearer '.$this->getJWT()
      ));                                                                                                                         
    }
		$result = \curl_exec($ch);
		//close connection
    \curl_close($ch);
    return \json_decode($result, TRUE);
  }
}
