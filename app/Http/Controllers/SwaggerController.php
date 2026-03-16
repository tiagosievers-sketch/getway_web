<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Response;
use OpenApi\Generator;
use OpenApi\Attributes as OA;

#[OA\OpenApi(
    security: [['bearerAuth' => []]]
)]
#[OA\Info(
    version: '0.1', title: 'EDE-GATEWAY'
)]
#[OA\SecurityScheme(securityScheme: 'bearerAuth', type: 'http', bearerFormat: 'JWT', scheme: 'bearer')]
#[OA\Components( responses: [
    new OA\Response(response: '401', description: 'Não Autenticado'),
    new OA\Response(response: '403', description: 'Não Autorizado'),
    new OA\Response(response: '404', description: 'Não encontrado'),
    new OA\Response(response: '422', description: 'Erro de validação'),
])]
class SwaggerController extends Controller
{
    /**
     * Função base para escanear o código e gerar a documentação da api
     * @return \Illuminate\Http\Response
     */
    public function swaggerGen(): \Illuminate\Http\Response
    {
        $openApi =  \OpenApi\Generator::scan([app_path()]);

        return Response::make($openApi->toYaml(), 200, ['Content-Type' => 'application/x-yaml']);
    }
}
