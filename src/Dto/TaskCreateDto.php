<?php
declare(strict_types=1);

namespace App\Dto;

class TaskCreateDto
{
    private string $name;
    private bool $finished;

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }

    public function isFinished(): bool
    {
        return $this->finished;
    }

    public function setFinished(bool $finished): self
    {
        $this->finished = $finished;
        return $this;
    }
}
