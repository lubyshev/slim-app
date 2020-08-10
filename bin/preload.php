<?php
declare(strict_types=1);

foreach (scanAllDir(__DIR__.'/../vendor') as $file) {
    echo $file."\n";
    opcache_compile_file($file);
}

function scanAllDir($dir): iterable
{
    $dir = realpath($dir);
    foreach (scandir($dir) as $filename) {
        if ($filename[0] === '.') {
            continue;
        }
        $filePath = $dir.'/'.$filename;
        if (is_dir($filePath)) {
            foreach (scanAllDir($filePath) as $childFilename) {
                yield $dir.'/'.$filename.'/'.$childFilename;
            }
        } else {
            yield $dir.'/'.$filename;
        }
    }
}