<?php

namespace PHPixie;

class BundleFramework extends \PHPixie\Framework
{
    public function __construct($rootDir)
    {
        $this->builder = $this->buildBuilder($rootDir);
    }
}