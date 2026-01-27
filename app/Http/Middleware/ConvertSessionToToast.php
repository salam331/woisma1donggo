<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ConvertSessionToToast
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        // Check if there are flash messages for success or error
        if (session()->has('success')) {
            $toastMessage = session('success');
            session()->forget('success');
            session()->flash('toast', [
                'type' => 'success',
                'message' => $toastMessage
            ]);
        }

        if (session()->has('error')) {
            $toastMessage = session('error');
            session()->forget('error');
            session()->flash('toast', [
                'type' => 'error',
                'message' => $toastMessage
            ]);
        }

        if (session()->has('warning')) {
            $toastMessage = session('warning');
            session()->forget('warning');
            session()->flash('toast', [
                'type' => 'warning',
                'message' => $toastMessage
            ]);
        }

        if (session()->has('status')) {
            $toastMessage = session('status');
            session()->forget('status');
            session()->flash('toast', [
                'type' => 'info',
                'message' => $toastMessage
            ]);
        }

        return $response;
    }
}

