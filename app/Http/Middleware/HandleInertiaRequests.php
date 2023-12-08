<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Inertia\Middleware;
use Tightenco\Ziggy\Ziggy;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that is loaded on the first page visit.
     *
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determine the current asset version.
     */
    public function version(Request $request): string|null
    {
        return parent::version($request);
    }

    /**
     * Define the props that are shared by default.
     *
     * @return array<string, mixed>
     */
    public function share(Request $request): array
    {
        return array_merge(parent::share($request), [
            'auth' => [
                'user' => $request->user() ? [
                    'id' => $request->user()->id,
                    'user' => $request->user()->username,
                    'name' => $request->user()->name,
                    'email' => $request->user()->email,
                    'address' => $request->user()->address,
                    'roles' => $request->user()->getRoleNames(),
                    'permissions' => $request->user()->getAllPermissions()->pluck('name'),
                    'profile_photo_url' => $request->user()->profile_photo_url,
                ] : null,
            ],
            'flash' => function () use ($request) {
                $flashData = [
                    'error' => $request->session()->get('error'),
                    'success' => $request->session()->get('success'),
                    'message' => $request->session()->get('message'),
                ];

                // Clear the flash messages after reading them
                $request->session()->forget(['error', 'success', 'message']);

                return $flashData;
            },
            // 'flash' => [
            //     'error' => $request->session()->get('error'),
            //     'success' => $request->session()->get('success'),
            //     'message' => $request->session()->get('message'),
            // ],
            
            // 'ziggy' => function () use ($request) {
            //     return array_merge((new Ziggy)->toArray(), [
            //         'location' => $request->url(),
            //     ]);
            // },
        ]);
    }
}
