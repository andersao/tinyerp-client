<?php

namespace Prettus\TinyERP\Resources;

use Psr\Http\Client\ClientExceptionInterface;

/**
 * @property string $razao_social
 * @property string $cnpj_cpf
 * @property string $fantasia
 * @property string $endereco
 * @property string $numero
 * @property string $bairro
 * @property string $complemento
 * @property string $cidade
 * @property string $estado
 * @property string $cep
 * @property string $fone
 * @property string $email
 * @property string $inscricao_estadual
 * @property string $regime_tributario
 */
class Info extends ApiResource
{
    const RESOURCE_NAME = 'info';
    const ENTITY_ROOT_KEY = 'conta';

    /**
     * @return $this
     * @throws ClientExceptionInterface
     * @return Info
     */
    public function retrieve(): self
    {
        $request = $this->requestFactory->createRequest('GET', '/info.php');
        $content = json_decode($this->client->sendRequest($request)->getBody()->getContents(), true);
        $this->values = $content['retorno']['conta'];
        return $this;
    }
}