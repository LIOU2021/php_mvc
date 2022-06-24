<?php

namespace App\Minicli;

class Model
{
    private $fileName;
    private $filePath;
    private $printer;
    private $file;

    public function __construct($name)
    {
        $this->printer = new CliPrinter();
        $this->filePath = "app/Models";

        if (!$name) {
            $this->getPrinter()->display("ERROR: Command, lose arg like 'php minicli make:model User' .");
            exit;
        }

        $this->fileName = $name;
        $this->file = $this->filePath . "/" .$this->fileName.'.php';
    }

    public function getPrinter()
    {
        return $this->printer;
    }

    public function make()
    {
        if(file_exists($this->file)){
            $this->getPrinter()->display("ERROR: Command, this file already exists - $this->file .");
            exit;
        }

        $content = "<?php

namespace App\Models;

class $this->fileName extends Model
{

}";

        file_put_contents($this->file, $content);

        return $this->fileName;
    }
}
