<?php

declare(strict_types=1);

namespace App\OpenApi\Parameters;

use GoldSpecDigital\ObjectOrientedOAS\Objects\Parameter;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Schema;
use Vyuldashev\LaravelOpenApi\Factories\ParametersFactory;

class ListTasksParameters extends ParametersFactory
{
    /**
     * @return Parameter[]
     */
    public function build(): array
    {
        return [
            Parameter::query()
                ->name('status')
                ->description('Search by task status')
                ->required(false)
                ->schema(Schema::string()),
            Parameter::query()
                ->name('priority')
                ->description('Search by task priority')
                ->required(false)
                ->schema(Schema::integer()),
            Parameter::query()
                ->name('title')
                ->description('Search by task title. Fulltext searching')
                ->required(false)
                ->schema(Schema::integer()),
            Parameter::query()
                ->name('description')
                ->description('Search by task description. Fulltext searching')
                ->required(false)
                ->schema(Schema::integer()),
            Parameter::query()
                ->name('sorting')
                ->description('Sorting parameter')
                ->required(false)
                ->schema(Schema::array()->items(Schema::array()->items(Schema::string()))),
            Parameter::query()
                ->name('sorting.*.column')
                ->description('Column name for ordering')
                ->required(false)
                ->schema(Schema::string()),
            Parameter::query()
                ->name('sorting.*.direction')
                ->description('Column direction for ordering - desc or asc')
                ->required(false)
                ->schema(Schema::string())
        ];
    }
}
