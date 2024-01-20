<?php

trait FileOperationsTrait
{
    private $phpFileContent = '
    <?php

    (function () {
    $root = __DIR__;
    while ($root !== "/") {
        if (file_exists($root . "/composer.json")) break;
        $root = realpath($root . "/..");
    }
    define("__ROOT__", $root);
    })();

    require_once __ROOT__ ."/src/Page.php";

    Page::serve(__DIR__);
    ';

    public function generatePhpWebfiles(string $destination)
    {
        $htmlFiles = glob($destination . '/*.html');

        foreach ($htmlFiles as $htmlFile) {
            $phpFile = dirname($htmlFile) . '/' . pathinfo($htmlFile, PATHINFO_FILENAME) . '.php';
            file_put_contents($phpFile, $this->phpFileContent);
        }
    }

    public function generateConfig($destination, $config)
    {
        $configPath = $destination . '/config.json';
        file_put_contents($configPath, json_encode($config));
    }

    public function generateServerFiles(
        string $destination,
        string $base_url, 
        string $data_key, 
        $data_field
    ) {
        $this->generatePhpWebfiles($destination);
        $this->generateConfig($destination, [
            'base_url' => $base_url,
            'data_key' => $data_key,
            'data_field' => $data_field
        ]);
    }

    public function cloneFolder($source, $destination)
    {
        if (!is_dir($source)) {
            return false;
        }

        if (!is_dir($destination)) {
            if (!mkdir($destination, 0777, true)) {
                return false;
            }
        }

        $dir = opendir($source);
        if ($dir === false) {
            return false;
        }

        while (($file = readdir($dir)) !== false) {
            if ($file !== '.' && $file !== '..') {
                $sourcePath = $source . '/' . $file;
                $destinationPath = $destination . '/' . $file;

                if (is_dir($sourcePath)) {
                    if (!$this->cloneFolder($sourcePath, $destinationPath)) {
                        closedir($dir);
                        return false;
                    }
                } else {
                    if (!copy($sourcePath, $destinationPath)) {
                        closedir($dir);
                        return false;
                    }
                }
            }
        }

        closedir($dir);
        return true;
    }
}