<?php

namespace App\Http\Middleware;

use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\JsonResponse;
use Closure;

class AsAPIOnly
{
    protected $factory;

    public function __construct(ResponseFactory $factory)
    {
        $this->factory = $factory;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (!$request->ajax()) {
            return response('Request must be AJAX.', 405);
        }
        $request->headers->set('Accept', 'application/json');
        $response = $next($request);
        // if (!$response instanceof JsonResponse) {
        //     $response = $this->factory->json(
        //         $response->content(),
        //         $response->status(),
        //         $response->headers->all()
        //     );
        // }
        return $response;
    }
}
