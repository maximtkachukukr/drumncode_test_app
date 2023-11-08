<?php

namespace App\OpenApi\Parameters;

use App\Models\TaskStatus;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Parameter;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Schema;
use Vyuldashev\LaravelOpenApi\Factories\ParametersFactory;

class NewTaskParameters extends ParametersFactory
{
    /**
     * @return Parameter[]
     */
    public function build(): array
    {
        $statusString = implode(', ', array_column(TaskStatus::cases(), 'value'));
        return [
            Parameter::query()
                ->name('title')
                ->description('task title')
                ->required(true)
                ->schema(Schema::string()),
            Parameter::query()
                ->name('status')
                ->description('task status. Must me in ' . $statusString)
                ->required(true)
                ->schema(Schema::string()),
            Parameter::query()
                ->name('priority')
                ->description('task priority. Must me from 1 to 5')
                ->required(true)
                ->schema(Schema::string()),
            Parameter::query()
                ->name('description')
                ->description('task description')
                ->required(false)
                ->schema(Schema::string()),
        ];
    }
}
