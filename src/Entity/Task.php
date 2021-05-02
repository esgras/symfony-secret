<?php

namespace App\Entity;

use App\Repository\TaskRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TaskRepository::class)
 */
class Task
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private int $id;

    /**
     * @ORM\Column(type="string", length=255, unique=true)
     */
    private string $name;

    /**
     * @ORM\Column(type="boolean")
     */
    private bool $finished;

    public function __construct(string $name)
    {
        $this->setName($name);
        $this->setFinished(false);
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    private function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getFinished(): ?bool
    {
        return $this->finished;
    }

    private function setFinished(bool $finished): self
    {
        $this->finished = $finished;

        return $this;
    }

    public function unfinish(): self
    {
        $this->setFinished(false);
        return $this;
    }

    public function finish(): self
    {
        $this->setFinished(true);

        return $this;
    }

    public function update(string $name): self
    {
        $this->setName($name);

        return $this;
    }
}
