<?php

namespace Skolkovo22\Util;

abstract class Catcher
{
    private const
        LINE = '%d) %s',
        LINE_SELECTED = '<div class="selected_line">%d) %s</div>',
        PRE = '<pre>%s</pre>'
    ;
    
    private const OFFSET = 7;
    
    /**
     * @param \Throwable $e
     *
     * @return void
     */
    public static function show(\Throwable $e): void
    {
        $vars = [
            'file'    => $e->getFile(),
            'line'    => $e->getLine(),
            'message' => $e->getMessage(),
            'code'    => self::parseTraceFiles($e),
        ];
        
        $content = self::getView();
        foreach ($vars as $var => $replacement) {
            $content = str_replace(
                sprintf('{{ %s }}', $var),
                $replacement,
                $content
            );
        }
        
        echo $content;
        exit;
    }
    
    private static function parseTraceFiles(\Throwable $e): string
    {
        $traceFilesCode = '';
        foreach (self::resolveTrace($e) as $trace) {
            $traceFilesCode .= self::parseTraceFile($trace);
        }
        
        return $traceFilesCode;
    }
    
    /**
     * @param array $trace
     *
     * @return string
     */
    private static function parseTraceFile(array $trace): string
    {
        $traceFileLine = $trace['line'] - 1;
        
        $firstParsingLine = $traceFileLine - self::OFFSET;
        
        $fileAsArray = file($trace['file']);
        $fileLinesCount = count($fileAsArray);
        
        $firstParsingLine = $firstParsingLine < 0 ? 0 : $firstParsingLine;
        
        $lastParsingLine = $traceFileLine + self::OFFSET + 1;
        $lastParsingLine = $lastParsingLine > $fileLinesCount
            ? $fileLinesCount : $lastParsingLine;
        
        $traceFileCode = sprintf(
            '<p>%s::%d</p>',
            $trace['file'],
            $trace['line']
        );
        
        $step = $firstParsingLine;
        while (
            $step < $lastParsingLine
            && ($fileAsArray[$step] ?? false)
        ) {
            $traceFileCode .= sprintf(
                ($traceFileLine === $step) ? self::LINE_SELECTED : self::LINE,
                $step + 1,
                $fileAsArray[$step]
            );
            
            $step++;
        }
        
        return sprintf(self::PRE, $traceFileCode);
    }
    
    /**
     * @param \Throwable $e
     *
     * @return array
     */
    private static function resolveTrace(\Throwable $e): array
    {
        $traces = [
            [
                'file' => $e->getFile(),
                'line' => $e->getLine(),
            ],
        ];
        
        foreach ($e->getTrace() as $trace) {
            if (null === ($trace['file'] ?? null)) {
                continue;
            }
            
            if (null === ($trace['line'] ?? null)) {
                continue;
            }

            $traces[] = [
                'file' => $trace['file'],
                'line' => $trace['line'],
            ];
        }
        
        return array_unique($traces, SORT_REGULAR);
    }


    /**
     * @return string
     */
    private static function getView(): string
    {
        return '
<!DOCTYPE html>
<html>
  <head>
    <title>Throwable trace</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
        
    <style>
    .throwable {
      background-color:#170727;
      border-radius: 7px;
      color: #d980a0;
      padding: 25px;
      margin: 15px;
      overflow: auto;
    }
            
    .selected_line {
      background-color: #3f4c61;
      padding: 2px 6px;
      border-radius: 2px;
      line-height: 1;
      margin: 0 0 0 -6px;
    }
            
    pre {
      border: 1px solid #666789;
      line-height: 1.4;
      padding: 7px 12px;
      background-color: #3d2f47;
      overflow: auto;
   }
   </style>
  </head>
  <body>
    <div class="throwable">
      <h2>File: {{ file }}::{{ line }}</h2>
      <h3>Message: {{ message }}</h3>
      {{ code }}
    </div>
  </body>
</html>
        ';
    }
}
