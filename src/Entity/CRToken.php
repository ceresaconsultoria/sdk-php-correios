<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace CR\Entity;

/**
 * Description of CRToken
 *
 * @author weslley
 */
class CRToken {
    public $ambiente;
    public $id;
    public $ip;
    public $perfil;
    public $cnpj;
    public $cartaoPostagem;
    public $emissao;
    public $expiraEm;
    public $zoneOffset;
    public $token;
    
    public function __construct($jsonText = '') {
        if($jsonText){
            $jsonOb = json_decode($jsonText);
            foreach($jsonOb as $key => $value){
                if($key == 'token'){
                    $this->setToken($value);
                }
                else{
                    $this->$key = $value;
                }
            }
        }
    }
    
    public function isValid(){
        $now = strtotime(date('Y-m-d H:i:i'));
        $expiraEm = strtotime($this->expiraEm);
        return $expiraEm > $now;
    }
    
    public function getAmbiente() {
        return $this->ambiente;
    }

    public function getId() {
        return $this->id;
    }

    public function getIp() {
        return $this->ip;
    }

    public function getPerfil() {
        return $this->perfil;
    }

    public function getCnpj() {
        return $this->cnpj;
    }

    public function getCartaoPostagem() {
        return $this->cartaoPostagem;
    }

    public function getEmissao() {
        return $this->emissao;
    }

    public function getExpiraEm() {
        return $this->expiraEm;
    }

    public function getZoneOffset() {
        return $this->zoneOffset;
    }

    public function getToken() {
        return $this->token;
    }

    public function setAmbiente($ambiente) {
        $this->ambiente = $ambiente;
        return $this;
    }

    public function setId($id) {
        $this->id = $id;
        return $this;
    }

    public function setIp($ip) {
        $this->ip = $ip;
        return $this;
    }

    public function setPerfil($perfil) {
        $this->perfil = $perfil;
        return $this;
    }

    public function setCnpj($cnpj) {
        $this->cnpj = $cnpj;
        return $this;
    }

    public function setCartaoPostagem($cartaoPostagem) {
        $this->cartaoPostagem = $cartaoPostagem;
        return $this;
    }

    public function setEmissao($emissao) {
        $this->emissao = $emissao;
        return $this;
    }

    public function setExpiraEm($expiraEm) {
        $this->expiraEm = $expiraEm;
        return $this;
    }

    public function setZoneOffset($zoneOffset) {
        $this->zoneOffset = $zoneOffset;
        return $this;
    }

    public function setToken($token) {
        $this->token = $token;
        return $this;
    }
}
