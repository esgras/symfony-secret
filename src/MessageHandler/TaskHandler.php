<?php
declare(strict_types=1);

namespace App\MessageHandler;

use App\Dto\TaskCreateDto;
use App\Message\TaskMessage;
use App\Service\TaskService;
use Psr\Log\LoggerInterface;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;
use Symfony\Component\Messenger\Exception\LogicException;
use Throwable;

class TaskHandler implements MessageHandlerInterface
{
    private TaskService $taskService;
    private LoggerInterface $logger;

    public function __construct(TaskService $taskService, LoggerInterface $logger)
    {
        $this->taskService = $taskService;
        $this->logger = $logger;
    }

    public function __invoke(TaskMessage $message)
    {
        try {
            $dto = (new TaskCreateDto)->setName($message->getName());
            $this->taskService->create($dto);

            $this->logger->info('TaskMessage proceed');
        } catch (Throwable $e) {
            $loggerMessage = sprintf('{%s}|error={error}', __METHOD__);
            $loggerContext['error'] = var_export([
                'type' => get_class($e),
                'code' => $e->getCode(),
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ], true);
            $this->logger->critical($loggerMessage, $loggerContext);

            throw new LogicException('Handling of TaskMessage failed');
        }
    }
}
