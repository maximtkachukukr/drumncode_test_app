<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\TaskResource;
use App\Http\Services\User\Task\SetDoneStatus;
use App\OpenApi\Responses\ValidationErrorResponse;
use App\OpenApi\Responses\SuccessResponse;
use Exception;
use Illuminate\Http\JsonResponse;
use Vyuldashev\LaravelOpenApi\Attributes as OpenApi;

#[OpenApi\PathItem]
class TaskStatusController extends Controller
{
    public function __construct(private readonly SetDoneStatus $setDoneStatus)
    {
    }

    /**
     * Set task as done
     * @param int $id
     * @return JsonResponse
     */
    #[OpenApi\Operation]
    #[OpenApi\Response(factory: ValidationErrorResponse::class, statusCode: 200)]
    #[OpenApi\Response(factory: SuccessResponse::class, statusCode: 200)]
    public function markAsDone(int $id): JsonResponse
    {
        try {
            $task = $this->setDoneStatus->execute($id, request()->user()->getId());
        } catch (Exception $exception) {
            return response()->json([
                'success' => false,
                'message' => $exception->getMessage(),
            ]);
        }

        return response()->json([
            'success' => true,
            'data' => new TaskResource($task)
        ]);
    }
}
