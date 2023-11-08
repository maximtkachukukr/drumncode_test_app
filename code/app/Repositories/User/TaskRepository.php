<?php

declare(strict_types=1);

namespace App\Repositories\User;

use App\Models\Task;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Enumerable;
use LogicException;

class TaskRepository implements TaskRepositoryInterface
{
    public function __construct(private readonly Task $task)
    {
    }

    /**
     * @inheritDoc
     */
    public function findById(int $userId, int $id, array $columns = ['*']): Task
    {
        $task = Task::where('user_id', '=', $userId)->whereKey($id)->first($columns);

        if (is_null($task)) {
            throw (new ModelNotFoundException)->setModel(
                get_class($this->task), $id
            );
        }
        return $task;
    }

    /**
     * @inheritDoc
     */
    public function all(int $userId): Enumerable
    {
        return $this->task->where('user_id', '=', $userId)->get();
    }

    /**
     * @inheritDoc
     */
    public function search(int $userId): Builder
    {
        return $this->task->where('user_id', '=', $userId);
    }

    /**
     * @inheritDoc
     */
    public function save(Task $task): bool
    {
        return $task->save();
    }

    /**
     * @inheritDoc
     */
    public function deleteById(int $userId, int $id): void
    {
        $task = $this->task->where('user_id', '=', $userId)->whereKey($id)->first();
        if ($task === null) {
            throw (new ModelNotFoundException)->setModel(
                get_class($this->task), $id
            );
        }
        if (!$task->delete()) {
            throw new LogicException('Delete error');
        }
    }
}
