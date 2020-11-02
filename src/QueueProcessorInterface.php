<?php


namespace MiniFrameWork;


interface QueueProcessorInterface
{
    public function process(Message $message): void;
}