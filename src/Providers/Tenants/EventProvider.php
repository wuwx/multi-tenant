<?php

/*
 * This file is part of the hyn/multi-tenant package.
 *
 * (c) Daniël Klabbers <daniel@klabbers.email>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @see https://github.com/hyn/multi-tenant
 *
 */

namespace Hyn\Tenancy\Providers\Tenants;

use Hyn\Tenancy\Generators;
use Hyn\Tenancy\Listeners;
use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Support\ServiceProvider;

class EventProvider extends ServiceProvider
{
    /**
     * @var array
     */
    protected $subscribe = [
        // Manages databases for tenants.
        Generators\Webserver\Database\DatabaseGenerator::class,
        // Manages the connections for the tenants.
        Listeners\Database\ConnectsTenants::class,
        // Runs migrations for new tenants.
        Listeners\Database\MigratesTenants::class,
        // Manages the directories for the tenants.
        Generators\Filesystem\DirectoryGenerator::class,
        // Sets the uuid value on a website based on tenancy configuration.
        Listeners\WebsiteUuidGeneration::class,
    ];

    public function boot()
    {
        foreach ($this->subscribe as $listener) {
            $this->app[Dispatcher::class]->subscribe($listener);
        }
    }

    public function register()
    {
        // ..
    }
}
