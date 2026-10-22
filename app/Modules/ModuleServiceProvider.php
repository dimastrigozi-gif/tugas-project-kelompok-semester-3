<?php

namespace App\Modules;

use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;
use ReflectionClass;

/**
 * Basis provider modul (modular monolith).
 * Setiap modul punya file fiturnya sendiri di folder modul,
 * dan provider inilah yang merakitnya:
 *   - routes/*.php       -> dimuat otomatis
 *   - resources/views    -> view('alias::...')
 *   - resources/views/livewire -> <livewire:alias::nama-komponen />
 */
abstract class ModuleServiceProvider extends ServiceProvider
{
    /**
     * Alias modul untuk namespace view & Livewire.
     */
    abstract protected function moduleAlias(): string;

    public function boot(): void
    {
        $path = $this->modulePath();

        // Register view namespace
        $this->loadViewsFrom($path.'/resources/views', $this->moduleAlias());

        // Register Livewire namespace
        Livewire::addNamespace(
            namespace: $this->moduleAlias(),
            viewPath: $path.'/resources/views/livewire',
        );

        // Load semua file route di folder routes/
        foreach (glob($path.'/routes/*.php') ?: [] as $routeFile) {
            $this->loadRoutesFrom($routeFile);
        }
    }

    /**
     * Folder modul = folder tempat kelas provider turunan berada.
     */
    protected function modulePath(): string
    {
        return dirname((new ReflectionClass($this))->getFileName());
    }
}
