<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\TaskRequest;
use App\Http\Requests\TaskSearchRequest;
use App\Http\Resources\TaskCollection;
use App\Http\Resources\TaskResource;
use App\Http\Services\User\Task\CreateRequestedTask;
use App\Http\Services\User\Task\GetUserRequestedTasks;
use App\Http\Services\User\Task\UpdateRequestedTask;
use App\OpenApi\Parameters\ListTasksParameters;
use App\OpenApi\Parameters\NewTaskParameters;
use App\OpenApi\Parameters\UpdateTaskParameters;
use App\OpenApi\Responses\ValidationErrorResponse;
use App\OpenApi\Responses\InternalErrorResponse;
use App\OpenApi\Responses\SuccessResponse;
use App\Repositories\User\TaskRepositoryInterface;
use Exception;
use Illuminate\Http\JsonResponse;
use Vyuldashev\LaravelOpenApi\Attributes as OpenApi;

#[OpenApi\PathItem]
class TaskController extends Controller
{
    public function __construct(
        private readonly TaskRepositoryInterface $taskRepository,
        private readonly GetUserRequestedTasks $getUserRequestedTasks,
        private readonly CreateRequestedTask $createRequestedTask,
        private readonly UpdateRequestedTask $updateRequestedTask,

    ) {
    }

    /**
     * Display a listing of the tasks.
     *
     * @param TaskSearchRequest $request
     * @return TaskCollection
     */
    #[OpenApi\Operation]
    #[OpenApi\Parameters(factory: ListTasksParameters::class)]
    #[OpenApi\Response(factory: SuccessResponse::class, statusCode: 200)]
    #[OpenApi\Response(factory: ValidationErrorResponse::class, statusCode: 401)]
    public function index(TaskSearchRequest $request): TaskCollection
    {
        return new TaskCollection($this->getUserRequestedTasks->execute($request));
    }

    /**
     * Store a newly created task in storage.
     *
     * @param TaskRequest $request
     * @return JsonResponse
     */
    #[OpenApi\Operation]
    #[OpenApi\Parameters(factory: NewTaskParameters::class)]
    #[OpenApi\Response(factory: SuccessResponse::class, statusCode: 200)]
    #[OpenApi\Response(factory: InternalErrorResponse::class, statusCode: 500)]
    #[OpenApi\Response(factory: ValidationErrorResponse::class, statusCode: 401)]
    public function store(TaskRequest $request): JsonResponse
    {
        try {
            $task = $this->createRequestedTask->execute($request);
        } catch (Exception $exception) {
            return response()->json([
                'success' => false,
                'message' => $exception->getMessage(),
            ], 500);
        }

        return response()->json([
            'success' => true,
            'data' => new TaskResource($task)
        ]);
    }

    /**
     * Update the specified task in storage.
     *
     * @param TaskRequest $request
     * @param int $id
     * @return JsonResponse
     */
    #[OpenApi\Operation]
    #[OpenApi\Parameters(factory: UpdateTaskParameters::class)]
    #[OpenApi\Response(factory: SuccessResponse::class, statusCode: 200)]
    #[OpenApi\Response(factory: InternalErrorResponse::class, statusCode: 500)]
    #[OpenApi\Response(factory: ValidationErrorResponse::class, statusCode: 401)]
    public function update(TaskRequest $request, int $id): JsonResponse
    {
        try {
            $task = $this->updateRequestedTask->execute($id, $request);
        } catch (Exception $exception) {
            return response()->json([
                'success' => false,
                'message' => $exception->getMessage(),
            ], 500);
        }

        return response()->json([
            'success' => true,
            'data' => new TaskResource($task)
        ]);
    }

    /**
     * Remove the specified task from storage.
     *
     * @param int $id
     * @return JsonResponse
     */
    #[OpenApi\Operation]
    #[OpenApi\Response(factory: ValidationErrorResponse::class, statusCode: 200)]
    #[OpenApi\Response(factory: SuccessResponse::class, statusCode: 200)]
    #[OpenApi\Response(factory: InternalErrorResponse::class, statusCode: 500)]
    public function destroy(int $id): JsonResponse
    {
        try {
            $this->taskRepository->deleteById($this->getCurrentUserId(), $id);
        } catch (Exception $exception) {
            return response()->json([
                'success' => false,
                'message' => $exception->getMessage(),
            ], 500);
        }

        return response()->json([
            'success' => true
        ]);
    }

    /**
     * Get current logged in user id
     *
     * @return int
     */
    private function getCurrentUserId(): int
    {
        return request()->user()->getId();
    }
}
