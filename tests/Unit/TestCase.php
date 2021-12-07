<?php

namespace Victoranw\Laradoc\Tests;

use Victoranw\Laradoc\LaradocServiceProvider;

class TestCase extends \Orchestra\Testbench\TestCase
{
    public function setUp(): void
    {
        parent::setUp();
        
        if (!is_dir(base_path('routes'))) {
            mkdir(base_path('routes'));
        }
        
        if (!file_exists(base_path('routes/web.php'))) {
            file_put_contents(
                base_path('routes/web.php'),
                "<?php Route::get('/', function () {return view('welcome');});"
            );
        }
    }
    
    protected function getPackageProviders($app)
    {
        return [
            LaradocServiceProvider::class,
        ];
    }
    
    protected function getEnvironmentSetUp($app)
    {
        // perform environment setup
    }

    public function test_empty() {
        $response = $this->get('/');
        $response->assertStatus(404);
    }
}
