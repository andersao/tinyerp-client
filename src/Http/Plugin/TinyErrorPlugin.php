<?php

namespace Prettus\TinyERP\Http\Plugin;

use Http\Client\Common\Plugin;
use Http\Promise\Promise;
use Prettus\TinyERP\Exceptions\ConflictException;
use Prettus\TinyERP\Exceptions\EmptyResponseException;
use Prettus\TinyERP\Exceptions\InvalidTokenException;
use Prettus\TinyERP\Exceptions\ServiceUnavailableException;
use Prettus\TinyERP\Exceptions\TooManyRequestsException;
use Prettus\TinyERP\Exceptions\ValidationException;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class TinyErrorPlugin implements Plugin
{
    public function handleRequest(RequestInterface $request, callable $next, callable $first): Promise
    {
        $promise = $next($request);

        return $promise->then(function (ResponseInterface $response) use ($request) {
            return $this->transformResponseToException($request, $response);
        });
    }

    /**
     * @throws TooManyRequestsException
     * @throws ConflictException
     * @throws InvalidTokenException
     * @throws ValidationException
     * @throws ServiceUnavailableException
     * @throws EmptyResponseException
     */
    private function transformResponseToException(RequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        if ($response->getStatusCode() === 429) {
            throw new TooManyRequestsException('Too many requests');
        }

        $contents = $response->getBody()->getContents();
        $json = json_decode($contents, true);

        var_dump($json);

        $retorno = $json['retorno'];
        $status = $retorno['status'] ?? null;
        $codigoErro = $retorno['codigo_erro'] ?? null;

        if ($codigoErro || $status === 'Erro') {
            if (isset($retorno['registros'])) {
                foreach ($retorno['registros'] as $row) {
                    $registro = $row['registro'] ?? null;
                    $this->translateError(intval($registro['codigo_erro']), $registro['erros'] ?? []);
                }
            } else {
                $this->translateError($codigoErro, $retorno['erros'] ?? []);
            }
        }

        $response->getBody()->rewind();

        return $response;
    }

    protected function translateError(int $codigo, array $erros): void
    {
        $errors = array_map(function ($error) {
            return $error['erro'];
        }, $erros);

        $message = join('\n', $errors) ?? '';

        match ($codigo) {
            2 => throw new InvalidTokenException($message),
            6, 11 => throw new TooManyRequestsException($message),
            30 => throw new ConflictException($message),
            31 => throw new ValidationException($errors),
            20 => throw new EmptyResponseException($message),
            99 => throw new ServiceUnavailableException($message),
            default => throw new \Exception($message),
        };
    }
}