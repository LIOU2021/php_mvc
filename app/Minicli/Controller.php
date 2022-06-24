<?php

namespace App\Minicli;

class controller
{
    private $fileName;
    private $filePath;
    private $printer;

    public function __construct($name, $filePath = "app/Controllers")
    {
        $this->printer = new CliPrinter();
        $this->filePath = $filePath;
        
        if (!$name) {
            $this->getPrinter()->display("ERROR: Command, lose arg like 'php minicli make:controller UserController' .");
            exit;
        }

        $this->fileName = $name;
    }

    public function getPrinter()
    {
        return $this->printer;
    }

    public function make()
    {
        $content = "111111111111";

        file_put_contents($this->filePath . "/" . time() . '_test.php', $content);

        return $this->fileName;
    }
}
