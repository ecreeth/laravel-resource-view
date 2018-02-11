<?php

namespace eCreeth\LaravelResourceView;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;

class LaravelResourceView extends Command
{
    /**
     * $name Name of the directory
     * @var string
     */
    protected $name;

    /**
     * $resource Name of the resource
     * @var string
     */
    protected $resource;

    /**
     * $newDirectory Name of the new directory
     * @var string
     */
    protected $newDirectory;

    /**
     * $files Instance of the Filesystem class
     * @var Object
     */
    protected $files;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(Filesystem $files)
    {
        parent::__construct();

        $this->files = $files;
    }

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:resource-view { name : Create the structure of views of the resource } 
                                                 { --m|model : Create the model for the resource }
                                                 { --r|resource : Create a controller for the resource }
                                                 { --p|path : Add the resource routes }';
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generates the structure of views of a resource';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->name = str_plural(strtolower($this->argument('name'))); 

        $this->resource = studly_case(str_singular(strtolower($this->argument('name')))); 

        $this->makeDirectory();

        $this->makeResourcesViews();

        if ($this->option('model')) 
        {
            $this->makeModel();
        }

        if ($this->option('resource')) 
        {
            $this->makeController();
        }

        if ($this->option('path')) 
        {
            $this->files->append(base_path('routes/web.php'), ["\n\n" , "// Path resource for " . $this->name . "\n", 'Route::resource(\''.$this->name.'\', \''.$this->resource.'Controller\');']);

            $this->info('The route resource has been added to the routes file.');
        }
    }

    /**
     *  Check if the directory exists and then create it
     * @return string 
     */
    protected function makeDirectory()
    {
        if (!$this->files->isDirectory(resource_path('views/' .  $this->name))) 
        {
             $this->files->makeDirectory(resource_path('views/' . $this->name));

             $this->info('Directory created successfully.');
        }
        else{

            if ($this->confirm('The ' . $this->name . ' directory exists. Do you want to replace it?'))
            {
                $this->files->deleteDirectory(resource_path('views/' . $this->name, true));

                $this->files->makeDirectory(resource_path('views/' . $this->name));

                 $this->info('Directory created successfully.');
            }
        }
    }

    /**
     *  Create views for the resource
     * @return string 
     */
    protected function makeResourcesViews()
    {
        $this->files->copy(__DIR__ . '\index.blade.php', resource_path('views\\' . $this->name . '\index.blade.php'));
        $this->files->copy(__DIR__ . '\index.blade.php', resource_path('views\\' . $this->name . '\create.blade.php'));
        $this->files->copy(__DIR__ . '\index.blade.php', resource_path('views\\' . $this->name . '\show.blade.php'));
        $this->files->copy(__DIR__ . '\index.blade.php', resource_path('views\\' . $this->name . '\edit.blade.php'));
    }

    /**
     *  Create the controller
     * @return string 
     */
    protected function makeController() 
    {    

        if (!$this->files->exists(app_path('Http/Controllers/' . $this->resource . 'Controller.php'))) 
        {
            $this->newDirectory = $this->choice('How do you want your controller to be called?', [$this->resource . 'Controller', str_plural($this->resource) . 'Controller'], 0);

            if ($this->option('model')) 
            {
                $this->call('make:controller', ['name' => $this->newDirectory, '-r' => true, '-m' => $this->resource]);  
            }
            else{
                $this->call('make:controller', ['name' => $this->newDirectory, '-r' => true]);  
            }
          
        }  
    }

    /**
     *  Create the model
     * @return string 
     */
    protected function makeModel()
    {
        if (!$this->files->exists(app_path($this->resource . '.php'))) 
        {
            $this->call('make:model', ['name' => $this->resource]);
        }
    }

}
