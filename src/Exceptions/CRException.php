<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace CR\Exceptions;

use Exception;

/**
 * Description of MSException
 *
 * @author weslley
 */
class CRException extends Exception{
    
    public function __construct(Exception $ex) {
        $message = $ex->getMessage() . PHP_EOL . $ex->getTraceAsString();        
        parent::__construct($message, $ex->getCode(), $ex->getPrevious());
    }
    
    public static function fromObjectMessage($message, $code, $previous = null){
        
        if(is_array($message)){
            
            $newMessageString = [];
            
            foreach($message as $error){
                $newMessageString[] =  $error;
            }                           
            
            return new CRException( new Exception(implode("\n", $newMessageString), $code, $previous) );     
        }
        
        if(is_string($message)){
            
            return new CRException( new Exception($message, $code, $previous) );     
            
        }
        
    }
    
}
