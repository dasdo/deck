<?php

namespace Deck\Command;

use RuntimeException;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Process\Process;

class DeckCommand extends Command
{
    private $packages = ["logs"];
    private $package;
    private $directory;

    protected function configure()
    {
        $this->setName('import')
            ->setDescription('Import libraries to our project')
            ->addArgument(
                'package',
                InputArgument::REQUIRED,
                'Package you want to install'
            )
            // ->addArgument(
            //     'directory',
            //     InputArgument::OPTIONAL,
            //     'Path to your project'
            // )
            ->addOption(
               'all',
               null,
               InputOption::VALUE_NONE,
               'Installation all'
            )
            ->addOption(
               'models',
               null,
               InputOption::VALUE_NONE,
               'Installation models'
            )
            ->addOption(
               'views',
               null,
               InputOption::VALUE_NONE,
               'Installation views'
            )
            ->addOption(
               'controllers',
               null,
               InputOption::VALUE_NONE,
               'Installation controllers'
            )
            ->addOption(
               'library',
               null,
               InputOption::VALUE_NONE,
               'Installation libraries'
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->directory = getcwd();
        $this->package = strtolower($input->getArgument('package'));
        if(!in_array($this->package, $this->packages))
            throw new RuntimeException('The package does not exist!');

        $output->writeln('<info>Crafting application...</info>');

        if(!in_array(1, $input->getOptions()) || $input->getOption("all"))
            $this->all($input, $output);
        else
        {
            if($input->getOption("models"))
                $this->models($input, $output);
            if($input->getOption("views"))
                $this->views($input, $output);
            if($input->getOption("controllers"))
                $this->controllers($input, $output);
            if($input->getOption("libraries"))
                $this->library($input, $output);
        }

        $output->writeln("All Done");
    }

    protected function all(InputInterface $input, OutputInterface $output)
    {
        $this->models($input, $output);
        $this->views($input, $output);
        $this->controllers($input, $output);
        $this->library($input, $output);
    }

    protected function models(InputInterface $input, OutputInterface $output)
    {
        $output->writeln('<info>Crafting models...</info>');
        $this->move("models");
    }

    protected function views(InputInterface $input, OutputInterface $output)
    {
         $output->writeln('<info>Crafting views...</info>');
         $this->move("views");
    }

    protected function controllers(InputInterface $input, OutputInterface $output)
    {
         $output->writeln('<info>Crafting controllers...</info>');
         $this->move("controllers");
    }

    protected function library(InputInterface $input, OutputInterface $output)
    {
         $output->writeln('<info>Crafting libraries...</info>');
         $this->move("library");
    }

    protected function move($folder)
    {
        $src = __DIR__."/../packages/{$folder}/".$this->package."/";
        if($folder == "views")
            $dst = $this->directory."/app/{$folder}/{$this->package}/";
        else
            $dst = $this->directory."/app/{$folder}/";
       
        if(!is_dir($dst))
            mkdir($dst, 0777, true);
       
        $files = glob("{$src}*.*");
        
        foreach($files as $file)
        {
            $file_to_go = str_replace($src,$dst,$file);
            if(!copy($file, $file_to_go))
                throw new RuntimeException("Crafting {$folder} Error");
        }
    }
}