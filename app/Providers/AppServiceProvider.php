<?php

namespace App\Providers;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;
use App\Models\OrderHistoryModel;
use App\Models\OrderModel;
use App\Models\StudentModel; // Make sure you import the Student model
class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot()
    {
        View::composer('*', function ($view) {
            if (Auth::check()) {
                $user = Auth::user();

                // Get the associated student_id
                $student = StudentModel::where('user_id', $user->id)->first();

                $notificationCount = 0;

                if ($student) {
                    $notificationCount = OrderHistoryModel::join('order', 'order_history.order_id', '=', 'order.order_id')
                        ->where('order.student_id', $student->student_id)
                        ->count(); // or add a filter for 'unread' if you have one
                }

                $view->with('notificationCount', $notificationCount);
            }
        });
    }
}
