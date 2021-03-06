<?php
/**
 * ProcessEight
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade this module to newer
 * versions in the future. If you wish to customize this module for your
 * needs please contact ProcessEight for more information.
 *
 * @copyright   Copyright (c) 2020 ProcessEight
 * @author      ProcessEight
 *
 */

declare(strict_types=1);

namespace ProcessEight\ModuleManager\Command\Module\Create\Frontend;

use ProcessEight\ModuleManager\Command\BaseCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class ViewModelCommand
 *
 * Creates a view model class file
 *
 */
class ViewModelCommand extends BaseCommand
{
    /**
     * @var \ProcessEight\ModuleManager\Model\Pipeline\Frontend\CreateFrontendViewModelCommandPipeline
     */
    private $createFrontendViewModelCommandPipeline;

    /**
     * Constructor.
     *
     * @param \League\Pipeline\Pipeline                                                                  $pipeline
     * @param \Magento\Framework\App\Filesystem\DirectoryList                                            $directoryList
     * @param \ProcessEight\ModuleManager\Model\Pipeline\Frontend\CreateFrontendViewModelCommandPipeline $createFrontendViewModelCommandPipeline
     */
    public function __construct(
        \League\Pipeline\Pipeline $pipeline,
        \Magento\Framework\App\Filesystem\DirectoryList $directoryList,
        \ProcessEight\ModuleManager\Model\Pipeline\Frontend\CreateFrontendViewModelCommandPipeline $createFrontendViewModelCommandPipeline
    ) {
        $this->createFrontendViewModelCommandPipeline = $createFrontendViewModelCommandPipeline;
        parent::__construct($pipeline, $directoryList);
    }

    /**
     * Configure the command
     */
    protected function configure()
    {
        $this->setName("process-eight:module:create:frontend:view-model");
        $this->setDescription("Adds a new frontend PHP View Model class and updates the Layout XML file.");

        $this->pipelineConfig['mode'] = 'configure';

        $this->pipelineConfig = $this->createFrontendViewModelCommandPipeline->processPipeline($this->pipelineConfig);

        parent::configure();
    }

    /**
     * Execute the command
     *
     * @param InputInterface  $input
     * @param OutputInterface $output
     *
     * @return int|null null or 0 if everything went fine, or an error code
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        parent::execute($input, $output);

        $this->pipelineConfig['mode'] = 'process';

        $result = $this->createFrontendViewModelCommandPipeline->processPipeline($this->pipelineConfig);

        foreach ($result['messages'] as $message) {
            $output->writeln($message);
        }

        return $result['is_valid'] ? 0 : 1;
    }
}
