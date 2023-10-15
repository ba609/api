<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\createPostRequest;
use App\Http\Requests\editPostRequest;
use App\Models\Post;
use Exception;
use Illuminate\Http\Request;
use PhpParser\Node\Stmt\TryCatch;

class PostController extends Controller
{
    public function index(Request $request){
        $query = POST::query();
        $perpage= 1;
        $page = $request->input('page',1);
        $search = $request->input('search');

            if($search){
                $query->whereRaw("titre like'%" .$search. "%'");
            }
            $total= $query->count();
            $result= $query->offset(($page-1) * $perpage)->limit($perpage)->get();

        try{
            return response()->json([
                'status_code' => 200,
                'status_messsage' => 'le post ont ete recupere.',
                'current_page' =>$page,
                'last_page' =>ceil($total / $perpage),
                'items' => $result
                // 'data'=> POST::all(),
           ]);
        }
        catch(Exception $e){
            return response()->json($e);
           }
    }
      //creation d'une post
    public function store(createPostRequest $request){

     try{
        $post=new Post();

        $post->titre= $request->titre;
        $post->description= $request->description;
        $post->user_id =auth()->user()->id;

        $post->save();

        return response()->json([
             'status_code' => 200,
             'status_messsage' => 'le post a ete ajouter',
             'data'=>$post,
        ]);
     }
     catch(Exception $e){
        return response()->json($e);
     }
    }

    //modification d'une post
    public function update(editPostRequest $request ,POST $post){

       try{
        $post->titre= $request->titre;
        $post->description= $request->description;

        if($post->user_id == auth()->user()->id){
            $post->save();
        }
        else{
            return response()->json([
                'status_code' => 422,
                'status_messsage' => 'vous n\'ete pas l\'auteur de ce post ',

           ]);

        }

        return response()->json([
            'status_code' => 200,
            'status_messsage' => 'le post a ete modifier',
            'data'=>$post,
       ]);
       }
       catch(Exception $e){
        return response()->json($e);
       }



    }

    public function delete(POST $post){

        try{
            if($post->user_id == auth()->user()->id){
                $post->delete();
            }
            else{
                return response()->json([
                    'status_code' => 422,
                    'status_messsage' => 'vous n\'ete pas l\'auteur de ce post suppression non autoriser ',

               ]);

            }

         $post->delete();

         return response()->json([
             'status_code' => 200,
             'status_messsage' => 'le post a ete supprimer',
             'data'=>$post,
        ]);
        }
        catch(Exception $e){
         return response()->json($e);
        }



     }
}
