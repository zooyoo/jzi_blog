<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

/*Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index');*/


//简单任务管理系统路由

///*
// * 显示所有路由
// */
//Route::get('/',function (){
//    $tasks = \App\Task::orderBy('created_at','asc') -> get();
//    return view('tasks',[
//        'tasks' => $tasks
//    ]);
//});
//
///*
// * 添加新任务
// */
//Route::post('/task',function (Request $request){
//    $validate = Validator::make($request -> all(),[
//        'name' => 'required|max:255',
//    ]);
//
//    if($validate->fails()){
//        return redirect('/') -> withInput() -> withErrors($validate);
//    }
//
//    $task = new \App\Task();
//    $task->name = $request->name;
//    $task->save();
//
//    return redirect('/');
//});
//
///*
// * 删除任务
// */
//Route::delete('/task/{id}', function ($id){
//    \App\Task::findOrFail($id)->delete();
//    return redirect('/');
//});

//博客页面
Route::get('/', function () {
    return redirect('/blog');
});

Auth::routes();

Route::get('blog', 'BlogController@index');
Route::get('blog/{slug}', 'BlogController@showPost');


//管理区
//资源路由
Route::get('admin', function(){
    return redirect('/admin/post');
});

Route::group(['namespace' => 'Admin', 'middleware' => 'auth'], function (){
    Route::resource('admin/post', 'PostController');
    Route::resource('admin/tag', 'TagController');
    //Route::get('admin/upload', 'UploadController@index');
});


//登录登出
Route::get('/auth/login', 'Auth\AuthController@Login');
Route::post('/auth/login', 'Auth\AuthController@postLogin');
Route::get('/auth/logout', 'Auth\AuthController@logout');




Route::get('/tasks', 'TaskController@index');
Route::post('/tasks', 'TaskController@store');
Route::delete('/tasks/{task}', 'TaskController@destroy');
























Auth::routes();

Route::get('/home', 'HomeController@index');
