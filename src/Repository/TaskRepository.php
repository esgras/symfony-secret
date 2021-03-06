<?php

namespace App\Repository;

use App\Entity\Task;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * @method Task|null find($id, $lockMode = null, $lockVersion = null)
 * @method Task|null findOneBy(array $criteria, array $orderBy = null)
 * @method Task[]    findAll()
 * @method Task[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TaskRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Task::class);
    }

    public function getById(int $id): Task
    {
        $task = $this->find($id);
        if (!$task) {
            throw new NotFoundHttpException("Task with id {$id} not found");
        }
        return $task;
    }

    /**
     * @throws ORMException
     */
    public function delete(Task $task): void
    {
        $this->_em->remove($task);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function save(Task $task): Task
    {
        $this->_em->persist($task);
        $this->_em->flush();

        return $task;
    }
}
