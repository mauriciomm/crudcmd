<?php

namespace Crudcmd\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use GuzzleHttp\Client;

class CopyCommand extends Command
{
    protected function configure()
    {
        $this
            ->setName('template:copy')
            ->setDescription('Copy the template files')
            ->addArgument('framework', InputArgument::REQUIRED, 'The framework name');

    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $framework = $this->getFramework($input->getArgument('framework'));
        $output->writeln('Coping files to: '.$framework->getTemplatesPath());
        $this->copy($framework->getTemplatesPath(), $output);
    }

    public function getFramework($framework)
    {
        $framework_class = ucfirst($framework).'Framework';
        $framework_class = "Crudcmd\\Frameworks\\".$framework_class;
        $framework = new $framework_class;
        return $framework;
    }

    private function copy($template_path, $output)
    {
         $folder = getcwd().'/vendor/gwmoura/crudcmd/resources/templates';
         if(!is_dir($folder)){
             $output->writeln("Dir not exists");
             return false;
         }
         $files = $this->loadFilesFrom($folder);
         foreach($files as $file){
            $dest = str_replace($folder.'/','', $file);
            $dest = './'.$dest;
            if(copy($file, $dest)){
                $output->writeln("Copied $file > $dest");
            }else{
                $output->writeln("Problem to copy $src");
            }
         }
         return $this;
    }

    private function loadFilesFrom($dir)
    {
        $allFiles = [];
        $files = scandir($dir);
        foreach($files as $file){
            $src = $dir.'/'.$file;
            if(!is_dir($src)){
                $allFiles[] = $src;
            }else if($file != "." && $file != ".."){
                $f = $this->loadFilesFrom($src);
                $allFiles = array_merge($allFiles, $f);
            }
        }
        return $allFiles;
    }
}
