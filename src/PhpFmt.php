<?php

namespace Jackdou\PhpFmt;

use PhpParser\Error;
use PhpParser\ParserFactory;
use PhpParser\PrettyPrinter;

class PhpFmt
{
    public $phpFile;
    public $phpCache;

    /**
     * PhpFmt constructor.
     * @param PhpFile $phpFile
     * @param PhpCache $phpCache
     */
    public function __construct(PhpFile $phpFile, PhpCache $phpCache)
    {
        $this->phpFile = $phpFile;
        $this->phpCache = $phpCache;
    }

    public function run()
    {
        $files = $this->phpFile->getFiles();

        foreach ($files as $file) {

            $mtime = filemtime($file);

            $originMtime = $this->phpCache->getCache($file);

            if ($originMtime === 0 || $originMtime < $mtime) {
                $this->parse($file);
                clearstatcache();
                $mtime = filemtime($file);
                $this->phpCache->setCache($file, $mtime);
            }
        }

    }

    private function parse(string $file)
    {
        $parser = (new ParserFactory())->create(ParserFactory::PREFER_PHP7);

        $code = file_get_contents($file);

        $parser->parse($code);

        try {
            $ast = $parser->parse($code);
        } catch (Error $error) {
            echo "Parse error: {$error->getMessage()}\n";
            return;
        }

        $prettyPrinter = new PrettyPrinter\Standard();
        file_put_contents($file, $prettyPrinter->prettyPrintFile($ast));
    }
}

