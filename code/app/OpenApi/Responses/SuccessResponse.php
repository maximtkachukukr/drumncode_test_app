<?php

declare(strict_types=1);

namespace App\OpenApi\Responses;

use App\Models\Task;
use GoldSpecDigital\ObjectOrientedOAS\Objects\MediaType;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Response;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Schema;
use Vyuldashev\LaravelOpenApi\Factories\ResponseFactory;

class SuccessResponse extends ResponseFactory
{
    public function build(): Response
    {
        $response = Schema::object()->properties(
            Schema::boolean('success')->example('Result status.'),
            Schema::array('data')->items(Schema::object(Task::class))->example('The given task data'),
        );

        return Response::create('Success')
            ->description('Successful response')
            ->content(
                MediaType::json()->schema($response)
            );
    }
}
