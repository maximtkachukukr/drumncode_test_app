<?php

declare(strict_types=1);

namespace App\Http\Services\User\Task;

use App\Http\Requests\TaskRequest;
use App\Models\Task;
use App\Repositories\User\TaskRepositoryInterface;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class UpdateRequestedTask
{
    public function __construct(private readonly TaskRepositoryInterface $taskRepository)
    {
    }

    /**
     * @param int $id
     * @param TaskRequest $request
     * @return Task
     * @throws Exception
     * @throws ModelNotFoundException
     */
    public function execute(int $id, TaskRequest $request):Task
    {
        $task = $this->taskRepository->findById($request->user()->getId(), $id);

        foreach ($request->all(['title', 'status', 'priority', 'description']) as $key => $value) {
            if ($request->filled($key)) {
                $task->setAttribute($key, $value);
            }
        }

        $this->taskRepository->save($task);

        return $task;
    }
}
