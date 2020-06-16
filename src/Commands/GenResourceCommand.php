<?php

declare(strict_types=1);

/**
 * Fangx's Packages
 *
 * @link     https://github.com/fangx-packages/hyperf-resource
 * @document https://github.com/fangx-packages/hyperf-resource/blob/master/README.md
 * @contact  nfangxu@gmail.com
 * @author   nfangxu
 */

namespace Fangx\Resource\Commands;

use Hyperf\Command\Annotation\Command;
use Hyperf\Devtool\Generator\GeneratorCommand;
use Hyperf\Utils\Str;
use Symfony\Component\Console\Input\InputOption;

/**
 * @Command
 */
class GenResourceCommand extends GeneratorCommand
{
    public function __construct()
    {
        parent::__construct('gen:resource');
    }

    public function configure()
    {
        parent::configure();
        $this->setDescription('create a new resource');
        $this->addOption('collection', 'c', InputOption::VALUE_OPTIONAL, 'Create a resource collection');
    }

    protected function getStub(): string
    {
        return $this->isCollection()
            ? __DIR__ . '/stubs/resource-collection.stub'
            : __DIR__ . '/stubs/resource.stub';
    }

    protected function getDefaultNamespace(): string
    {
        return $this->getConfig()['namespace'] ?? 'App\\Resource';
    }

    protected function isCollection()
    {
        return $this->input->getOption('collection') ||
            Str::endsWith($this->input->getArgument('name'), 'Collection');
    }
}
