<?php

date_default_timezone_set('America/Sao_Paulo');
error_reporting(E_ALL);
ini_set('display_errors', 1);

require __DIR__ . "/../vendor/autoload.php";

$apiAutorizacao = new \CR\Autorizacao();

$token = $apiAutorizacao->cartaoPostagem('-', '-', '-');

//--

$apiCotacao = new \CR\Cotacao();

$apiCotacao->setToken($token);

try{
    $simulacao = $apiCotacao->simularPrecoPrazo([
        [
            'coProduto' => '03220',
            'cepDestino' => '71930000',
            'cepOrigem' => '70902000',
            'psObjeto' => '300',
            'tpObjeto' => '2',
            'comprimento' => '20',
            'largura' => '20',
            'altura' => '20',
//            'servicosAdicionais' => [
//                [
//                    'coServAdicional' => '019'
//                ],
//                [
//                    'coServAdicional' => '001'
//                ],
//            ],
            'vlDeclarado' => 0,
            'nuRequisicao' => 1
        ]
    ]);

    \CR\Helper\CRHelper::dump($simulacao);
} catch (\Exception $ex) {
    \CR\Helper\CRHelper::dump($ex->getMessage());
}

/*

try{
    $simulacao = $apiCotacao->simularPrecoLote([
        "idLote" => "1",
        "parametrosProduto" => [
            [
                "coProduto" => "03220",
                "nuRequisicao" => "1",
                "cepOrigem" => "70902000",
                "psObjeto" => "300",
                "tpObjeto" => "2",
                "comprimento" => "20",
                "largura" => "20",
                "altura" => "20",
                "servicosAdicionais" => [
                    [
                        "coServAdicional" => "019"
                    ],
                    [
                        "coServAdicional" => "001"
                    ]
                ],
                "vlDeclarado" => "100",
                "dtEvento" => "18/03/2022",
                "cepDestino" => "71930000"
            ],
            [
                "coProduto" => "04162",
                "nuRequisicao" => "1",
                "cepOrigem" => "70902000",
                "psObjeto" => "300",
                "tpObjeto" => "2",
                "comprimento" => "20",
                "largura" => "20",
                "altura" => "20",
                "servicosAdicionais" => [
                    [
                        "coServAdicional" => "019"
                    ],
                    [
                        "coServAdicional" => "001"
                    ]
                ],
                "vlDeclarado" => "100",
                "dtEvento" => "18/03/2022",
                "cepDestino" => "71930000"
            ]
        ]
    ]);

    \CR\Helper\CRHelper::dump($simulacao);
} catch (\Exception $ex) {
    \CR\Helper\CRHelper::dump($ex->getMessage());
}

try{
    $simulacao = $apiCotacao->simularPreco('03220', [
        'cepDestino' => '71930000',
        'cepOrigem' => '70902000',
        'psObjeto' => '300',
        'tpObjeto' => '2',
        'comprimento' => '20',
        'largura' => '20',
        'altura' => '20',
        'servicosAdicionais[0]' => '019',
        'servicosAdicionais[1]' => '001',
        'vlDeclarado' => '100',
    ]);

    \CR\Helper\CRHelper::dump($simulacao);
} catch (\Exception $ex) {
    \CR\Helper\CRHelper::dump($ex->getMessage());
}

*/