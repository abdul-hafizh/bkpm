<?php

namespace SimpleCMS\FileManager\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use SimpleCMS\ACL\Models\User;

class FileManagerMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if(Auth::check()) {
            $user = \auth()->user();
            $elfinderRoots = [
                [
                    'driver'        => 'LocalFileSystem',           // driver for accessing file system (REQUIRED)
                    'path'          => public_path('uploads'),  // path to files (REQUIRED)
                    'URL'           => url('uploads'),   // URL to files (REQUIRED)
                    'alias'         => 'Uploads', // The name to replace your actual path name. (OPTIONAL)
                    'accessControl' => 'access'      // disable and hide dot starting files (OPTIONAL)
                ]
            ];
            /*if ( \auth()->user()->role_id <=3 ){
                array_push($elfinderRoots,$folderUser);
            }else {
                $elfinderRoots = [$folderUser];
            }*/
            if ( \auth()->user()->group_id > 2 ){
                unset($elfinderRoots[0]);
            }
            array_push($elfinderRoots, [
                'driver'        => 'LocalFileSystem',
                'path'          => public_path($user->path),
                'URL'           => url($user->path),
                'alias'         => 'Your Directory'
            ]);

            $path = trim($request->get('path'));

            if ($path && !empty($path)){
                $name_path = explode('|', $path);
                $name_path = \Arr::last($name_path);
                array_push($elfinderRoots, [
                    'driver'        => 'LocalFileSystem',
                    'path'          => public_path($path),
                    'URL'           => url($path),
                    'alias'         => $name_path
                ]);
            }

            /* allowed users to access folder uploads */
            if($user->group_id <= 2) {
                /*$users = User::select('id', 'group_id', 'name', 'path');
                if ($user->group_id == 1){
                    $users->where('group_id', '<>', 1);
                }else{
                    $users->where('group_id', '>', 2);
                }
                $users = $users->cursor();
                foreach ($users as $user_folder) {
                    if (!empty($user_folder->path)) {
                        array_push($elfinderRoots, [
                            'driver' => 'LocalFileSystem',
                            'path' => public_path($user_folder->path),
                            'URL' => url($user_folder->path),
                            'alias' => $user_folder->name
                        ]);
                    }
                }*/
            }else{
                unset($elfinderRoots[0]);
            }

            $files = app('files');

            /* check dir */
            foreach ($elfinderRoots as $elfinderRoot) {
                if ($elfinderRoot['alias'] == "Uploads") {
                    if (!$files->exists($elfinderRoot['path'])) {
                        $files->makeDirectory($elfinderRoot['path'], 0775, true);
                    }
                }else{
                    /* check dir public/users */
                    if (!$files->exists(public_path('users'))){
                        $files->makeDirectory(public_path('users'), 0775, true);
                    }
                    /* check dir public/users/current */
                    if (!$files->exists($elfinderRoot['path'])){
                        $files->makeDirectory($elfinderRoot['path'], 0775, true);
                    }
                }
            }
            config()->set('filemanager.roots',$elfinderRoots);
        }
        return $next($request);
    }
}
