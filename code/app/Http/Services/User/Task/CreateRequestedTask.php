<?php

declare(strict_types=1);

namespace App\Http\Services\User\Task;

use App\Http\Requests\TaskRequest;
use App\Models\Task;
use App\Repositories\User\TaskRepositoryInterface;
use Exception;

class CreateRequestedTask
{
    public function __construct(private readonly TaskRepositoryInterface $taskRepository)
    {
    }

    /**
     * Save new user's task from request
     *
     * @param TaskRequest $request
     * @return Task
     * @throws Exception
     */
    public function execute(TaskRequest $request): Task
    {
        $task = Task::factory()->make([
            'user_id' => $request->user()->getId(),
            'title' => $request->get('title'),
            'status' => $request->get('status'),
            'priority' => $request->get('priority'),
            'description' => $request->get('description')
        ]);

        $this->taskRepository->save($task);

        return $task;

    }
}
