<?php

namespace App\Http\Controllers;
use App\Models\Notification;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Evaluation;
use App\Models\User;
class ProvincialDirectorController extends Controller
{
    public function index()
    {
        $provincialUser = Auth::user();
        $provinceId = $provincialUser->province_ID;
        $divisionUsers = User::whereNotNull('division_ID')
            ->where('province_ID', $provinceId)
            ->get();
        $divisionUserIds = $divisionUsers->pluck('user_ID');
        $eval = Evaluation::whereIn('evaluations.user_id', $divisionUserIds)
                  ->join('users', 'evaluations.user_id', '=', 'users.user_ID')
                  ->leftJoin('divisions', 'users.division_ID', '=', 'divisions.division_ID')
                  ->select('evaluations.*', 'divisions.division')
                  ->get();
        return view('pd.dashboard', compact('eval'));
        // return view('pd.dashboard');
    }

    public function getNotifications(Request $request)
    {
        $userTypeID = auth()->user()->user_type_ID;
        $provinceID = auth()->user()->province_ID;
        $userID = auth()->user()->user_ID;

        $notifications = Notification::where('province_ID', $provinceID)
            ->where('user_type_ID', $userTypeID)
         
            ->whereNull('read_at')
            ->orderBy('created_at', 'desc')

            ->get();

        // Log::debug('Number of notifications: ' . $notifications->count());
        

        return response()->json(['notifications' => $notifications]);
    }

    public function markNotificationsAsRead(Request $request)
    {
        $userTypeID = auth()->user()->user_type_ID;
        $provinceID = auth()->user()->province_ID;

        Notification::where('user_type_ID', $userTypeID)
            ->where('province_ID', $provinceID)
            ->whereNull('read_at')
            ->update(['read_at' => now()]);

        return response()->json(['success' => true]);
    }

    public function markAsRead(Request $request)
    {
        $notificationId = $request->input('notification_id');
        $notification = Notification::findOrFail($notificationId);
        $notification->markAsRead();

        return response()->json(['success' => true]);
    }

    
    public function updateEmailHandler(Request $request)
    {
        // dd($request);
        $userType = auth()->user()->user_type_ID;
        $userPass = auth()->user()->password;

        $user = Auth::user();

        $validatedData = $request->validate([
            'current_password' => 'required',
            'email' => 'required|email',
            'new_password' => 'nullable|min:8|regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9]).{8,}$/',
        ]);

        if (Hash::check($request->current_password, $userPass)) {
            $user->email = $validatedData['email'];
            if (!empty($validatedData['new_password'])) {
                $user->password = Hash::make($validatedData['new_password']);
            }
            $user->save();
            return redirect()
                ->back()
                ->with('success', 'Email updated successfully.');
        } else {
            // Show an error message
            return redirect()
                ->back()
                ->with('error', 'Invalid Password');
        }
    }
    public function updatePasswordHandler(Request $request)
    {
        $userType = auth()->user()->user_type_ID;
        $userPass = auth()->user()->password;
        $user = Auth::user();
        if (Hash::check($request->current_password, $userPass)) {
            $user->password = Hash::make($request->new_password);
            $user->save();
            return redirect()
                ->back()
                ->with('update-pass-success', 'Password updated successfully.');
        } else {
            return redirect()
                ->back()
                ->with('update-pass-error', ' Invalid Password');
        }
    }
    public function assessment()
    {
        $provincialUser = Auth::user();
        $provinceId = $provincialUser->province_ID;
        $divisionUsers = User::whereNotNull('division_ID')
            ->where('province_ID', $provinceId)
            ->get();
        $divisionUserIds = $divisionUsers->pluck('user_ID');
        $eval = Evaluation::whereIn('evaluations.user_id', $divisionUserIds)
                  ->join('users', 'evaluations.user_id', '=', 'users.user_ID')
                  ->leftJoin('divisions', 'users.division_ID', '=', 'divisions.division_ID')
                  ->select('evaluations.*', 'divisions.division')
                  ->get();
        return view('pd.assessment', compact('eval'));
    }

    public function profile()
    {
        return view('pd.profile');
    }

    public function addtarget()
    {
        return view('pd.addtarget');
    }

    public function savetarget()
    {
        return view('pd.savetarget');
    }

    public function accomplishment()
    {
        return view('pd.accomplishment');
    }
    public function logout()
    {
        return view('components.logout');
    }
}
