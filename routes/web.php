<?php

use App\Http\Controllers\AboutController;
use App\Http\Controllers\AdoptionFormController;
use App\Http\Controllers\OngController;
use App\Http\Controllers\PublicProfileController;
use App\Http\Controllers\TestController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\OngEventController;
use App\Http\Controllers\PetController;
use App\Http\Controllers\ProfileEditController;
use App\Http\Controllers\TemporaryHousingController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\AdminFaqController;
use App\Http\Controllers\AdminFooterController;
use App\Http\Controllers\AdminPolicyController;
use App\Http\Controllers\AdminTermsController;
use App\Http\Controllers\FaqController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\SupportRequestController;
use App\Models\OngEvent;
use App\Models\Message;
use Illuminate\Http\Request;

use App\Http\Controllers\CommentController;

Route::get('/', [HomeController::class, 'index'])->name('home');

// Authentication Routes
Route::post('/register', [RegisterController::class, 'store'])->name('register');
Route::get('/login', function (Request $request) {
    $redirectTo = $request->query('redirectTo');
    return Auth::check() ? redirect()->route(Auth::user()->user_type . '.dashboard') : view('auth.login', ['redirectTo' => $redirectTo]);
})->name('login');


Route::post('/login', [AuthenticatedSessionController::class, 'store']);
Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

// Profile Routes
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/user/profile/edit', [ProfileEditController::class, 'edit'])->name('profile.edit');
    Route::put('/user/profile', [ProfileEditController::class, 'update'])->name('profile.update');
});

// Route Group for Authenticated Users
Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->group(function () {
    Route::get('/dashboard', [UserController::class, 'redirectToDashboard'])->name('dashboard');
});



// Pets (Only Authenticated Users)
Route::middleware('auth')->group(function () {

    Route::get('/pets/create', [PetController::class, 'create'])->name('pets.create');
    Route::get('/pets/{pet}/edit', [PetController::class, 'edit'])->name('pets.edit');
    Route::get('/pets', [PetController::class, 'index'])->name('pets.index');
    Route::post('/pets', [PetController::class, 'store'])->name('pets.store');
    Route::put('/pets/{pet}', [PetController::class, 'update'])->name('pets.update');
    Route::delete('/pets/{pet}', [PetController::class, 'destroy'])->name('pets.destroy');
    Route::get('/my-pets', [PetController::class, 'myPets'])->name('pets.my-pets');
    Route::post('/pets/{id}/favorite', [PetController::class, 'favorite'])->name('pets.favorite');
    Route::get('/favorites', [PetController::class, 'favorites'])->name('pets.favorites');
    Route::get('/my-adopted-pets', [PetController::class, 'adoptedPets'])->name('pets.adopted');
});

// Public Routes
Route::get('/all-pets', [PetController::class, 'allPets'])->name('pets.all-pets');
Route::get('/pets/{pet}', [PetController::class, 'show'])->name('pets.show');
Route::get('/ong-events', [OngEventController::class, 'index'])->name('ong-events.index');
Route::get('/ong-events/{id}', [OngEventController::class, 'show'])->name('ong-events.show');
Route::get('/temporary-housing', [TemporaryHousingController::class, 'index'])->name('temporary-housing.index');
Route::get('/all-ongs', [OngController::class, 'index'])->name('ongs.index');
Route::get('/user/public-profile/{id}', [PublicProfileController::class, 'show'])->name('user.public-profile');
Route::get('/posts', [PostController::class, 'index'])->name('posts.index');
Route::get('/posts/{post}', [PostController::class, 'show'])->name('posts.show');
Route::get('/faqs', [AdminFaqController::class, 'show'])->name('faqs.show');
Route::get('/sobre', [AboutController::class, 'index'])->name('about');

Route::get('/terms-of-service', [AdminTermsController::class, 'show'])->name('terms.show');
Route::get('/privacy-policy', [AdminPolicyController::class, 'show'])->name('policy.show');




// Adoption Form Routes
Route::middleware('auth')->group(function () {
    Route::resource('adoption-form', AdoptionFormController::class)->only(['create', 'store']);
    Route::get('/adoption-form/received', [AdoptionFormController::class, 'received'])->name('adoption-form.received');
    Route::get('/adoption-form/submitted', [AdoptionFormController::class, 'submitted'])->name('adoption-form.submitted');
    Route::get('/adoption-form/{adoptionForm}', [AdoptionFormController::class, 'show'])->name('adoption-form.show');
    Route::put('/adoption-form/{adoptionForm}/status/{status}', [AdoptionFormController::class, 'updateStatus'])->name('adoption-form.update-status');
    Route::get('/adoption-form/create/{pet}', [AdoptionFormController::class, 'create'])->name('adoption-form.create');
    Route::post('/adoption-form/{pet}', [AdoptionFormController::class, 'store'])->name('adoption-form.store');
    Route::delete('/adoption-form/{adoptionForm}/cancel', [AdoptionFormController::class, 'cancel'])->name('adoption-form.cancel');
    Route::get('/adoption-forms', [AdoptionFormController::class, 'index'])->name('adoption-forms.index');
});


// Message Routes
Route::middleware('auth')->group(function () {
    Route::get('/messages/inbox', [MessageController::class, 'inbox'])->name('messages.inbox');
    Route::get('/messages/conversation/{user}', [MessageController::class, 'conversation'])->name('messages.conversation');
    Route::post('/messages/send/{user}', [MessageController::class, 'send'])->name('messages.send');
    Route::post('/messages/{user}', [MessageController::class, 'store'])->name('messages.store');
    // Notifications
    Route::post('/notifications/{id}/mark-as-read', [UserController::class, 'markNotificationAsRead'])->name('notifications.markAsRead');


    // Route to handle message reading
    Route::post('/messages/read/{messageId}', function ($messageId) {
        $message = Message::find($messageId);
        $message->is_read = true;
        $message->save();
        return response()->json(['status' => 'success']);
    })->middleware('auth');
});


// Profile Editing Routes
Route::middleware('auth')->group(function () {
    Route::get('/user/edit', [ProfileEditController::class, 'edit'])->name('user.edit');
    Route::put('/user/profile', [ProfileEditController::class, 'update'])->name('profile.update');
});


// Support Request Routes
Route::middleware('auth')->group(function () {
    Route::get('/support', [SupportRequestController::class, 'index'])->name('support.index'); // List user's requests
    Route::get('/support/create', [SupportRequestController::class, 'create'])->name('support.create'); // Create a new request
    Route::post('/support', [SupportRequestController::class, 'store'])->name('support.store'); // Store new request
    Route::get('/support/{supportRequest}', [SupportRequestController::class, 'show'])->name('support.show'); // View request details (chat)
    Route::post('/support/{supportRequest}/message', [SupportRequestController::class, 'sendMessage'])->name('support.message'); // Send message in chat
});


// Routes restricted to 'admin'
Route::middleware(['auth', 'user_type:admin'])->group(function () {

    Route::get('/admin/dashboard', [AdminDashboardController::class, 'adminDashboard'])->name('admin.dashboard');

    Route::post('/admin/update-user/{user}', [AdminDashboardController::class, 'updateUser'])->name('admin.update-user');
    Route::get('/admin/manage-users', [AdminDashboardController::class, 'manageUsers'])->name('admin.manage-users');
    Route::delete('/admin/delete-user/{user}', [AdminDashboardController::class, 'deleteUser'])->name('admin.delete-user');

    Route::get('/admin/manage-pets', [AdminDashboardController::class, 'managePets'])->name('admin.manage-pets');
    Route::delete('/admin/delete-pet/{pet}', [AdminDashboardController::class, 'deletePet'])->name('admin.delete-pet');

    Route::get('/admin/manage-events', [AdminDashboardController::class, 'manageEvents'])->name('admin.manage-events');
    Route::delete('/admin/delete-event/{event}', [AdminDashboardController::class, 'deleteEvent'])->name('admin.delete-event');

    Route::get('/admin/support', [SupportRequestController::class, 'adminIndex'])->name('admin.support.index'); // List all requests

    Route::get('/admin/support/{supportRequest}/details', [SupportRequestController::class, 'adminShow'])->name('admin.support.details');
    Route::post('/admin/support/{supportRequest}/close', [SupportRequestController::class, 'close'])->name('admin.support.close');
    Route::get('/admin/manage-forms', [AdminDashboardController::class, 'manageForms'])->name('admin.manage-forms');
    Route::get('/admin/user-details/{id}', [AdminDashboardController::class, 'showUserDetails'])->name('admin.user-details');

    Route::get('/admin/support', [SupportRequestController::class, 'adminIndex'])->name('admin.support.index');
    Route::get('/admin/support/{supportRequest}', [SupportRequestController::class, 'adminShow'])->name('admin.support.show');
    Route::post('/admin/support/{supportRequest}/close', [SupportRequestController::class, 'close'])->name('admin.support.close');

    //Blog Posts
    Route::get('/admin/posts/create', [PostController::class, 'create'])->name('posts.create');
    Route::post('/admin/posts', [PostController::class, 'store'])->name('posts.store');
    Route::get('/posts/{post}/edit', [PostController::class, 'edit'])->name('posts.edit');
    Route::put('/posts/{post}', [PostController::class, 'update'])->name('posts.update');
    Route::delete('/posts/{post}', [PostController::class, 'destroy'])->name('posts.destroy');


    Route::get('/admin/faqs/edit', [AdminFaqController::class, 'edit'])->name('faqs.edit');
    Route::post('/admin/faqs/store', [AdminFaqController::class, 'store'])->name('faqs.store');
    Route::post('/admin/faqs/update', [AdminFaqController::class, 'update'])->name('faqs.update');

   Route::get('/admin/terms/edit', [AdminTermsController::class, 'edit'])->name('admin.terms.edit');
   Route::post('/admin/terms/store', [AdminTermsController::class, 'store'])->name('admin.terms.store');
   Route::post('/admin/terms/update', [AdminTermsController::class, 'update'])->name('admin.terms.update');

   Route::get('/admin/policy/edit', [AdminPolicyController::class, 'edit'])->name('admin.policy.edit');
   Route::post('/admin/policy/store', [AdminPolicyController::class, 'store'])->name('admin.policy.store');
   Route::post('/admin/policy/update', [AdminPolicyController::class, 'update'])->name('admin.policy.update');

   Route::get('/footer/edit', [AdminFooterController::class, 'edit'])->name('admin.footer.edit');
   Route::put('/footer/update', [AdminFooterController::class, 'update'])->name('admin.footer.update');

});


//Blog comments
Route::middleware('auth')->group(function () {
    // Rota para adicionar comentários (usuário logado)
    Route::post('posts/{post}/comments', [CommentController::class, 'store'])->middleware('auth')->name('comments.store');

    // Rota para excluir comentários (autorizada para o autor ou admin)
    Route::delete('comments/{comment}', [CommentController::class, 'destroy'])->middleware('auth')->name('comments.destroy');
});


// Routes restricted to 'ong'
Route::middleware(['auth', 'user_type:ong'])->group(function () {
    Route::get('/ong/dashboard', function () {
        $events = OngEvent::where('ong_id', Auth::user()->ong->id)->get();
        return view('ong.dashboard', compact('events'));
    })->name('ong.dashboard');
    Route::get('/ong-events/create', [OngEventController::class, 'create'])->name('events.create');
    Route::get('/events/criar', [OngEventController::class, 'criar'])->name('events.criar');
    Route::post('/ong-events', action: [OngEventController::class, 'store'])->name('events.store');
    Route::get('/my-events', [OngEventController::class, 'myEvents'])->name('ong-events.my-events');
    Route::put('/ong-events/{id}', [OngEventController::class, 'update'])->name('events.update');
    Route::get('/ong-events/{event}/edit', [OngEventController::class, 'edit'])->name('events.edit');
    Route::delete('/ong-events/{event}', [OngEventController::class, 'destroy'])->name('events.destroy');
});



// Routes restricted to 'tutor'
Route::middleware(['auth', 'user_type:tutor'])->group(function () {
    Route::get('/tutor/dashboard', function () {
        return view('tutor.dashboard');
    })->name('tutor.dashboard');
});


