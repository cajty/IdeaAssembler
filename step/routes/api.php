<?php




use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ComponetController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\IdeaController;
use App\Http\Controllers\SearchTopicController;
use App\Http\Controllers\StatisticsController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\TopicController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;

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

Route::get('/ideas/user', [IdeaController::class, 'getUserIdeas']);
Route::post('/ideas', [IdeaController::class, 'store']);
Route::get('/ideas/{idea}', [IdeaController::class, 'show']);
Route::put('/ideas/{idea}', [IdeaController::class, 'update']);
Route::delete('/ideas/{idea}', [IdeaController::class, 'destroy']);



Route::middleware('auth:sanctum')->get('/usere', function (Request $request) {
    return $request->user();
});


    Route::get('/category',[CategoryController::class,'showCategory'])->name('show.category');
Route::post('/category',[CategoryController::class,'storeCategory'])->name('store.category');
Route::delete('/category/{id}',[CategoryController::class,'deleteCategory'])->name('delet.category');
Route::put('/category/{id}',[CategoryController::class,'editCategory'])->name('update.category');


Route::get('/groups', [GroupController::class, 'getUserGroup']);
Route::post('/groups', [GroupController::class, 'create']);
Route::get('/groups/{group}', [GroupController::class, 'show'])->name('groupShow');
Route::put('/groups/{group}', [GroupController::class, 'update']);
Route::delete('/groups/{group}', [GroupController::class, 'destroy']);
Route::delete('/groups/{group}/components/{component}', [GroupController::class, 'destroyComponent']);


Route::post('/like/{topicId}/{userId}/', [FeedbackController::class, 'addLike']);
Route::post('/dislike/{topicId}/{userId}', [FeedbackController::class, 'addDislike']);
Route::get('/feedback/{topicId}/{userId}', [FeedbackController::class, 'getFeedback']);





Route::get('/user/topics', [TopicController::class, 'getUserTopic']);
Route::get('/userlike/topics', [TopicController::class, 'getLikeTopic']);
Route::post('/topics', [TopicController::class, 'create']);
Route::get('/topics/{topic}', [TopicController::class, 'show']);
Route::put('/topics/{topic}', [TopicController::class, 'update']);
Route::delete('/topics/{topic}', [TopicController::class, 'destroy']);
Route::delete('/topics/{topic}/groups/{group}', [TopicController::class, 'removedGroup']);
Route::post('/topics/{topic}/groups/{group}', [TopicController::class, 'addGroup']);

Route::post('/topics/{topic}/public',[TopicController::class, 'makePublic']);



Route::get('/search',[SearchTopicController::class,'search']);



Route::post('/topics/{topic}/tags', [TopicController::class, 'updateTag']);


Route::get('/tag', [TagController::class, 'allTag']);
Route::post('/tag', [TagController::class, 'storeTag']);
Route::delete('/tag/{id}', [TagController::class, 'deleteTag']);
Route::put('/tag/{id}', [TagController::class, 'editTag']);



Route::get('/getUser',[UserController::class,'getUsers']);
Route::put('/inbanndUser/{user}',[UserController::class,'inbanndUser']);
Route::put('/banedUser/{user}',[UserController::class,'banndUser']);

Route::get('/componet', function () {
    return response()->json(['message' => 'Welcome to the componet endpoint!']);
});

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout']);
Route::get('/getuser', [AuthController::class, 'getUser']);

Route::post('/groups/{group}/componentss', [ComponetController::class, 'createComponent']);
Route::put('/groups/{group}/components/{component}', [ComponetController::class, 'updateComponent']);




Route::get('/statistic', [StatisticsController::class, 'statistics']);











