<?php

use App\Http\Controllers\Admin\BlogTrashController;
use App\Http\Controllers\Admin\UserBlogManagerController;
use App\Http\Controllers\BlogController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\UserManagerController;
use App\Http\Controllers\Admin\UserProfileController;
use App\Http\Controllers\Admin\AuthController as AdminAuth;
use App\Http\Controllers\Admin\BlogController as AdminBlog;
use App\Http\Controllers\Admin\IndexController as Admin;

Route::controller(AdminAuth::class)->group(function () {
	Route::middleware(['guest'])->group(function () {
		Route::get('/admin/auth', 'login')->name('admin.auth');
		Route::post('/admin/auth', 'authenticate');
	});

	Route::post('/admin/auth/logout', 'logout')->middleware(['auth'])->name('admin.auth.logout');
});

Route::group(['controller' => Admin::class, 'middleware' => ['auth']], function () {
	Route::redirect('/admin', '/admin/dashboard');
	Route::get('/admin/dashboard', 'index')->name('admin.dashboard');
});

Route::group(['controller' => UserManagerController::class, 'middleware' => 'auth'], function () {
	Route::get('/admin/user', 'index')->name('manager.user');
	Route::get('/admin/user/create', 'create')->name('manager.user.create');
	Route::post('/admin/user/create', 'store')->name('manager.user.store');
	Route::get('/admin/user/{user:username}', 'profile')->name('manager.user.profile');
	Route::get('/admin/user/{user:username}/edit', 'edit')->name('manager.user.edit');
	Route::patch('/admin/user/{user:username}/edit', 'update')->name('manager.user.update');
	Route::patch('/admin/user/{user:username}/edit/password', 'changePassword')->name('manager.user.update.password');
	Route::delete('/admin/user/{user}/delete', 'destroy')->name('manager.user.delete');
});

Route::group(['controller' => UserBlogManagerController::class, 'middleware' => 'auth'], function () {
	Route::get('/admin/user/{user:username}/blog', 'index')->name('manager.user.blog');
});

Route::group(['controller' => BlogTrashController::class, 'middleware' => 'auth'], function () {
	Route::get('/admin/blog/trash', 'viewAny')->name('admin.blog.trash');
	Route::patch('/admin/blog/trash/{blog:slug}/restore', 'restore')->name('admin.blog.trash.restore')->withTrashed();
	Route::patch('/admin/blog/trash/restore-all', 'restoreAll')->name('admin.blog.trash.restore-all')->withTrashed();
	Route::delete('/admin/blog/trash/{blog:slug}/force-delete', 'forceDelete')->name('admin.blog.trash.force-delete')->withTrashed();
	Route::delete('/admin/blog/trash/force-delete-all', 'forceDeleteAll')->name('admin.blog.trash.force-delete-all')->withTrashed();
	Route::get('/admin/blog/trash/{blog:slug}', 'view')->name('admin.blog.trash.view')->withTrashed();
});

Route::group(['controller' => AdminBlog::class, 'middleware' => ['auth']], function () {
	Route::get('/admin/blog', 'index')->name('admin.blog');
	Route::get('/admin/blog/create', 'create')->name('admin.blog.create');
	Route::post('/admin/blog/create', 'store')->name('admin.blog.store');
	Route::get('/admin/blog/{blog:slug}', 'view')->name('admin.blog.show')->withTrashed();
	Route::delete('/admin/blog/{blog:slug}', 'delete')->name('admin.blog.destroy')->withTrashed();
	Route::get('/admin/blog/{blog:slug}/edit', 'edit')->name('admin.blog.edit');
	Route::patch('/admin/blog/{blog:slug}/edit', 'update')->name('admin.blog.update');
	Route::patch('/admin/blog/{blog:slug}/upload', 'upload')->name('admin.blog.upload');
});

Route::group(['controller' => UserProfileController::class, 'middleware' => 'auth'], function () {
	Route::get('/admin/profile', 'index')->name('admin.profile');
	Route::get('/admin/profile/edit', 'edit')->name('admin.profile.edit');
	Route::patch('/admin/profile/edit', 'update')->name('admin.profile.update');
	Route::patch('/admin/profile/edit/password', 'changePassword')->name('admin.profile.update.password');
});

Route::group(['controller' => BlogController::class], function () {
	Route::get('/', 'index')->name('index');
	Route::get('/{blog:slug}', 'view')->name('blog.view');
});
