<?php

declare(strict_types=1);

namespace App\Repositories\User;

use App\Models\Task;
use Exception;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Enumerable;
use LogicException;

/**
 * User's tasks repository
 */
interface TaskRepositoryInterface
{
    /**
     * Get user's task by id
     *
     * @param int $userId
     * @param int $id
     * @param array $columns
     * @return Task
     * @throws ModelNotFoundException
     */
    public function findById(int $userId, int $id, array $columns = ['*']): Task;

    /**
     * Get all user's tasks for provided user id
     *
     * @param int $userId
     * @return Enumerable
     */
    public function all(int $userId): Enumerable;

    /**
     * Search user's tasks. Returns Builder for searching, ordering, etc.
     * todo implement searchCriteria and use allByUserId method
     *
     * @param int $userId
     * @return Builder
     */
    public function search(int $userId): Builder;

    /**
     * Create or update task
     *
     * @param Task $task
     * @return bool
     * @throws Exception
     */
    public function save(Task $task): bool;

    /**
     * Delete user's task by id
     *
     * @param int $userId
     * @param int $id
     * @return void
     * @throws ModelNotFoundException when no such record
     * @throws LogicException when delete error
     */
    public function deleteById(int $userId, int $id): void;
}
