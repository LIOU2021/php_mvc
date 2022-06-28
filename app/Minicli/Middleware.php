<?php

namespace App\Minicli;

class Middleware
{
    private $fileName;
    private $filePath;
    private $printer;
    private $file;

    public function __construct($name)
    {
        $this->printer = new CliPrinter();
        $this->filePath = "app/Http/Middleware";

        if (!$name) {
            $this->getPrinter()->display("ERROR: Command, lose arg like 'php minicli make:middleware TestMiddleware' .");
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

        $content = '<?php

namespace App\Http\Middleware;

use App\Http\Request;

class '.$this->fileName.' extends Middleware
{
    /**
     * redirect url
     */
    protected $redirect = "/";

    protected function handle(Request $request=null)
    {
        $yourCondition=true;
        
        if ($yourCondition) {
            return true;
        } else {
            return false;
        }
    }
}';

        file_put_contents($this->file, $content);

        return $this->fileName;
    }
}
