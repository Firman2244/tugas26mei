<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;

class FieldSearchTest extends TestCase
{
    public function test_search_field_by_type_using_dummy_data()
    {

        $fields = [
            (object)[
                'name' => 'Lapangan A',
                'type' => 'Sintetis'
            ],
            (object)[
                'name' => 'Lapangan B',
                'type' => 'Matras'
            ],
            (object)[
                'name' => 'Lapangan C',
                'type' => 'Sintetis'
            ],
        ];

        $keyword = 'Sintetis';

        $results = array_filter($fields, function ($field) use ($keyword) {
            return $field->type === $keyword;
        });

        $this->assertCount(2, $results);

        foreach ($results as $field) {
            $this->assertEquals('Sintetis', $field->type);
        }
    }
}
