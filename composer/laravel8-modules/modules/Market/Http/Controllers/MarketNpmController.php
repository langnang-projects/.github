<?php

namespace Modules\Market\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use App\Illuminate\Routing\Controller;
use Modules\Market\Support\Market;
use wapmorgan\UnifiedArchive\Abilities;
use wapmorgan\UnifiedArchive\UnifiedArchive;

class MarketNpmController extends MarketController
{
    protected $remote_projects = [
        'url' => "http://api.jsdelivr.com/v1/jsdelivr/libraries?name=*{\$search}*",
        "response" => [
            "type" => "array",
            "key" => null,
            "merge" => ["type" => "npm"],
            "map" => [
                "name" => "name",
                "description" => "description",
                "lastversion" => "lastversion",
            ],
        ]
    ];
    protected $remote_project = [
        'url' => "http://api.jsdelivr.com/v1/jsdelivr/libraries?name={\$name}",
        "response" => [
            "key" => null,
            "merge" => ["type" => "npm"],
            "map" => [
                "name" => "name",
                "description" => "description",
                "lastversion" => "lastversion",
                "versions" => "versions",
            ],
        ]
    ];
    public function view_index(Request $request)
    {
        // var_dump($request->all());

        $return = [
            'view' => 'npm.index',
            'request' => [
                // 'response' => \Http::get('http://api.jsdelivr.com/v1/jsdelivr/libraries?name=*jquery*')->json()
            ],
            'projects' => $this->getRemoteProjects($request),
        ];
        return $this->view($return);
    }
    public function view_slug(Request $request, $name)
    {
        $request->merge(['name' => $name]);
        // var_dump($request->all());
        $return = [
            'view' => 'npm.slug',
            'request' => [
                // 'response' => \Http::get('http://api.jsdelivr.com/v1/jsdelivr/libraries?name=*jquery*')->json()
            ],
            'project' => $this->getRemoteProject($request),
        ];
        if ($request->method() == "POST") {
            \Arr::set($return, 'project.version', $request->input('version'));
            \Arr::set(
                $return,
                'project.version_url',
                'https://registry.npmjs.org/' . $request->input('name') . '/-/' . $request->input('name') . '-' . $request->input('version') . '.tgz'
            );
        }
        return $this->view($return);
    }
    public function view_package(Request $request, $name, $version)
    {
        $request->merge(['name' => $name, 'version' => $version]);
        var_dump($request->all());

        $return = [
            'view' => 'npm.package',
            'request' => [
                // 'response' => \Http::get('http://api.jsdelivr.com/v1/jsdelivr/libraries?name=*jquery*')->json()
            ],
            'project' => $this->getRemoteProject($request),
            'package' => [
                'name' => $name . '-' . $version,
                'path' => $name . '-' . $version,
                // 'files' => \Storage::listContents('module\packages\\' . $name . '-' . $version),
                'files' => []
            ],
        ];
        $archive = UnifiedArchive::open(storage_path('app/module/packages/' . $name . '-' . $version . '.tgz'));
        // var_dump($archive->getFileNames());
        // var_dump($archive->getFiles('package/src/*'));
        // $files = $archive->getFiles();
        // while (sizeof($files) > 0) {
        //     foreach ($archive->getFiles() as $index => $file) {

        //     }

        // }
        $maxPathDepth = 0;
        $files = $archive->getFiles();
        foreach ($archive->getFiles() as $file) {
            $exp = explode('/', $file);
            if (sizeof($exp) > $maxPathDepth) {
                $maxPathDepth = sizeof($exp);
            }
        }
        dump($maxPathDepth);
        for ($depth = $maxPathDepth; $depth > 1; $depth--) {
            foreach ($files as $index => $file) {
                // $file = is_string($file) ? $file : $index;
                $exp = explode('/', is_string($file) ? $file : $index);
                if (sizeof($exp) != $depth)
                    continue;
                $pathinfo = pathinfo(is_string($file) ? $file : $index);
                if (!isset($files[$pathinfo['dirname']])) {
                    $files[$pathinfo['dirname']] = array_merge(pathinfo($pathinfo['dirname']), [
                        'type' => "dir",
                        "children" => []
                    ]);
                }
                if (isset($pathinfo['extension']))
                    $pathinfo['type'] = 'file';
                $files[$pathinfo['dirname']]['children'][$pathinfo['basename']] = array_merge($pathinfo, is_string($file) ? [] : $file);
                // array_push($files[$pathinfo['dirname']]['children'], array_merge($pathinfo, is_string($file) ? [] : $file));
                unset($files[$index]);
                // $files[$pathinfo['dirname']]['children'][$pathinfo['basename']] = $pathinfo;
            }

        }

        // foreach ($archive->getFiles() as $file) {
        //     $pathinfo = pathinfo($file);
        //     if (!isset($files[$pathinfo['dirname']])) {
        //         $files[$pathinfo['dirname']] = [
        //             'filetype' => "dir",
        //             "children" => []
        //         ];
        //     }
        //     $files[$pathinfo['dirname']]['children'][$pathinfo['basename']] = $pathinfo;
        //     // array_push($files[$pathinfo['dirname']]['children'], $pathinfo);
        //     // var_dump(pathinfo($file));
        //     //     var_dump(pathinfo(pathinfo($file)['dirname']));

        // }
        dump($files);
        \Arr::set($return, 'package.files', $files);
        if ($request->filled('path')) {
            \Arr::set($return, 'package.path', $name . '-' . $version . '/' . $request->input('path'));
            \Arr::set($return, 'package.files', \Storage::listContents('module\packages\\' . $name . '-' . $version . '\\' . $request->input('path')));
        }
        if ($request->method() == 'POST') {
            var_dump($request->all());
            if ($request->filled('files')) {
            } else {
                Market::installPackage($name, $version, $request->input('path'));
                // $res = $this->install_pipline(array_merge($request->all(), []));
                // var_dump($res);
            }
        }
        // var_dump($return);
        return $this->view($return);
    }
}
