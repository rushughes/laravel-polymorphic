<?php

use App\Staff;
use App\Photo;
use App\Product;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/create/{id}/{path}', function ($id, $path) {
  $staff = Staff::findOrFail($id);
  $staff->photos()->create(['path'=>$path]);
});

Route::get('/read/{id}', function ($id) {
  $staff = Staff::findOrFail($id);
  foreach ($staff->photos as $photo) {
    echo $photo->path . '<br />';
  }
});

Route::get('/update/{id}/{photo_id}/{path}', function ($id, $photo_id, $path) {
  $staff = Staff::findOrFail($id);
  $photo = $staff->photos()->whereId($photo_id)->first();
  $photo->path = $path;
  $photo->save();
});

Route::get('/delete/{id}/{photo_id}', function ($id, $photo_id) {
  $staff = Staff::findOrFail($id);
  $staff->photos()->whereId($photo_id)->delete();
});

Route::get('/assign/{id}/{photo_id}', function ($id, $photo_id ) {
  $staff = Staff::findOrFail($id);
  $photo = Photo::findOrFail($photo_id);
  $staff->photos()->save($photo);
});

Route::get('/unassign/{id}/{photo_id}', function ($id, $photo_id ) {
  // we cant really do this because the database constraints arent letting us
  // also its dumb to do this and just leave unreferenced data about
  $staff = Staff::findOrFail($id);
  $staff->photos()->whereId($photo_id)->update(['imageable_id' => '', 'imageable_type' => '']);
});
