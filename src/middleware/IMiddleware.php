<?php

interface IMiddleware
{
    public function canPass(IKernel $kernel): bool;
}