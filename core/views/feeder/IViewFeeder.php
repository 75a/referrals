<?php

namespace app\core\views\feeder;

interface IViewFeeder
{
    public function getFeed(): array;
}