<?php

namespace Tests\Unit\Http\Requests\Tenant;

use App\Http\Requests\User\IndexRequest;
use PHPUnit\Framework\TestCase;

class IndexRequestTest extends TestCase
{
    public function test_it_should_return_rules()
    {
        $request = new IndexRequest;
        $this->assertEquals([
            'page' => 'integer',
            'per_page' => 'integer',
        ], $request->rules());
    }
}
