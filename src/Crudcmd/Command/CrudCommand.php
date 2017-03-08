<?php

namespace Crudcmd\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

class CrudCommand extends Command
{
    protected function configure()
    {
        $this
            ->setName('crud:create')
            ->setDescription('Create a crud structure')
            ->setHelp('This command allows you create a crud structure for your app')
            ->addArgument('framework', InputArgument::REQUIRED, 'The framework name')
            ->addArgument('model', InputArgument::REQUIRED, 'The model name')
            ->addOption('templates', null, InputOption::VALUE_OPTIONAL, 'set templates path')
            ->addOption('schema', null, InputOption::VALUE_OPTIONAL, 'set schema for model');

    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln([
            'Crud Creator',
            '============',
            '',
        ]);

        $framework_class = ucfirst($input->getArgument('framework')).'Framework';
        $framework_class = "Crudcmd\\Frameworks\\".$framework_class;
        $framework = new $framework_class;
        $model = $input->getArgument('model');
        $template_root = $this->getTemplateRoot($framework, $input->getOption('templates'));

        $output->writeln('Framework: ' . $framework);
        $output->writeln('Model: ' . $model);
        $output->writeln('Creating files for ' . $model);
        $output->writeln('Template path ' . $model);
        $output->writeln('===============================');

        $this->createFiles($model, $framework, $output, $template_root);
    }

    private function getTemplateRoot($framework, $template_root)
    {
        if($template_root == null){
            $template_root = $framework->getTemplatesPath();
        }
        return $template_root;
    }

    private function createFiles($model, $framework, $output, $template_root)
    {
        $files = $framework->getFilesToCreate($model);
        foreach($files as $file){
            $this->writeFile($file, $model, $output, $template_root);
        }
    }

    private function writeFile($filepath, $model, $output, $template_root)
    {
        $output->writeln('Creating file: '.$filepath);
        $template_path = str_replace(getcwd().'/', '', $filepath);
        $template_path = str_ireplace($model, 'Model', $template_path);
        $template_path = $template_root.'/'.$template_path.'.tpl';
        $output->writeln('get content from: '.$template_path);
        $content = $this->readFromTemplate($template_path, $model);
        $output->writeln($content);
        $now = date('Y_m_d_his');
        $filepath = str_replace('Y_m_d_his', $now, $filepath);
        if($this->createDir($filepath)){
            $handler = fopen($filepath, 'w');
            fwrite($handler, $content);
            fclose($handler);
        }
    }

    private function createDir($filepath)
    {
        $dir = dirname($filepath);
        if(!is_dir($dir)){
            mkdir($dir, 0777, true);
        }
        return is_dir($dir);
    }

    private function readFromTemplate($template_path, $model)
    {
        $path = $template_path;
        $handler = fopen($path, 'r');
        $content = fread($handler, filesize($path));
        $content = str_replace('[Model]', $model, $content);
        $content = str_replace('[tablename]', strtolower($model), $content);
        fclose($handler);
        return $content;
    }
}
