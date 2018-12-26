<?php
/**
 * file handle class.
 * User: jackdou
 * Date: 18-12-25
 * Time: 下午3:09
 */

namespace Jackdou\PhpFmt;

class PhpFile
{
    public $files;
    
    public function __construct(array $files, string $dir)
    {
        $this->files = $files;
        $this->remove($dir);
    }

    /**
     * 移除非php的文件
     * @param string $dir
     */
    private function remove(string $dir)
    {
        foreach ($this->files as $key => $file) {

            if ($file == "." || $file == '..') {
                unset($this->files[$key]);
                continue;
            }

            $pathInfo = pathinfo($file);

            if (empty($pathInfo['extension']) || $pathInfo['extension'] !== "php") {
                unset($this->files[$key]);
                continue;
            }

            if (is_file($dir . DIRECTORY_SEPARATOR . $file)) {
                $this->files[$key] = $dir . DIRECTORY_SEPARATOR . $file;
            } else {
                unset($this->files[$key]);
            }
        }
        $this->files = array_values($this->files);
    }


    public function getFiles()
    {
        return $this->files;
    }
}