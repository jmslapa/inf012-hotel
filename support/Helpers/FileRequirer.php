<?php

namespace Support\Helpers;

class FileRequirer
{
    /**
     * Faz o require de todos os arquivos .php do diretório indicado.
     *
     * @param string $dir Diretório alvo.
     * @param array $except Arquivos a serem ignorados
     * @return void
     */
    public static function requireAll(string $dir, array $except = [])
    {
        $scan = glob("$dir/*");
        foreach ($scan as $path) {
            if (preg_match('/\.php$/', $path) && !in_array($path, $except)) {
                require_once $path;
            } elseif (is_dir($path)) {
                self::requireAll($path);
            }
        }
    }
}
