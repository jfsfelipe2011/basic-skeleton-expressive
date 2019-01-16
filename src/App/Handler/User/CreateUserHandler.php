<?php

declare(strict_types=1);

namespace App\Handler\User;

use App\Action\User\AddUserAction;
use App\Formatter\Validation\ErrorArrayFormatter;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Zend\Diactoros\Response\JsonResponse;

class CreateUserHandler implements RequestHandlerInterface
{
    /** @var AddUserAction */
    private $action;

    /** @var ErrorArrayFormatter */
    private $formatter;

    /**
     * CreateUserHandler constructor.
     *
     * @param AddUserAction $action
     * @param ErrorArrayFormatter $formatter
     */
    public function __construct(AddUserAction $action, ErrorArrayFormatter $formatter)
    {
        $this->action = $action;
        $this->formatter = $formatter;
    }

    /**
     * Faz a criação de um usuário
     *
     * @param ServerRequestInterface $request
     * @return ResponseInterface
     */
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $data = $request->getParsedBody();

        try {
            $user = $this->action->action($data);
            return new JsonResponse($user, 201);
        } catch (\InvalidArgumentException $exception) {
            return new JsonResponse($this->formatter->format($exception->getMessage()), 400);
        } catch (\RuntimeException | \Exception $exception) {
            return new JsonResponse(['errors' => [ 'runtime' => $exception->getMessage()]], 400);
        }
    }
}