<?php

namespace App\Services;

use Illuminate\Support\Facades\Route;

class BreadcrumbService
{
    protected $breadcrumbMap = [];

    public function __construct()
    {
        $this->breadcrumbMap = [
            // 'userpanels' => [
            //     ['text' => 'User Panels', 'url' => route('userpanels')],
            //     ['text' => 'Dashboard', 'url' => route('userPanels.dashboard')],
            // ],
            // 'userPanels.dashboard' => [
            //     ['text' => 'User Panels', 'url' => route('userpanels')],
            //     ['text' => 'Dashboard', 'url' => route('userPanels.dashboard')],
            // ],
            'userpanels' => [
                ['text' => 'User Panels', 'url' => route('userpanels')],
                ['text' => 'Projects', 'url' => route('userPanels.projects')],
            ],
            'userPanels.projects' => [
                ['text' => 'User Panels', 'url' => route('userpanels')],
                ['text' => 'Projects', 'url' => route('userPanels.projects')],
            ],
            'userPanels.myprofile' => [
                ['text' => 'User Panels', 'url' => route('userpanels')],
                ['text' => 'My Profile', 'url' => route('userPanels.myprofile')],
            ],
            'm.emp' => [
                ['text' => 'User Panels', 'url' => route('userpanels')],
                ['text' => 'Employees', 'url' => route('m.emp')],
            ],
            'm.emp.roles' => [
                ['text' => 'User Panels', 'url' => route('userpanels')],
                ['text' => 'Employees', 'url' => route('m.emp')],
                ['text' => 'Office Roles', 'url' => route('m.emp.roles')],
            ],
            'm.emp.teams' => [
                ['text' => 'User Panels', 'url' => route('userpanels')],
                ['text' => 'Employees', 'url' => route('m.emp')],
                ['text' => 'Teams', 'url' => route('m.emp.teams')],
            ],
            'm.projects' => [
                ['text' => 'User Panels', 'url' => route('userpanels')],
                // ['text' => 'Projects', 'url' => route('m.projects')],
                ['text' => 'Projects', 'url' => route('userPanels.projects')],
            ],
            'm.projects.getprjmondws' => [
                ['text' => 'User Panels', 'url' => route('userpanels')],
                // ['text' => 'Projects', 'url' => route('m.projects')],
                ['text' => 'Projects', 'url' => route('userPanels.projects')],
                ['text' => 'M&W', 'url' => ''],     //<--- the url parameter got dynamically
            ],
            'm.ws' => [
                ['text' => 'User Panels', 'url' => route('userpanels')],
                // ['text' => 'Projects', 'url' => route('m.projects')],
                ['text' => 'Projects', 'url' => route('userPanels.projects')],
                ['text' => 'M&W', 'url' => ''],     //<--- the url parameter got dynamically
                ['text' => 'Daily Worksheet', 'url' => route('m.ws')],
            ],
            'm.user.emp' => [
                ['text' => 'User Panels', 'url' => route('userpanels')],
                ['text' => 'Employees', 'url' => route('m.emp')],
                ['text' => 'User Accounts', 'url' => route('m.user.emp')],
            ],
            'm.cli' => [
                ['text' => 'User Panels', 'url' => route('userpanels')],
                ['text' => 'Clients', 'url' => route('m.cli')],
            ],
            'm.user.cli' => [
                ['text' => 'User Panels', 'url' => route('userpanels')],
                ['text' => 'Clients', 'url' => route('m.cli')],
                ['text' => 'User Accounts', 'url' => route('m.user.cli')],
            ],
            'm.sys' => [
                ['text' => 'User Panels', 'url' => route('userpanels')],
                ['text' => 'System Settings', 'url' => route('m.sys')],
            ],

        ];
    }


    // public function generate(): array
    // {
    //     $routeName = Route::currentRouteName();
    //     if (!$routeName) {
    //         return [['text' => 'Dashboard', 'url' => '/']]; // Default breadcrumb
    //     }

    //     $breadcrumbs = [];

    //     // Check if the current route exists in the breadcrumb map
    //     if (isset($this->breadcrumbMap[$routeName])) {
    //         // Use the defined breadcrumbs from the map
    //         $breadcrumbs = $this->breadcrumbMap[$routeName];
    //     } else {
    //         // If no specific mapping, handle dynamically (optional)
    //         $routeParts = explode('.', $routeName);
    //         foreach ($routeParts as $i => $part) {
    //             $currentRoute = implode('.', array_slice($routeParts, 0, $i + 1));
    //             $name = ucfirst($part); // Capitalize for better readability
    //             $url = $this->generateUrl($currentRoute);
    //             $breadcrumbs[] = ['text' => $name, 'url' => $url]; // Use 'text' for consistency
    //         }
    //     }

    //     // Disable the last breadcrumb
    //     if (!empty($breadcrumbs)) {
    //         $lastBreadcrumb = array_pop($breadcrumbs);
    //         $lastBreadcrumb['text'] = $lastBreadcrumb['text']; // Keep the text
    //         $lastBreadcrumb['disabled'] = true; // Add a disabled attribute
    //         $breadcrumbs[] = $lastBreadcrumb; // Re-add the last breadcrumb as disabled
    //     }

    //     return $breadcrumbs;
    // }



    public function generate(): array
    {
        $routeName = Route::currentRouteName();
        if (!$routeName) {
            return [['text' => 'Dashboard', 'url' => '/']]; // Default breadcrumb
        }

        $breadcrumbs = [];

        // Check if the current route exists in the breadcrumb map
        if (isset($this->breadcrumbMap[$routeName])) {
            // Use the defined breadcrumbs from the map
            $breadcrumbs = $this->breadcrumbMap[$routeName];

            // Handle dynamic URL for 'm.projects.getprjmondws'
            if ($routeName === 'm.projects.getprjmondws') {
                $projectID = request()->query('projectID'); // Get the projectID from the query string
                if ($projectID) {
                    // Update the M&W breadcrumb URL with the projectID
                    $mWIndex = array_search('M&W', array_column($breadcrumbs, 'text'));
                    if ($mWIndex !== false) {
                        $breadcrumbs[$mWIndex]['url'] = route('m.projects.getprjmondws', ['projectID' => $projectID]);
                    }
                }
            }
            // Handle dynamic URL for 'm.ws'
            if ($routeName === 'm.ws') {
                $projectID = request()->query('projectID'); // Get the projectID from the query string
                if ($projectID) {
                    // Update the M&W breadcrumb URL with the projectID
                    $mWIndex = array_search('M&W', array_column($breadcrumbs, 'text'));
                    if ($mWIndex !== false) {
                        $breadcrumbs[$mWIndex]['url'] = route('m.projects.getprjmondws', ['projectID' => $projectID]);
                    }
                }
            }
        } else {
            // If no specific mapping, handle dynamically (optional)
            $routeParts = explode('.', $routeName);
            foreach ($routeParts as $i => $part) {
                $currentRoute = implode('.', array_slice($routeParts, 0, $i + 1));
                $name = ucfirst($part); // Capitalize for better readability
                $url = $this->generateUrl($currentRoute);
                $breadcrumbs[] = ['text' => $name, 'url' => $url]; // Use 'text' for consistency
            }
        }

        // Disable the last breadcrumb
        if (!empty($breadcrumbs)) {
            $lastBreadcrumb = array_pop($breadcrumbs);
            $lastBreadcrumb['disabled'] = true; // Add a disabled attribute
            $breadcrumbs[] = $lastBreadcrumb; // Re-add the last breadcrumb as disabled
        }

        return $breadcrumbs;
    }


    protected function generateUrl(string $routeName): string
    {
        return Route::has($routeName) ? route($routeName) : '#'; // Default to '#' if no route exists
    }
}
