<?php

interface ResourceFactoryInterface
{
    public function getResource(string $name): ?Resource;
}