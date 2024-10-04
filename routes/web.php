<?php

use App\Http\Controllers\AdoptionFormController;
use App\Http\Controllers\OngController;
use App\Http\Controllers\PublicProfileController;
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
use App\Http\Controllers\SupportRequestController;
use App\Models\OngEvent;
use App\Models\Message;
use Illuminate\Http\Request;

Route::get('/', function () {
    return view('welcome');
})->name('home');

// Authentication Routes
Route::post('/register', [RegisterController::class, 'store'])->name('register');
Route::get('/login', function (Request $request) {
    $redirectTo = $request->query('redirectTo', null);
    return Auth::check() ? redirect()->route(Auth::user()->user_type . '.dashboard') : view('auth.login', compact('redirectTo'));
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
    Route::get('/dashboard', function () {
        switch (Auth::user()->user_type) {
            case 'tutor':
                return redirect()->route('tutor.dashboard');
            case 'ong':
                return redirect()->route('ong.dashboard');
            case 'admin':
                return redirect()->route('admin.dashboard');
            default:
                return view('dashboard');
        }
    })->name('dashboard');
});




// Rotas Protegidas - Pets (Apenas para usuários autenticados)
Route::middleware('auth')->group(function () {
    // Exibir o formulário para criar um novo pet
    Route::get('/pets/create', [PetController::class, 'create'])->name('pets.create');

    // Exibir o formulário para editar um pet específico
    Route::get('/pets/{pet}/edit', [PetController::class, 'edit'])->name('pets.edit');

    // Listar todos os pets do usuário autenticado (página inicial dos pets do usuário)
    Route::get('/pets', [PetController::class, 'index'])->name('pets.index');

    // Armazenar os detalhes de um novo pet
    Route::post('/pets', [PetController::class, 'store'])->name('pets.store');

    // Atualizar um pet específico
    Route::put('/pets/{pet}', [PetController::class, 'update'])->name('pets.update');

    // Excluir um pet específico
    Route::delete('/pets/{pet}', [PetController::class, 'destroy'])->name('pets.destroy');

    // Exibir os pets do usuário autenticado
    Route::get('/my-pets', [PetController::class, 'myPets'])->name('pets.my-pets');

    // Favoritar/desfavoritar um pet específico
    Route::post('/pets/{id}/favorite', [PetController::class, 'favorite'])->name('pets.favorite');

    // Exibir pets favoritos do usuário autenticado
    Route::get('/favorites', [PetController::class, 'favorites'])->name('pets.favorites');

    // Listar pets adotados pelo usuário autenticado
    Route::get('/my-adopted-pets', [PetController::class, 'adoptedPets'])->name('pets.adopted');
});

// Rotas Públicas - Pets
Route::get('/all-pets', [PetController::class, 'allPets'])->name('pets.all-pets'); // Página pública para listar todos os pets
Route::get('/pets/{pet}', [PetController::class, 'show'])->name('pets.show'); // Página pública para exibir um pet específico



//ROTAS PUBLICAS INICIO
Route::get('/ong-events', [OngEventController::class, 'index'])->name('ong-events.index');
Route::get('/ong-events/{id}', [OngEventController::class, 'show'])->name('ong-events.show');
Route::get('/temporary-housing', [TemporaryHousingController::class, 'index'])->name('temporary-housing.index');
Route::get('/all-ongs', [OngController::class, 'index'])->name('ongs.index');
Route::get('/user/public-profile/{id}', [PublicProfileController::class, 'show'])->name('user.public-profile');
//ROTAS PUBLICAS FIM


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



Route::middleware('auth')->group(function () {
    // Rota para listar todas as solicitações de suporte
    Route::get('/admin/support', [SupportRequestController::class, 'adminIndex'])->name('admin.support.index');

    // Rota para exibir os detalhes de uma solicitação de suporte específica (essa é a que está faltando)
    Route::get('/admin/support/{supportRequest}', [SupportRequestController::class, 'adminShow'])->name('admin.support.show');

    // Rota para encerrar uma solicitação de suporte
    Route::post('/admin/support/{supportRequest}/close', [SupportRequestController::class, 'close'])->name('admin.support.close');
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
});

// Routes restricted to 'ong'
Route::middleware(['auth', 'user_type:ong'])->group(function () {
    Route::get('/ong/dashboard', function () {
        $events = OngEvent::where('ong_id', Auth::user()->ong->id)->get();
        return view('ong.dashboard', compact('events'));
    })->name('ong.dashboard');
    Route::get('/ong-events/create', [OngEventController::class, 'create'])->name('events.create');

    Route::post('/ong-events', [OngEventController::class, 'store'])->name('events.store');
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


// Notifications
Route::post('/notifications/{id}/mark-as-read', [UserController::class, 'markNotificationAsRead'])->name('notifications.markAsRead');

// Messages SSE
Route::get('/messages/sse/{recipientId}', function ($recipientId) {
    $userId = Auth::id();

    return response()->stream(function () use ($userId, $recipientId) {
        while (true) {
            $messages = Message::where('sender_id', $recipientId)
                ->where('recipient_id', $userId)
                ->where('is_read', false)
                ->get();
            if ($messages->count() > 0) {
                echo "data: " . json_encode($messages) . "\n\n";
                ob_flush();
                flush();
                sleep(5);
            }
        }
    }, 200, [
        'Content-Type' => 'text/event-stream',
        'Cache-Control' => 'no-cache',
        'Connection' => 'keep-alive',
    ]);
})->middleware('auth');

// Route to handle message reading
Route::post('/messages/read/{messageId}', function ($messageId) {
    $message = Message::find($messageId);
    $message->is_read = true;
    $message->save();
    return response()->json(['status' => 'success']);
})->middleware('auth');


Route::get('/admin/user-details/{id}', [AdminDashboardController::class, 'showUserDetails'])->name('admin.user-details');
