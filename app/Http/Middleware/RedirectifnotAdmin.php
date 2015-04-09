<?php namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\RedirectResponse;
class RedirectifnotAdmin {

	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
	public function handle($request, Closure $next)
	{
		// if the user is not admin he won't go to the administration page
					
		if (!$request->user()->isAdmin())
		{
			return new RedirectResponse(url('/home'));
		}
		else
		{	
			//we do nothing
		}
		
		return $next($request);
	}

}
