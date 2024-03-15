<?php

namespace GregPriday\ClaudeChat;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class ClaudeChatServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package
            ->name('laravel-claude-chat')
            ->hasConfigFile('claude');
    }

    public function packageBooted()
    {
        $this->app->singleton(ClaudeChat::class, function () {
            return new ClaudeChat(config('claude.api_key'), config('claude.endpoint'));
        });
    }
}
