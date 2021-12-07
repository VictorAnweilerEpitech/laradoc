<?php

namespace Victoranw\Laradoc\Tests;

use Victoranw\Laradoc\LaradocServiceProvider;

class TestStructure extends \Orchestra\Testbench\TestCase
{
    protected $statusCode = 404;

    public function setUp(): void
    {
        parent::setUp();
    }

    public function test_get_css()
    {
        $response = $this->get('/styles/template.css');
        $response->assertStatus($this->statusCode);
    }

    public function test_get_js()
    {
        $response = $this->get('/scripts/template.js');
        $response->assertStatus($this->statusCode);
    }
    
    public function test_admin_structure_view()
    {
        $response = $this->get('/admin/structure');
        $response->assertStatus($this->statusCode);
    }

    public function test_admin_member_view()
    {
        $response = $this->get('/admin/members');
        $response->assertStatus($this->statusCode);
    }

    public function test_login_view()
    {
        $response = $this->get('/login');
        $response->assertStatus($this->statusCode);
    }

    public function test_page_view()
    {
        $response = $this->get('/page/1');
        $response->assertStatus($this->statusCode);
    }
}
