<?php

namespace Crudcmd\Frameworks;

interface FrameworkInterface
{
    public function getTemplateFiles();
    public function getFileNames($model);
    public function getFilesToCreate($model);
    public function getModelFileName($model);
    public function getControllerFileName($controller);
    public function getRepositoryFileName($repository);
    public function getFactoryFileName($factory);
    public function getViewsFileName($view);
    public function getMigrationFileName($migration);
    public function getTemplatesPath();
    public function __toString();
}
