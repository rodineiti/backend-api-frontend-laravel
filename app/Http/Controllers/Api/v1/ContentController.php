<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use App\Content;

class ContentController extends Controller
{
	private $model;
  private $contentModel;

	/**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(User $model, Content $contentModel)
    {
        $this->model = $model;
        $this->contentModel = $contentModel;
    }

    public function index(Request $request)
    {
        $user = $this->model->where('id', $request->user()->id)->first();

        if (!$user) {
          return response()->json(['status' => 'error', 'message' => 'Opss. Usuário não foi encontrado, favor verifique se esta logado.']);
        }
      
        //$contents = $this->contentModel->with('user')->orderBy('published_at','DESC')->paginate(5);
      
        $friends = $user->friends()->pluck('id');
        $friends->push($user->id);
        $contents = $this->contentModel->whereIn('user_id', $friends)->with('user')->orderBy('published_at','DESC')->paginate(5);
      
        foreach($contents as $key => $content) {
          $content->total_likes = $content->likes()->count();
          $content->comments = $content->comments()->with('user')->orderBy('created_at', 'DESC')->get();
          $content->user_like_content = $user->likes()->find($content->id) ? true : false;
        }

        return response()->json(['status' => 'success', 'data' => $contents]);
    }

    public function store(Request $request)
    {
        $rules = [
            'title' => 'required|min:3|max:255',
            'text' => 'required',
        ];

        $validator = \Validator::make($request->all(), $rules);

        if ($validator->fails()) {
           return response()->json(['status' => 'error', 'errors' => $validator->errors()]);
        }

        $user = $this->model->where('id', $request->user()->id)->first();

        if (!$user) {
            return response()->json(['status' => 'error', 'message' => 'Opss. Usuário não foi encontrado, favor verifique se esta logado.']);
        }
      
        $data = $request->all();
        $data['link'] = $request->link ? $request->link : '#';
        $data['image'] = $request->image ? $request->image : '#';
        $data['published_at'] = date('Y-m-d H:s:i');
        
        $user->contents()->create($data);
      
        $contents = $this->contentModel->with('user')->orderBy('published_at','DESC')->paginate(2);

        return response()->json(['status' => 'success', 'message' => 'Conteúdo criada com sucesso', 'data' => $contents]);
    }

    public function show(Request $request, $id)
    {
        if (!$id) {
           return response()->json(['status' => 'error', 'message' => 'Conteúdo não informada']);
        }

        $user = $this->model->where('id', $request->user()->id)->first();

        if (!$user) {
            return response()->json(['status' => 'error', 'message' => 'Opss. Usuário não foi encontrado, favor verifique se esta logado.']);
        }
        
        $content = $user->contents()->find($id);

        if (!$content) {
            return response()->json(['status' => 'error', 'message' => 'Opss. Conteúdo não encontrada pra este usuário.']);
        }

        return response()->json(['status' => 'success', 'data' => $content]);
    }

    public function update(Request $request, $id)
    {
        $rules = [
            'name' => 'required|min:3|max:255'
        ];

        $validator = \Validator::make($request->all(), $rules);

        if ($validator->fails()) {
           return response()->json(['status' => 'error', 'errors' => $validator->errors()]);
        }
        
        if (!$id) {
           return response()->json(['status' => 'error', 'message' => 'Conteúdo não informada']);
        }

        $user = $this->model->where('id', $request->user()->id)->first();

        if (!$user) {
            return response()->json(['status' => 'error', 'message' => 'Opss. Usuário não foi encontrado, favor verifique se esta logado.']);
        }
        
        $content = $user->contents()->find($id);

        if (!$content) {
            return response()->json(['status' => 'error', 'message' => 'Opss. Conteúdo não encontrada pra este usuário.']);
        }

        $content->update($request->all());

        return response()->json(['status' => 'success', 'message' => 'Conteúdo atualizada com sucesso.']);
    }

    public function destroy(Request $request, $id)
    {
        if (!$id) {
           return response()->json(['status' => 'error', 'message' => 'Conteúdo não informada']);
        }

        $user = $this->model->where('id', $request->user()->id)->first();

        if (!$user) {
            return response()->json(['status' => 'error', 'message' => 'Opss. Usuário não foi encontrado, favor verifique se esta logado.']);
        }
        
        $content = $user->contents()->find($id);

        if (!$content) {
            return response()->json(['status' => 'error', 'message' => 'Opss. Conteúdo não encontrada pra este usuário.']);
        }

        $content->delete();

        return response()->json(['status' => 'success', 'message' => 'Conteúdo deletada com sucesso.']);
    }
  
    public function like(Request $request, $id)
    {
        if (!$id) {
           return response()->json(['status' => 'error', 'message' => 'Conteúdo não informada']);
        }

        $user = $this->model->where('id', $request->user()->id)->first();

        if (!$user) {
            return response()->json(['status' => 'error', 'message' => 'Opss. Usuário não foi encontrado, favor verifique se esta logado.']);
        }
        
        $content = $this->contentModel->find($id);

        if (!$content) {
            return response()->json(['status' => 'error', 'message' => 'Opss. Conteúdo não encontrada pra este usuário.']);
        }

        $user->likes()->toggle($content->id);

        return response()->json([
          'status' => 'success', 
          'message' => 'Conteúdo curtido com sucesso.', 
          'data' => $content->likes()->count(),
          'listContent' => $this->index($request)
        ]);
    }
  
    public function likePage(Request $request, $id)
    {
        if (!$id) {
           return response()->json(['status' => 'error', 'message' => 'Conteúdo não informada']);
        }

        $user = $this->model->where('id', $request->user()->id)->first();

        if (!$user) {
            return response()->json(['status' => 'error', 'message' => 'Opss. Usuário não foi encontrado, favor verifique se esta logado.']);
        }
        
        $content = $this->contentModel->find($id);

        if (!$content) {
            return response()->json(['status' => 'error', 'message' => 'Opss. Conteúdo não encontrada pra este usuário.']);
        }

        $user->likes()->toggle($content->id);

        return response()->json([
          'status' => 'success', 
          'message' => 'Conteúdo curtido com sucesso.', 
          'data' => $content->likes()->count(),
          'listContent' => $this->page($request, $content->user_id)
        ]);
    }
  
    public function comment(Request $request, $id)
    {
        $rules = [
            'text' => 'required',
        ];

        $validator = \Validator::make($request->all(), $rules);

        if ($validator->fails()) {
           return response()->json(['status' => 'error', 'errors' => $validator->errors()]);
        }

        $user = $this->model->where('id', $request->user()->id)->first();

        if (!$user) {
            return response()->json(['status' => 'error', 'message' => 'Opss. Usuário não foi encontrado, favor verifique se esta logado.']);
        }
      
        $content = $this->contentModel->find($id);

        if (!$content) {
            return response()->json(['status' => 'error', 'message' => 'Opss. Conteúdo não encontrada pra este usuário.']);
        }
      
        $data = $request->all();
        $data['content_id'] = $content->id;
        $data['text'] = $request->text;
        
        $user->comments()->create($data);
      
        return response()->json([
          'status' => 'success', 
          'message' => 'Comentário criado com sucesso.', 
          'listContent' => $this->index($request)
        ]);
    }
  
    public function commentPage(Request $request, $id)
    {
        $rules = [
            'text' => 'required',
        ];

        $validator = \Validator::make($request->all(), $rules);

        if ($validator->fails()) {
           return response()->json(['status' => 'error', 'errors' => $validator->errors()]);
        }

        $user = $this->model->where('id', $request->user()->id)->first();

        if (!$user) {
            return response()->json(['status' => 'error', 'message' => 'Opss. Usuário não foi encontrado, favor verifique se esta logado.']);
        }
      
        $content = $this->contentModel->find($id);

        if (!$content) {
            return response()->json(['status' => 'error', 'message' => 'Opss. Conteúdo não encontrada pra este usuário.']);
        }
      
        $data = $request->all();
        $data['content_id'] = $content->id;
        $data['text'] = $request->text;
        
        $user->comments()->create($data);
      
        return response()->json([
          'status' => 'success', 
          'message' => 'Comentário criado com sucesso.', 
          'listContent' => $this->page($request, $content->user_id)
        ]);
    }
  
    public function page(Request $request, $id)
    {
        $user = $this->model->where('id', $request->user()->id)->first();

        if (!$user) {
          return response()->json(['status' => 'error', 'message' => 'Opss. Usuário não foi encontrado, favor verifique se esta logado.']);
        }
      
        $userOwner = $this->model->where('id', $id)->first();

        if (!$userOwner) {
          return response()->json(['status' => 'error', 'message' => 'Opss. Usuário não foi encontrado, favor verifique.']);
        }
      
        $contents = $userOwner->contents()->with('user')->orderBy('published_at','DESC')->paginate(2);
      
        foreach($contents as $key => $content) {
          $content->total_likes = $content->likes()->count();
          $content->comments = $content->comments()->with('user')->orderBy('created_at', 'DESC')->get();
          $content->user_like_content = $user->likes()->find($content->id) ? true : false;
        }

        return response()->json(['status' => 'success', 'data' => $contents, 'user' => $userOwner]);
    }
  
    public function friend(Request $request)
    {
        $rules = [
            'id' => 'required',
        ];

        $validator = \Validator::make($request->all(), $rules);

        if ($validator->fails()) {
           return response()->json(['status' => 'error', 'errors' => $validator->errors()]);
        }
      
        $user = $this->model->where('id', $request->user()->id)->first();

        if (!$user) {
            return response()->json(['status' => 'error', 'message' => 'Opss. Usuário não foi encontrado, favor verifique se esta logado.']);
        }
      
        $friend = $this->model->where('id', $request->id)->first();
      
        if (!$friend) {
            return response()->json(['status' => 'error', 'message' => 'Opss. Usuário não foi encontrado, favor verificar.']);
        }
      
        if ($user->id == $friend->id) {
            return response()->json(['status' => 'error', 'message' => 'Opss. Você não pode seguir você mesmo.']);
        }
        
        $user->friends()->toggle($friend->id);

        return response()->json([
          'status' => 'success', 
          'message' => 'Segguindo '.$friend->name.' com sucesso.', 
          'data' => $user->friends,
          'followers' => $friend->followers
        ]);
    }
  
    public function friends(Request $request)
    {
        $user = $this->model->where('id', $request->user()->id)->first();

        if (!$user) {
          return response()->json(['status' => 'error', 'message' => 'Opss. Usuário não foi encontrado, favor verifique se esta logado.']);
        }
      
        $friends = $user->friends;
        $followers = $user->followers;

        return response()->json(['status' => 'success', 'friends' => $friends, 'followers' => $followers]);
    }
  
    public function friendspage(Request $request, $id)
    {
        $user = $this->model->where('id', $request->user()->id)->first();

        if (!$user) {
          return response()->json(['status' => 'error', 'message' => 'Opss. Usuário não foi encontrado, favor verifique se esta logado.']);
        }
      
        $my_friends = $user->friends;
      
        $oldUser = $this->model->where('id', $id)->first();
      
        if (!$oldUser) {
            return response()->json(['status' => 'error', 'message' => 'Opss. Usuário não foi encontrado, favor verificar.']);
        }
      
        $oldUser_friends = $oldUser->friends;
        $oldUser_followers = $oldUser->followers;

        return response()->json(['status' => 'success', 'friends' => $oldUser_friends, 'friends_loggedin' => $my_friends, 'followers' => $oldUser_followers]);
    }
}