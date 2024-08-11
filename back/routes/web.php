<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\CalendarController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\StatistiquesController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('home.index');
});

Route::get('/', [AdminController::class, 'home']);

Route::get('/create_chambre', [AdminController::class, 'create_chambre']);
Route::post('/add_chambre', [AdminController::class, 'add_chambre']);
Route::get('/view_chambre', [AdminController::class, 'view_chambre'])->name('view_chambre');
Route::delete('/delete_chambre/{id}', [AdminController::class, 'delete_chambre'])->name('delete_chambre');

Route::get('/edit_chambre/{id}', [AdminController::class, 'edit_chambre'])->name('edit_chambre');
Route::post('/edit_chambre/{id}', [AdminController::class, 'update_chambre'])->name('update_chambre');

//salle
Route::get('/create_salle', [AdminController::class, 'create_salle']);
Route::post('/add_salle', [AdminController::class, 'add_salle']);
Route::get('/view_salle', [AdminController::class, 'view_salle'])->name('view_salle');
Route::delete('/delete_salle/{id}', [AdminController::class, 'delete_salle'])->name('delete_salle');

Route::get('/edit_salle/{id}', [AdminController::class, 'edit_salle'])->name('edit_salle');
Route::post('/edit_salle/{id}', [AdminController::class, 'update_salle'])->name('update_salle');

//reservation-chambre
Route::get('/planning_reservation', [ReservationController::class, 'planning_reservation'])->name('planning_reservation');
Route::get('/annuler_reservation/{ID}', [ReservationController::class, 'annuler_reservation'])->name('annuler_reservation');
// Route
Route::get('/get_reservations', [ReservationController::class, 'getReservations']);

//facture
Route::get('/invoice/{id}', [ReservationController::class, 'generateInvoice'])->name('generate_invoice');

//statistique
Route::get('/statistiques', [StatistiquesController::class, 'index'])->name('home.statistiques');
//Route::get('/statistiques', [StatistiquesController::class, 'reservationsParAn'])->name('home.statistiques');




Route::get('/create_reservation', [ReservationController::class, 'create_reservation'])->name('create_reservation');


Route::post('/add_reservation', [ReservationController::class, 'add_reservation'])->name('add_reservation');
Route::get('/view_reservations', [ReservationController::class, 'view_reservations'])->name('view_reservations');
Route::get('/edit_reservation/{ID}', [ReservationController::class, 'edit_reservation'])->name('edit_reservation');
Route::post('/update_reservation/{ID}', [ReservationController::class, 'update_reservation'])->name('update_reservation');

//notif
Route::post('/notifications/mark-all-as-read', [NotificationController::class, 'markAllAsRead'])->name('notifications.markAllAsRead');

