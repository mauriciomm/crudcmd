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
         $files = scandir($folder);
         foreach($files as $file){
             $src = $folder.'/'.$file;
             $dest = $template_path.'/'.$file;
             if(file_exists($src)){
                 if(copy($src, $dest)){
                     $output->writeln("Copied $src > $dest");
                 }else{
                     $output->writeln("Problem to copy $src");
                 }
             }else{
                 $output->writeln("File $src not exists");
             }
         }
         return $this;
    }
}
