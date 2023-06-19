<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(static function () {
    Route::get('/status', function (Request $request) {
        return response()->json([
            'status' => 'OK',
        ]);
    })->name('v1.status');

    Route::prefix('products')->namespace('Product')->group(static function () {
        Route::post('/', CreateProductController::class)->name('v1.product.create');
        Route::post('/{id}', UpdateProductController::class)->name('v1.product.update');
        Route::delete('/{id}', DeleteProductController::class)->name('v1.product.delete');
    });

    Route::prefix('contacts')->namespace('Contact')->group(static function () {
        Route::get('/', GetContactsController::class)->name('v1.contact.index');
    });

    Route::prefix('Github')->namespace('Github')->group(static function () {
        Route::get('/repositories/starred', GetStarredRepositoriesController::class)->name('v1.repositories.starred');
        Route::post('/', SaveTokenController::class)->name('v1.github_token.store');
        Route::delete('/token', DeleteTokenController::class)->name('v1.github_token.delete');
    });

    Route::prefix('blog')->namespace('Blog')->group(static function () {
        Route::post('/', CreateBlogController::class)->name('v1.blog.create');
        Route::post('/{id}', UpdateBlogController::class)->name('v1.blog.update');
        Route::delete('/{id}', BlogDeleteController::class)->name('v1.blog.delete');
    });

    Route::prefix('users')->group(static function () {
        Route::post('/{user_id}', UserProfileUpdateController::class)->name('v1.user.update');
        Route::delete('/{user_id}', User\UserDeactivateController::class)->name('v1.user.delete');
    });

    Route::prefix('teams')->group(static function () {
        Route::get('/', Team\TeamIndexController::class)->name('v1.teams.index');
    });

    Route::prefix('tasks')->group(static function () {
        Route::post('/', Task\CreateTaskController::class)->name('v1.tasks.create');
    });

    Route::prefix('admin')->group(static function () {
        Route::prefix('roles')->group(static function () {
            Route::post('/', Admin\Roles\CreateRoleController::class)->name('roles.create');
        });
        Route::prefix('users')->group(static function () {
            Route::get('/', Admin\AdminGetUsersController::class)->name('admin.users');
            Route::delete('/', Admin\Users\AdminDeleteUserController::class)->name('admin.users.delete');
        });
        Route::prefix('users')->group(static function () {
            Route::get('/', Admin\AdminGetUsersController::class)->name('admin.users');
            Route::delete('/', Admin\Users\AdminDeleteUserController::class)->name('admin.users.delete');
        });

        Route::prefix('user-roles')->group(static function () {
            Route::post('/', Admin\Roles\AddUserRoleController::class)->name('user-role.create');
            Route::delete('/', Admin\Roles\RemoveRoleController::class)->name('user-role.delete');
        });

        Route::prefix('teams')->group(static function () {
            Route::post('/', Team\CreateTeamController::class)->name('v1.teams.create');
            Route::post('/{team_id}', Team\UpdateTeamController::class)->name('v1.teams.update');
            Route::post('/{team_id}/users', Team\AddUserToTeamController::class)->name('v1.teams.adduser');
            Route::delete('/{team_id}/users', Team\RemoveUserFromTeamController::class)->name('v1.teams.removeuser');

        });
    });

    Route::prefix('user')->group(static function () {
        Route::get('/', UserController::class)->name('v1.user');

    });
});
