<?php

namespace Crudcmd\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use GuzzleHttp\Client;

class DownloadCommand extends Command
{
    protected function configure()
    {
        $this
            ->setName('template:download')
            ->setDescription('Download the template files')
            ->addArgument('framework', InputArgument::REQUIRED, 'The framework name')
            ->addOption('url', null, InputOption::VALUE_REQUIRED, 'set the root url for dowload files');

    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $url = $input->getOption('url');
        $framework = $this->getFramework($input->getArgument('framework'));
        $output->writeln('Downloading files from url: '.$url);
        $files = $this->getFilesFrom($framework);
        $this->download($files, $url, $framework->getTemplatesPath(), $output);
    }

    public function getFramework($framework)
    {
        $framework_class = ucfirst($framework).'Framework';
        $framework_class = "Crudcmd\\Frameworks\\".$framework_class;
        $framework = new $framework_class;
        return $framework;
    }

    private function getFilesFrom($framework)
    {
        $files = $framework->getTemplateFiles();
        return $files;
    }

    /**
     * Download the temporary Zip to the given file.
     *
     * @param  array  $files
     * @param  string  $url
     * @param  OutputInterface  $output
     * @return $this
     */
    private function download(array $files, $url, $dest, OutputInterface $output)
    {
        foreach($files as $file){
            $downloadfile = $url.$file;
            $dest_file = $dest.'/'.$file;
            $output->writeln($downloadfile . " > " . $dest_file);
            $response = (new Client)->get($downloadfile);
            file_put_contents($zipFile, $response->getBody());
        }
        return $this;
    }
}
