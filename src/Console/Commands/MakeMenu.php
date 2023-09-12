<?php

namespace CyberPunkCodes\MenuHelper\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Str;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

class MakeMenu extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'make:menu';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate a new menuhelper menu';

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:menu {name} {--stub= : Specify a custom stub to use for generation}';

    /**
     * The console command help text.
     *
     * @var string
     */
    //protected $help;

    /**
     * The filesystem instance.
     *
     * @var \Illuminate\Filesystem\Filesystem
     */
    protected $files;

    protected $packagePath;


    public function __construct(Filesystem $files)
    {
        parent::__construct();

        $this->files = $files;
        $this->packagePath = dirname(__DIR__, 3);
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $stub = $this->option('stub') ?? 'tailwind-advanced';
        $whitelist = ['tailwind-basic', 'bootstrap-basic', 'tailwind-advanced', 'bootstrap-advanced'];

        if ( ! in_array($stub, $whitelist) ) {
            $this->error("Error: Invalid stub - valid stubs are '" . implode ( "', '", $whitelist ) . "'");
            return 0;
        }

        $directory = $this->packagePath . '/views/' . $stub;

        $name = Str::slug(Str::lower($this->argument('name')));

        $destination = resource_path('views/vendor/menuhelper/' . $name);

        if ( $this->files->exists($destination) ) {
            $this->error("Error: MenuHelper view directory '" . $name . "' already exists");
            return 0;
        }

        if ( ! $this->files->copyDirectory($directory, $destination) ) {
            $this->error("Error: Failed to copy the '{$stub}' views to your views directory");
            return 0;
        }

        $this->info("Success: The '{$stub}' views were copied to 'resources/views/vendor/menuhelper'");
        return 1;
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return [
            ['name', InputArgument::REQUIRED, 'The name of the menu'],
        ];
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return [
            ['force', null, InputOption::VALUE_NONE, 'Create the menu even if it already exists'],
            ['stub', null, InputOption::VALUE_REQUIRED, 'Specify a custom stub to use for generation'],
        ];
    }
}
