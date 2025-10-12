<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class MakeServiceCommand extends Command
{
    protected $signature = 'make:service {name : Name of the service class}';
    protected $description = 'Create a new service class in app/Services';

    public function handle()
    {
        $name = $this->argument('name');
        $directory = app_path('Services');
        $path = $directory . '/' . $name . '.php';

        if (!File::exists($directory)) {
            File::makeDirectory($directory, 0755, true);
        }

        if (File::exists($path)) {
            $this->error("Service already exists at: $path");
            return 1;
        }

        $stub = <<<PHP
<?php

namespace App\Services;

class {$name}
{
    public function __construct()
    {
        // initialize service
    }
}

PHP;

        File::put($path, $stub);

        $this->info("✅ Service created successfully: app/Services/{$name}.php");
        return 0;
    }
}
