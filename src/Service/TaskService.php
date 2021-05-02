<?php
declare(strict_types=1);

namespace App\Service;

use App\Dto\TaskCreateDto;
use App\Dto\TaskUpdateDto;
use App\Entity\Task;
use App\Repository\TaskRepository;

class TaskService
{
    private TaskRepository $taskRepository;

    public function __construct(TaskRepository $taskRepository)
    {
        $this->taskRepository = $taskRepository;
    }

    public function get(int $id): Task
    {
        return $this->taskRepository->getById($id);
    }

    /**
     * @return Task[]
     */
    public function findAll(): array
    {
        return $this->taskRepository->findAll();
    }

    public function create(TaskCreateDto $dto): Task
    {
        $task = new Task($dto->getName());
        $this->taskRepository->save($task);

        return $task;
    }

    public function update(TaskUpdateDto $dto): Task
    {
        $task = $this->get($dto->getId());
        $task->update($dto->getName());
        $this->taskRepository->save($task);

        return $task;
    }

    public function delete(int $id): void
    {
        $task = $this->get($id);
        $this->taskRepository->delete($task);
    }

    public function finish(int $id): Task
    {
        $task = $this->get($id);
        $task->finish();
        $this->taskRepository->save($task);

        return $task;
    }

    public function unfinish(int $id): Task
    {
        $task = $this->get($id);
        $task->unfinish();
        $this->taskRepository->save($task);

        return $task;
    }
}
