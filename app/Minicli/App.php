<?php

namespace App\Minicli;

class App
{
    protected $printer;

    protected $registry = [];

    public function __construct()
    {
        $this->printer = new CliPrinter();
    }

    public function getPrinter()
    {
        return $this->printer;
    }

    public function registerCommand($name, $callable)
    {
        if (isset($this->registry[$name])) {
            $this->getPrinter()->display("ERROR: Command \"$name\" duplicate defind .");
            exit;
        }

        $this->registry[$name] = $callable;
    }

    public function getAllCommandList()
    {
        return array_keys($this->registry);
    }

    public function getCommand($command)
    {
        return isset($this->registry[$command]) ? $this->registry[$command] : null;
    }

    public function runCommand(array $argv = [])
    {
        // var_dump($argv);
        // exit;
        
        if (isset($argv[1])) {
            $command_name = $argv[1];
        }else{
            $this->description($argv);
        }

        $command = $this->getCommand($command_name);
        if ($command === null) {
            $this->getPrinter()->display("ERROR: Command \"$command_name\" not found.");
            exit;
        }

        call_user_func($command, $argv);
    }

    public function description(array $argv)
    {
        if(count($argv)==1){
            $this->getPrinter()->display("welcome to my custom CLI, use 'php minicli help' to get more information !");
            exit;
        }
    }
}
