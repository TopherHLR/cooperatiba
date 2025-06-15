<?php

namespace App\Providers;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;
use App\Models\OrderHistoryModel;
use App\Models\OrderModel;
use App\Models\ChatModel;
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
                $chatCount = 0;

                if ($student) {
                    $notificationCount = OrderHistoryModel::join('order', 'order_history.order_id', '=', 'order.order_id')
                        ->where('order.student_id', $student->student_id)
                        ->where('order_history.is_read', false) // ✅ Only count unread
                        ->count();
                    // Count unread chat messages from admin
                    $chatCount = ChatModel::where('student_id', $student->user_id)
                        ->where('sent_by', 'admin')
                        ->where('is_read', false)
                        ->count();
                }


                // Share with all views
                $view->with([
                    'notificationCount' => $notificationCount,
                    'chatCount' => $chatCount,
                ]);
            }
        });
    }
}
