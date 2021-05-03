<?php

namespace App\Controller;

use App\Dto\TaskCreateDto;
use App\Dto\TaskUpdateDto;
use App\Message\TaskMessage;
use App\Service\TaskService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

/**
 * @Route("/api/tasks")
 */
class TaskController extends AbstractController
{
    private TaskService $taskService;
    private SerializerInterface $serializer;
    private MessageBusInterface $messageBus;

    public function __construct(
        TaskService $taskService,
        SerializerInterface $serializer,
        MessageBusInterface $messageBus
    ) {
        $this->taskService = $taskService;
        $this->serializer = $serializer;
        $this->messageBus = $messageBus;
    }

    /**
     * @Route("", methods={"GET"})
     */
    public function findAll(): JsonResponse
    {
        return $this->json($this->taskService->findAll());
    }

    /**
     * @Route("/{id}", requirements={"id": "\d+"}, methods={"GET"})
     */
    public function find(int $id): JsonResponse
    {
        return $this->json($this->taskService->get($id));
    }

    /**
     * @Route("", requirements={"id": "\d+"}, methods={"POST"})
     */
    public function create(Request $request): JsonResponse
    {
        $dto = $this->serializer->deserialize($request->getContent(), TaskCreateDto::class, 'json');
        $this->messageBus->dispatch(new TaskMessage($dto->getName()));

        return $this->json([
            'message' => 'Task will be created soon...'
        ]);
    }

    /**
     * @Route("/{id}", requirements={"id": "\d+"}, methods={"PUT"})
     */
    public function update(int $id, Request $request): JsonResponse
    {
        /** @var TaskUpdateDto $dto */
        $dto = $this->serializer->deserialize($request->getContent(), TaskUpdateDto::class, 'json');
        $dto->setId($id);

        return $this->json($this->taskService->update($dto));
    }

    /**
     * @Route("/{id}", requirements={"id": "\d+"}, methods={"DELETE"})
     */
    public function delete(int $id): JsonResponse
    {
        $this->taskService->delete($id);

        return $this->json(true);
    }

    /**
     * @Route("/{id}/finish", requirements={"id": "\d+"}, methods={"PUT"})
     */
    public function finish(int $id): JsonResponse
    {
        $task = $this->taskService->finish($id);

        return $this->json($task);
    }

    /**
     * @Route("/{id}/unfinish", requirements={"id": "\d+"}, methods={"PUT"})
     */
    public function unfinish(int $id): JsonResponse
    {
        $task = $this->taskService->unfinish($id);

        return $this->json($task);
    }
}
