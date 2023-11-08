<?php

declare(strict_types=1);

namespace App\Http\Services\User\Task;

use App\Models\Task;
use App\Models\TaskStatus;
use App\Repositories\User\TaskRepositoryInterface;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Date;
use LogicException;

class SetDoneStatus
{
    public function __construct(private readonly TaskRepositoryInterface $taskRepository)
    {
    }

    /**
     * @param int $id
     * @param int $userId
     * @return Task
     * @throws ModelNotFoundException
     * @throws Exception
     */
    public function execute(int $id, int $userId): Task
    {
        $task = $this->taskRepository->findById($userId, $id);
        if ($task->getAttribute('status') === TaskStatus::DONE->value) {
            throw new LogicException('Status is done already');
        }
        $task->setAttribute('status', TaskStatus::DONE->value);
        $task->setAttribute('completed_at', Date::now());
        $this->taskRepository->save($task);
        return $task;
    }
}
