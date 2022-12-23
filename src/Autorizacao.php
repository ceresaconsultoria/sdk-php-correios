<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace CR;

use CR\Core\CRController;
use CR\Entity\CRToken;
use CR\Exceptions\CRException;
use Exception;
use GuzzleHttp\Exception\BadResponseException;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ServerException;

/**
 * Description of Autorizacao
 *
 * @author weslley
 */
class Autorizacao extends CRController{
    
    public function cartaoPostagem($usuario, $senha, $cartaoPostagem): CRToken{
        try{
            $response = $this->http->post('token/v1/autentica/cartaopostagem', array(
                'auth' => [$usuario, $senha],
                'json' => [
                    'numero' => $cartaoPostagem
                ]
            ));

            $body = (string)$response->getBody();
                        
            return new CRToken($body);
            
        } catch (ServerException $ex) {
            
            $body = (string)$ex->getResponse()->getBody();
            
            $bodyDecoded = json_decode($body);
            
            if(isset($bodyDecoded->msgs)){
                throw CRException::fromObjectMessage($bodyDecoded->msgs, $ex->getCode(), $ex->getPrevious());
            }
            
            throw CRException::fromObjectMessage('[ServerException] ' . $ex->getMessage(), $ex->getCode(), $ex->getPrevious());
                        
        } catch (ClientException $ex) {
            
            $body = (string)$ex->getResponse()->getBody();
            
            $bodyDecoded = json_decode($body);
            
            if(isset($bodyDecoded->msgs)){
                throw CRException::fromObjectMessage($bodyDecoded->msgs, $ex->getCode(), $ex->getPrevious());
            }
            
            throw CRException::fromObjectMessage('[ClientException] ' . $ex->getMessage(), $ex->getCode(), $ex->getPrevious());
            
        } catch (BadResponseException $ex) {
            
            $body = (string)$ex->getResponse()->getBody();
            
            $bodyDecoded = json_decode($body);
            
            if(isset($bodyDecoded->msgs)){
                
                throw CRException::fromObjectMessage($bodyDecoded->msgs, $ex->getCode(), $ex->getPrevious());
                
            }
            
            throw CRException::fromObjectMessage('[BadResponseException] ' . $ex->getMessage(), $ex->getCode(), $ex->getPrevious());
            
        } catch (Exception $ex) {
            throw new CRException($ex);
        }
    }
    
}
