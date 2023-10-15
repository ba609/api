<?php

use App\Http\Controllers\Api\PostController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/


    //recuperation la liste des posts
Route::get('posts',[PostController::class, 'index']);






        //inscription des utilisateurs
 Route::post('/register',[UserController::class, 'register']);

         //authentification des utilisateurs
 Route::post('/login',[UserController::class, 'login']);

 Route::post('posts/create',[PostController::class, 'store']);

    //mis a jour  des  posts
 Route::put('posts/edit/{post}',[PostController::class, 'update']);

        //supprimer  des  posts
 Route::delete('posts/{post}',[PostController::class, 'delete']);

//  Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::middleware('auth:sanctum')->group(function(){

        //ajouter de nouveau  posts


    //utilisateur actuellement connecter
   Route::get('/user',function(Request  $request){
    return $request->user();
   });
});
