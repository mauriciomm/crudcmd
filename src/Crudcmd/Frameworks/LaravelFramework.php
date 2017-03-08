<?php

namespace Crudcmd\Frameworks;

use Crudcmd\Frameworks\FrameworkInterface;

class LaravelFramework implements FrameworkInterface
{
    public function getTemplatesPath()
    {
        $dir = getcwd().'/resources/templates';
        if(!is_dir($dir))
            mkdir($dir, 0777, true);
        return $dir;
    }

    public function getTemplateFiles()
    {
        extract($this->getFileNames('Model'));
        $templates = [
            'app/Models/'.$model.'.php.tpl',
            'app/Http/Controllers/'.$controller.'.php.tpl',
            'app/Repositories/'.$repository.'.php.tpl',
            'database/factories/'.$factory.'.php.tpl',
        ];
        $path = 'resources/views/Model';
        $templates = array_merge($templates, $this->getViewFiles($path));
        return $templates;
    }

    public function getFileNames($model)
    {
        return [
            'controller' => $model.'Controller',
            'model' => $model,
            'repository' => $model.'Repository',
            'factory' => $model.'Factory',
            'view' => strtolower($model),
            'migration' => strtolower($model)
        ];
    }

    public function getFilesToCreate($model)
    {
        extract($this->getFileNames($model));
        $files = [];
        $files[] = $this->getModelFileName($model);
        $files[] = $this->getControllerFileName($controller);
        $files[] = $this->getRepositoryFileName($repository);
        $files[] = $this->getFactoryFileName($factory);
        $files[] = $this->getMigrationFileName($migration);
        $files = array_merge($files, $this->getViewsFileName($view));
        return $files;
    }

    public function getModelFileName($model)
    {
        $file = getcwd().'/app/Models/'.$model.'.php';
        return $file;
    }

    public function getControllerFileName($controller)
    {
        $file = getcwd().'/app/Http/Controllers/'.$controller.'.php';
        return $file;
    }

    public function getRepositoryFileName($repository)
    {
        $file = getcwd().'/app/Repositories/'.$repository.'.php';
        return $file;
    }

    public function getFactoryFileName($factory)
    {
        $file = getcwd().'/database/factories/'.$factory.'.php';
        return $file;
    }

    public function getViewsFileName($view)
    {
        $path = getcwd().'/resources/views/'.$view;
        $files = $this->getViewFiles($path);
        return $files;
    }

    public function getViewFiles($path)
    {
        $files = [];
        $views = ['index', 'create', 'edit', 'form'];
        foreach($views as $view){
            $files[] = $path.'/'.$view.'.blade.php';
        }
        return $files;
    }

    public function getMigrationFileName($migration)
    {
        $file = getcwd().'/database/migrations/Y_m_d_his_create_'.$migration.'_table.php';
        return $file;
    }

    public function __toString()
    {
        return 'Laravel';
    }
}
