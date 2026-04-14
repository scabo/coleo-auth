<?php

namespace Coleo\Auth;

interface AuthContainerInterface
{
    public function store($data);
    public function retrive();
    public function clear();
}