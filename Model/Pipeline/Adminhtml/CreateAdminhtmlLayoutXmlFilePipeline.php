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

namespace ProcessEight\ModuleManager\Model\Pipeline\Adminhtml;

use ProcessEight\ModuleManager\Model\Pipeline\BasePipeline;

/**
 * Class CreateAdminhtmlLayoutXmlFilePipeline
 *
 * This pipeline:
 * - Validates the Vendor and Module names
 * - Calls the CreateFolderPipeline
 * - Calls the CreateAdminhtmlLayoutXmlFilePipeline
 *
 * @package ProcessEight\ModuleManager\Model\Pipeline
 */
class CreateAdminhtmlLayoutXmlFilePipeline extends BasePipeline
{
    /**
     * @var \ProcessEight\ModuleManager\Model\Pipeline\ValidateModuleNamePipeline
     */
    private $validateModuleNamePipeline;

    /**
     * @var \ProcessEight\ModuleManager\Model\Stage\Adminhtml\CreateAdminhtmlLayoutFolderStage
     */
    private $createAdminhtmlLayoutFolderStage;

    /**
     * @var \ProcessEight\ModuleManager\Model\Stage\Adminhtml\CreateAdminhtmlLayoutXmlFileStage
     */
    private $createAdminhtmlLayoutXmlFileStage;

    /**
     * CreateFolderPipeline constructor.
     *
     * @param \League\Pipeline\Pipeline                                                           $pipeline
     * @param \ProcessEight\ModuleManager\Model\Pipeline\ValidateModuleNamePipeline               $validateModuleNamePipeline
     * @param \ProcessEight\ModuleManager\Model\Stage\Adminhtml\CreateAdminhtmlLayoutFolderStage  $createAdminhtmlLayoutFolderStage
     * @param \ProcessEight\ModuleManager\Model\Stage\Adminhtml\CreateAdminhtmlLayoutXmlFileStage $createAdminhtmlLayoutXmlFileStage
     */
    public function __construct(
        \League\Pipeline\Pipeline $pipeline,
        \ProcessEight\ModuleManager\Model\Pipeline\ValidateModuleNamePipeline $validateModuleNamePipeline,
        \ProcessEight\ModuleManager\Model\Stage\Adminhtml\CreateAdminhtmlLayoutFolderStage $createAdminhtmlLayoutFolderStage,
        \ProcessEight\ModuleManager\Model\Stage\Adminhtml\CreateAdminhtmlLayoutXmlFileStage $createAdminhtmlLayoutXmlFileStage
    ) {
        parent::__construct($pipeline);
        $this->validateModuleNamePipeline        = $validateModuleNamePipeline;
        $this->createAdminhtmlLayoutFolderStage  = $createAdminhtmlLayoutFolderStage;
        $this->createAdminhtmlLayoutXmlFileStage = $createAdminhtmlLayoutXmlFileStage;
    }

    /**
     * Define the stages in this pipeline, then execute it
     *
     * @param mixed[] $payload Values which need to be passed from stage to stage
     *
     * @return mixed[]
     */
    public function processPipeline(array $payload) : array
    {
        // Add the Pipelines/Stages we need for this command
        $pipeline = $this->pipeline
            // Validate the module name
            ->pipe($this->validateModuleNamePipeline)
            // Create the folder
            ->pipe($this->createAdminhtmlLayoutFolderStage)
            // Create the di.xml
            ->pipe($this->createAdminhtmlLayoutXmlFileStage)
        ;

        // Pass payload onto next Stage/Pipeline
        return $pipeline->process($payload);
    }
}
