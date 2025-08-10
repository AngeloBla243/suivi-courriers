<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CourrierController;


Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');


Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    // Dashboard admin (uri: /admin)
    Route::get('/', [AdminController::class, 'dashboard'])->name('dashboard');

    // Création secrétaire (uri: /admin/secretaire/create)
    Route::get('/secretaire/create', [AdminController::class, 'createSecretaire'])->name('secretaire.create');

    // Stockage secrétaire (uri: /admin/secretaire/store)
    Route::post('/secretaire/store', [AdminController::class, 'storeSecretaire'])->name('secretaire.store');

    Route::get('/courriers', [AdminController::class, 'listCourriers'])->name('courriers.index');

    // Liste des utilisateurs (uri: /admin/users)
    Route::get('/users', [AdminController::class, 'listUsers'])->name('users');

    // Edit utilisateur (uri: /admin/users/{id}/edit)
    Route::get('/users/{id}/edit', [AdminController::class, 'editUser'])->name('users.edit');

    // Update utilisateur (uri: /admin/users/{id})
    Route::put('/users/{id}', [AdminController::class, 'updateUser'])->name('users.update');

    // Delete utilisateur (uri: /admin/users/{id})
    Route::delete('/users/{id}', [AdminController::class, 'deleteUser'])->name('users.delete');
});


// Interface secrétaire
Route::middleware(['auth', 'role:secretaire'])->prefix('secretaire')->name('secretaire.')->group(function () {
    // Dashboard secrétaire (URI: /secretaire)
    Route::get('/', function () {
        return view('secretaire.dashboard'); // Assurez-vous que cette vue existe
    })->name('dashboard');
});





// Route::middleware(['auth', 'role:secretaire,admin'])->prefix('courriers')->name('courriers.')->group(function () {
//     Route::get('/', [CourrierController::class, 'index'])->name('index');
//     Route::get('/create', [CourrierController::class, 'create'])->name('create');
//     Route::post('/', [CourrierController::class, 'store'])->name('store');
//     Route::get('/{courrier}', [CourrierController::class, 'show'])->name('show');
//     Route::get('/{courrier}/edit', [CourrierController::class, 'edit'])->name('edit');
//     Route::put('/{courrier}/update', [CourrierController::class, 'update'])->name('update');
//     Route::delete('/{courrier}', [CourrierController::class, 'destroy'])->name('destroy');

//     // Route pour impression d’un courrier
//     Route::get('/{courrier}/print', [CourrierController::class, 'print'])->name('print');
// });



// Courriers envoyés (expédition)
Route::middleware(['auth', 'role:secretaire,admin'])
    ->prefix('courriers/expedition')
    ->name('courriers.expedition.')
    ->group(function () {
        Route::get('/', [CourrierController::class, 'expeditionIndex'])->name('index');
        Route::get('/create', [CourrierController::class, 'expeditionCreate'])->name('create');
        Route::post('/', [CourrierController::class, 'expeditionStore'])->name('store');
        // Route::get('courriers/expedition/pdf', [CourrierController::class, 'expeditionPdf'])->name('courriers.expedition.pdf');
        Route::get('pdf', [CourrierController::class, 'expeditionPdf'])->name('pdf');
        Route::get('/{courrier}', [CourrierController::class, 'expeditionShow'])->name('show');
        Route::get('/{courrier}/edit', [CourrierController::class, 'expeditionEdit'])->name('edit');
        Route::put('/{courrier}', [CourrierController::class, 'expeditionUpdate'])->name('update');
        Route::delete('/{courrier}', [CourrierController::class, 'expeditionDestroy'])->name('destroy');
        Route::get('/{courrier}/print', [CourrierController::class, 'expeditionPrint'])->name('print');
    });

// Courriers reçus (réception)
Route::middleware(['auth', 'role:secretaire,admin'])
    ->prefix('courriers/reception')
    ->name('courriers.reception.')
    ->group(function () {
        Route::get('/', [CourrierController::class, 'receptionIndex'])->name('index');
        Route::get('/create', [CourrierController::class, 'receptionCreate'])->name('create');
        Route::post('/', [CourrierController::class, 'receptionStore'])->name('store');
        // Pour la liste réception
        Route::get('pdf', [CourrierController::class, 'receptionPdf'])->name('pdf');
        Route::get('/{courrier}', [CourrierController::class, 'receptionShow'])->name('show');
        Route::get('/{courrier}/edit', [CourrierController::class, 'receptionEdit'])->name('edit');
        Route::put('/{courrier}', [CourrierController::class, 'receptionUpdate'])->name('update');
        Route::delete('/{courrier}', [CourrierController::class, 'receptionDestroy'])->name('destroy');
        Route::get('/{courrier}/print', [CourrierController::class, 'receptionPrint'])->name('print');
    });


// Profil modifiable
Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


require __DIR__ . '/auth.php';
