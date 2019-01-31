<?php

declare(strict_types=1);

namespace App\Handler\User;

use App\Action\User\AlterUserAction;
use App\Formatter\Validation\ErrorArrayFormatter;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Zend\Diactoros\Response\JsonResponse;

class UpdateUserHandler implements RequestHandlerInterface
{
    /** @var AlterUserAction */
    private $action;

    /** @var ErrorArrayFormatter */
    private $formatter;

    /**
     * UpdateUserHandler constructor.
     *
     * @param AlterUserAction $action
     * @param ErrorArrayFormatter $formatter
     */
    public function __construct(AlterUserAction $action, ErrorArrayFormatter $formatter)
    {
        $this->action    = $action;
        $this->formatter = $formatter;
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $id = $request->getAttribute('id');
        parse_str(file_get_contents("php://input"),$data);

        try {
            $user = $this->action->action((int) $id, $data);
            return new JsonResponse($user, 201);
        } catch (\InvalidArgumentException $exception) {
            return new JsonResponse($this->formatter->format($exception->getMessage()), 400);
        } catch (\RuntimeException | \Exception $exception) {
            return new JsonResponse(['errors' => [ 'runtime' => $exception->getMessage()]], 400);
        }
    }
}