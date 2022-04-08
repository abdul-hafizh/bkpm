<?php

namespace SimpleCMS\Blog\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use SimpleCMS\Blog\Http\Requests\ContactPostRequest;
use SimpleCMS\Blog\Services\BlogService;
use SimpleCMS\Blog\Services\ContactMessageService;
use SimpleCMS\Core\Http\Controllers\Controller;

class BlogController extends Controller
{
    public function index(Request $request)
    {
        try {
            return BlogService::home();
        }catch (\Exception $e){
            Log::error($e);
            return abort(404);
        }
    }
    public function posts(Request $request,$post_slug='')
    {
        try {
            return BlogService::posts();
        }catch (\Exception $e){
            Log::error($e);
            return abort(404);
        }
    }

    public function archive(Request $request,$year,$month,$post_slug='')
    {
        try {
            return BlogService::posts();
        }catch (\Exception $e){
            Log::error($e);
            return abort(404);
        }
    }

    public function category(Request $request,$post_slug='')
    {
        try {
            return BlogService::posts();
        }catch (\Exception $e){
            Log::error($e);
            return abort(404);
        }
    }
    public function tag(Request $request,$post_slug='')
    {
        try {
            return BlogService::posts();
        }catch (\Exception $e){
            Log::error($e);
            return abort(404);
        }
    }

    public function galleries(Request $request)
    {
        try {
            return BlogService::posts();
        }catch (\Exception $e){
            Log::error($e);
            return abort(404);
        }
    }

    public function search(Request $request,$search='')
    {
        try {
            return BlogService::posts();
        }catch (\Exception $e){
            Log::error($e);
            return abort(404);
        }
    }

    public function contact_message_save(ContactPostRequest $request)
    {
        try{
            return ContactMessageService::contact_message_save($request);
        }catch (\Exception $e){
            throw new \ErrorException($e->getMessage());
        }
    }
}
