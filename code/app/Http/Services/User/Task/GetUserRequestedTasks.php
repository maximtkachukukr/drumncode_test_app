<?php

declare(strict_types=1);

namespace App\Http\Services\User\Task;

use App\Http\Requests\TaskSearchRequest;
use App\Repositories\User\TaskRepositoryInterface;
use Illuminate\Support\Enumerable;
use Illuminate\Support\Str;

class GetUserRequestedTasks
{
    public function __construct(private readonly TaskRepositoryInterface $taskRepository)
    {
    }

    /**
     * Search user's tasks by requested filters and sorts
     * todo implement Laravel Scout here to avoid searching in mysql
     *
     * @param TaskSearchRequest $request
     * @return Enumerable
     */
    public function execute(TaskSearchRequest $request): Enumerable
    {
        $tasks = $this->taskRepository->search($request->user()->getId());

        if ($request->filled('status')) {
            $tasks->where('status', '=', $request->get('status'));
        }
        if ($request->filled('priority')) {
            $tasks->where('priority', '=', $request->get('priority'));
        }
        if ($request->filled('title')) {
            $tasks->where('title', 'LIKE', '%' . $request->get('title') . '%');
        }
        if ($request->filled('description')) {
            $tasks->where('description', 'LIKE', '%' . $request->get('description') . '%');
        }
        if ($request->filled('sorting')) {
            foreach ($request->get('sorting') as $sortingItem) {
                $tasks->orderBy(Str::snake($sortingItem['column']), $sortingItem['direction']);
            }
        }

        return $tasks->get();
    }
}
