<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace CR;

use CR\Core\CRController;
use CR\Exceptions\CRException;
use Exception;
use GuzzleHttp\Exception\BadResponseException;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ServerException;

/**
 * Description of Cotacao
 *
 * @author weslley
 */
class Cotacao extends CRController{
    
    /**
     * 
     * @param array $data = [[
     *      'coProduto' => '',
     *      'cepOrigem' => '',
     *      'cepDestino' => '',
     *      'psObjeto' => '',
     *      'tpObjeto' => '',
     *      'comprimento' => '',
     *      'largura' => '',
     *      'altura' => '',
     *      'servicosAdicionais' => [[
     *          'coServAdicional' => ''
     *      ]],
     *      'vlDeclarado' => '',
     * ]]
     * @return array [[
     *      'coProduto' => '',
     *      'pcBase' => '',
     *      'pcBaseGeral' => '',
     *      'peVariacao' => '',
     *      'pcReferencia' => '',
     *      'vlBaseCalculoImposto' => '',
     *      'inPesoCubico' => '',
     *      'psCobrado' => '',
     *      'servicoAdicional' => [[
     *          'coServAdicional' => '',
     *          'tpServAdicional' => '',
     *          'pcServicoAdicional' => '',
     *      ]],
     *      'peAdValorem' => '',
     *      'vlSeguroAutomatico' => '',
     *      'qtAdicional' => '',
     *      'pcFaixa' => '',
     *      'pcFaixaVariacao' => '',
     *      'pcProduto' => '',
     *      'pcTotalServicosAdicionais' => '',
     *      'pcFinal' => '',
     *      'prazoEntrega' => '',
     *      'dataMaxima' => '',
     *      'entregaDomiciliar' => '',
     *      'entregaSabado' => '',
     * ]]
     */
    public function simularPrecoPrazo(array $data){
        try{
            $out = [];
                
            $simularPrecoResponse = $this->simularPrecoLote([
                'idLote' => 1,
                'parametrosProduto' => $data,
            ]);
                        
            $simularPrazoResponse = $this->simularPrazoLote([
                'idLote' => 1,
                'parametrosPrazo' => $data,
            ]);

            foreach($simularPrecoResponse as $simularPreco){            
                $simularPrecoArr = (array)$simularPreco;
                $out[$simularPreco->coProduto] = $simularPrecoArr;
            }

            foreach($simularPrazoResponse as $simularPrazo){            
                $simularPrazoArr = (array)$simularPrazo;
                $out[$simularPrazo->coProduto] = array_merge($out[$simularPrazo->coProduto], $simularPrazoArr);
            }

            return $out;
        } catch (Exception $ex) {
            throw new CRException($ex);
        }
    } 
    
    public function simularPreco($produto, array $data){
        try{
            $response = $this->http->get(sprintf('preco/v1/nacional/%s', $produto), array(
                "headers" => [
                    "Authorization" => $this->getToken()->getToken(),
                ],
                "query" => $data,
            ));

            $body = (string)$response->getBody();
                        
            return json_decode($body);
            
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
    
    public function simularPrecoLote(array $data){
        try{
            $response = $this->http->post('preco/v1/nacional', array(
                "headers" => [
                    "Authorization" => $this->getToken()->getToken(),
                ],
                "json" => $data,
            ));

            $body = (string)$response->getBody();
                        
            return json_decode($body);
            
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
    
    public function simularPrazo($produto, array $data){
        try{
            $response = $this->http->get(sprintf('prazo/v1/nacional/%s', $produto), array(
                "headers" => [
                    "Authorization" => $this->getToken()->getToken(),
                ],
                "query" => $data,
            ));

            $body = (string)$response->getBody();
                        
            return json_decode($body);
            
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
    
    public function simularPrazoLote(array $data){
        try{
            $response = $this->http->post('prazo/v1/nacional', array(
                "headers" => [
                    "Authorization" => $this->getToken()->getToken(),
                ],
                "json" => $data,
            ));

            $body = (string)$response->getBody();
                        
            return json_decode($body);
            
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
    
    public function precoServicosAdicionais($produto, array $data){
        try{
            $response = $this->http->get(sprintf('preco/v1/servicos-adicionais/%s', $produto), array(
                "headers" => [
                    "Authorization" => $this->getToken()->getToken(),
                ],
                "query" => $data,
            ));

            $body = (string)$response->getBody();
                        
            return json_decode($body);
            
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
