<?php

declare(strict_types=1);

namespace Tempest\Console\Commands;

use Tempest\AppConfig;
use Tempest\Console\Console;
use Tempest\Console\ConsoleCommand;
use Tempest\Container\Container;
use Tempest\Discovery\Discovery;
use Tempest\Kernel;

final readonly class DiscoveryClearCommand
{
    public function __construct(
        private Container $container,
        private Kernel $kernel,
        private Console $console,
        private AppConfig $appConfig,
    ) {
    }

    #[ConsoleCommand(
        name: 'discovery:clear',
        description: 'Clear all cached discovery files',
    )]
    public function __invoke(): void
    {
        foreach ($this->appConfig->discoveryClasses as $discoveryClass) {
            /** @var Discovery $discovery */
            $discovery = $this->container->get($discoveryClass);

            $discovery->destroyCache();

            $this->console->success(implode('', [
                "<em>{$discoveryClass}</em>",
                ' cleared successful',
            ]));
        }

        $this->console->writeln('Done');
    }
}
