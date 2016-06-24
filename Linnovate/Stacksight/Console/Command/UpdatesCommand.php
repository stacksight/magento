<?php

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
use Magento\Composer\InfoCommand;
use Magento\Backend\Model\UrlInterface;

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

    protected $infoCommand;

    protected $url;

    public function __construct(
        ModuleListInterface $module_list,
        ResourceInterface $module_resource,
        Stacksight $stacksight,
        ComposerInformation $composerInformation,
        MagentoComposerApplicationFactory $magentoComposerApplicationFactory,
        PackageInfo $packageInfo,
        Stacksight $stacksight,
        UrlInterface $url
    )
    {
        $this->moduleList = $module_list;
        $this->moduleResource = $module_resource;
        $this->stacksight = $stacksight->getClient();

        $this->composerInformation = $composerInformation;
        $this->magentoComposerApplicationFactory = $magentoComposerApplicationFactory;

        $this->packageInfo = $packageInfo;

        $this->infoCommand = $magentoComposerApplicationFactory->createInfoCommand();

        $this->infoCommand = $magentoComposerApplicationFactory->createInfoCommand();

        $this->url = $url;

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

        $updates = array();
        foreach ($components as $component) {
            $packageInfo = $this->infoCommand->run($component['name']);
            if(empty($packageInfo))
                continue;
            $type = explode('-', $packageInfo['type']);
            $status = 5;
            if($type == 'framework'){
                $status = 1;
            }
            $updates[] = array(
                'title' => $packageInfo['name'],
                'current_version' => $packageInfo[InfoCommand::CURRENT_VERSION],
                'latest_version' => (isset($packageInfo[InfoCommand::NEW_VERSIONS]) && !empty($packageInfo[InfoCommand::NEW_VERSIONS])) ? $packageInfo[InfoCommand::NEW_VERSIONS][0] : $packageInfo[InfoCommand::CURRENT_VERSION],
                'type' => $type[1],
                'status' => $status, // 1 means security update (recommended)
                'link' => '',
                'release_link' => '',
                'download_link' => '',
                'update_link' => '',
            );
        }
        $this->stacksight->sendUpdates($updates);

        $output->writeln('<info>Updates sents to the Stacksight...<info>');

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