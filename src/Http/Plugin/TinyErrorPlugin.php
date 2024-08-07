<?php

namespace Prettus\TinyERP\Http\Plugin;

use Http\Client\Common\Plugin;
use Http\Promise\Promise;
use Prettus\TinyERP\Exceptions\BadRequestException;
use Prettus\TinyERP\Exceptions\ConflictException;
use Prettus\TinyERP\Exceptions\EmptyResponseException;
use Prettus\TinyERP\Exceptions\NotFoundException;
use Prettus\TinyERP\Exceptions\UnauthorizedException;
use Prettus\TinyERP\Exceptions\TinyException;
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
            return $this->handleResponse($request, $response);
        });
    }

    /**
     * @throws UnauthorizedException
     * @throws EmptyResponseException
     * @throws TinyException
     */
    protected function handleResponse(RequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        if($response->getStatusCode() >= 200 && $response->getStatusCode() < 300) {
            $body = json_decode($response->getBody()->getContents(), true);

            $response->getBody()->rewind();

            if(isset($body['retorno'])) {
                $retorno = $body['retorno'];
                $status = strtolower($retorno['status'] ?? '');

                if($status == 'erro') {
                    $codigo = $retorno['codigo_erro'] ?? 0;
                    $erros = $retorno['erros'] ?? [];
                    $messsage = $this->extractFirstError($erros);

                    $exception = match ($codigo) {
                        1, 2 => new UnauthorizedException($messsage, $codigo),
                        6, 11 => new TooManyRequestsException($messsage, $codigo),
                        20 => new EmptyResponseException($messsage, $codigo),
                        30 => new ConflictException($messsage, $codigo),
                        4, 9, 31 => new ValidationException($messsage, $codigo),
                        32, 23 => new NotFoundException($messsage, $codigo),
                        10 => new BadRequestException($messsage, $codigo),
                        default => new TinyException($messsage, $codigo),
                    };

                    $exception->setErrors($erros);

                    throw $exception;
                }
            }
        }

        return $response;
    }

    public function extractFirstError($errors): ?string
    {
        if(is_array($errors) && count($errors) > 0) {
            $error = $errors[0];

            if(is_array($error) && isset($error['erro'])) {
                return $error['erro'];
            }
        }

        return null;
    }
}