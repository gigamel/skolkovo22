<?php

namespace Skolkovo22\Util;

abstract class Dumper
{
    private static $isShownCSS = false;
    
    /**
     * @param mixed $var
     *
     * @return void
     */
    public static function print(...$vars): void
    {
        echo self::getCSS();
        
        foreach ($vars as $var) {
            echo '<pre>';
            var_dump($var);
            echo '</pre>';
        }
        
        exit;
    }
    
    /**
     * @return void
     */
    private static function getCSS(): void
    {
        if (self::$isShownCSS) {
            return;
        }
        
        echo '
<style>
pre {
  border: 1px solid #666789;
  color: #d980a0;
  line-height: 1.4;
  padding: 7px 12px;
  background-color: #3d2f47;
  overflow: auto;
}
</style>
        ';
    }
}
