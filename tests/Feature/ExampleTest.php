<?php

namespace Tests\Feature;

use Tests\TestCase;

class ExampleTest extends TestCase
{
    // la raiz del sitio lleva siempre al login
    public function test_root_redirects_to_login(): void
    {
        $this->get('/')->assertRedirect('/login');
    }
}
