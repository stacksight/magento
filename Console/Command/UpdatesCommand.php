<?php
/**
 * Copyright © 2016 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace  Linnovate\Stacksight\Console\Command;

use Linnovate\Stacksight\Model\Stacksight;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Magento\Framework\Module\ModuleListInterface;
use Magento\Framework\Module\ResourceInterface;
use Magento\Setup\Controller\OtherComponentsGrid;
use Magento\Setup\Controller\ComponentGrid;

use Magento\Framework\Composer\ComposerInformation;
use Magento\Framework\Composer\MagentoComposerApplicationFactory;
use Magento\Setup\Model\ObjectManagerProvider;
use Magento\Setup\Model\UpdatePackagesCache;
use Magento\Setup\Model\MarketplaceManager;

use Magento\Framework\Module\PackageInfo;

use Zend\ServiceManager\ServiceLocatorInterface;

class UpdatesCommand extends Command
{

    protected $logger;
    protected $stacksight;
    protected $moduleList;
    protected $moduleResource;
    protected $componentGrid;

    protected $composerInformation;
    protected $magentoComposerApplicationFactory;

    protected $packageInfo;

//    protected $objectManagerProvider;
//    protected $updatePackagesCache;
//    protected $marketplaceManager;

    public function __construct(
        ModuleListInterface $module_list,
        ResourceInterface $module_resource,
        Stacksight $stacksight,
        ComposerInformation $composerInformation,
        MagentoComposerApplicationFactory $magentoComposerApplicationFactory,

        PackageInfo $packageInfo

//        \Magento\Setup\Model\ObjectManagerProvider $objectManagerProvider
//        \Magento\Setup\Model\UpdatePackagesCache $updatePackagesCache
//        \Magento\Setup\Model\MarketplaceManager $marketplaceManager

//        ObjectManagerProvider $objectManagerProvider
//        UpdatePackagesCache $updatePackagesCache
//        MarketplaceManager $marketplaceManager
    )
    {
        $this->moduleList = $module_list;
        $this->moduleResource = $module_resource;
        $this->stacksight = $stacksight;

        $this->composerInformation = $composerInformation;
        $this->magentoComposerApplicationFactory = $magentoComposerApplicationFactory;

        $this->packageInfo = $packageInfo;

//        $this->objectManagerProvider = $objectManagerProvider;
//        $this->updatePackagesCache = $updatePackagesCache;
//        $this->marketplaceManager = $marketplaceManager;

        parent::__construct();
    }

    protected function configure()
    {
        $this->setName('stacksight:updates')
            ->setDescription('Sends updates information to Stacksight');
        parent::configure();
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $components = $this->composerInformation->getInstalledMagentoPackages();
        $allModules = $this->getAllModules();
        $components = array_replace_recursive($components, $allModules);
        foreach ($components as $component) {
            print_r($component);
        }
//        $all_modules = $this->getAllModules();
//        print_r($all_modules);

//        $main_components_grid = new ComponentGrid(
//        var_dump($this->composerInformation);
//            var_dump($this->objectManagerProvider);
//            $this->updatePackagesCache,
//            $this->marketplaceManager
//        );

//        $other_components_grid = new OtherComponentsGrid($this->composerInformation, $this->magentoComposerApplicationFactory);

//        print_r($main_components_grid->componentsAction());

//        print_r($components_grid->componentsAction());
        $output->writeln('<info>List of active modules: Magento_BundleImportExport<info>');
//        var_dump($this->module_resource->getDataVersion('Magento_Tax'));
//        print_r($this->component_grid);
//        foreach ($this->moduleList->getNames() as $moduleName) {
//            $output->writeln('<info>' . $moduleName . '<info>');
//        }
    }

    private function getAllModules()
    {
        $modules = [];
        $allModules = $this->moduleList->getNames();
        foreach ($allModules as $module) {
            $moduleName = $this->packageInfo->getPackageName($module);
            $modules[$moduleName]['name'] = $moduleName;
            $modules[$moduleName]['type'] = \Magento\Framework\Composer\ComposerInformation::MODULE_PACKAGE_TYPE;
            $modules[$moduleName]['version'] = $this->packageInfo->getVersion($module);
        }
        return $modules;
    }
}