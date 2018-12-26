<?php
/**
 * file format class.
 * User: jackdou
 * Date: 18-12-25
 * Time: 下午3:09
 */
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

        if (empty($files)) {
            echo "no php script file found\n";
            return;
        }

        $notParse = 0;

        foreach ($files as $file) {

            $mtime = filemtime($file);

            $originMtime = $this->phpCache->getCache($file);

            if ($originMtime === 0 || $originMtime < $mtime) {

                if ($this->parse($file)) {

                    clearstatcache();

                    $mtime = filemtime($file);

                    $this->phpCache->setCache($file, $mtime);

                    echo "$file parse success\n";
                }
            } else {
                $notParse++;
            }
        }

        if ($notParse == count($files)) {
            echo "no file need format\n";
            return;
        }

    }

    /**
     * @param string $file
     * @return bool
     */
    private function parse(string $file) :bool
    {
        $parser = (new ParserFactory())->create(ParserFactory::PREFER_PHP7);

        $code = file_get_contents($file);

        $parser->parse($code);

        try {
            $ast = $parser->parse($code);
        } catch (Error $error) {
            echo "$file Parse error: {$error->getMessage()}\n";
            return false;
        }

        $prettyPrinter = new PrettyPrinter\Standard();

        file_put_contents($file, $prettyPrinter->prettyPrintFile($ast));

        return true;
    }
}

