<?php
    
namespace App\Http\Middleware;
    
use Closure;
    
class ApiDataLogger
{
    private $startTime;
    /**
    * Handle an incoming request.
    *
    * @param  \Illuminate\Http\Request  $request
    * @param  \Closure  $next
    * @return mixed
    */
    public function handle($request, Closure $next)
    {
        $this->startTime = microtime(true);
        return $next($request);
    }

    public function terminate($request, $response)
    {
        if ( env('API_DATALOGGER', true) && $request->path() != 'ping') {
            $endTime = microtime(true);

            $dataToLog  = 'Time: '   . gmdate("F j, Y, g:i a") . "\n";
            $dataToLog .= 'Duration: ' . number_format($endTime - $this->startTime, 3) . "\n";
            $dataToLog .= 'IP Address: ' . $request->ip() . "\n";
            $dataToLog .= 'URL: '    . $request->fullUrl() . "\n";
            $dataToLog .= 'Method: ' . $request->method() . "\n";
            $dataToLog .= 'Input: '  . $request->getContent() . "\n";
            $dataToLog .= 'Output: '  . $response->getContent() . "\n";
            
            \Log::info($dataToLog . "\n" . str_repeat("=", 20) . "\n\n");
        }
    }
}