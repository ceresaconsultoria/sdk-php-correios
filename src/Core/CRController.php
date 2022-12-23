<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace CR\Core;

use CR\Entity\CRToken;

/**
 * Description of MSController
 *
 * @author weslley
 */
class CRController extends CRHttp{
    protected CRToken $token;
    
    public function __construct(array $config = []) {        
        parent::__construct($config);
    }
    
    public function getToken(): CRToken {
        return $this->token;
    }

    public function setToken(CRToken $token) {
        $this->token = $token;
        return $this;
    }
}
