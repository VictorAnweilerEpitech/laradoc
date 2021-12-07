<?php

namespace Victoranw\Laradoc\Commands;

use Illuminate\Console\Command;
use Victoranw\Laradoc\Models\DocumentationPermission;

class AddUserCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'laradoc:add {user} {--admin}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Add user permissions on documentation';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $userEmail = $this->argument('user');

        $guardName = config('laradoc.auth.guard');
        $user = null;
        if ($guardName) {
            if ($providerName = config('auth.guards')[$guardName]['provider']) {
                if ($modelPath = config('auth.providers')[$providerName]['model']) {
                    $model = app($modelPath);
                    $user = $model::where(config('laradoc.auth.loginColumn'), $userEmail)->first();
                }
            }
        }

        if (!$user) {
            $this->info('user not found');
            return 84;
        }

        $userAlreadyAccept = DocumentationPermission::where('user_id', $user->id)->first();

        if (!$userAlreadyAccept) {
            $authorisation = new DocumentationPermission;
            $authorisation->user_id = $user->id;
            $authorisation->admin = $this->option('admin');
            $authorisation->save();
    
            $this->info('user accepted');
        } else {
            $this->info('user already accepted');
        }
    }
}
