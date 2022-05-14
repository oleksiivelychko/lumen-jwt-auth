<?php

namespace Tests;


class ExampleTest extends TestCase
{
    public function test_that_base_endpoint_returns_a_successful_response(): void
    {
        $this->get('/');

        $this->assertEquals(
            $this->app->version(), $this->response->getContent()
        );
    }
}
