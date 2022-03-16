<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');

    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('admin.dashboard');
    }
    
    public function editStats($id)
    {
        
        $stats = Stats::with('user')->find($id);
        // $users = User::all()->except(Auth::id())->sortByDesc('id');
        return view('admin.editStats', [
            // 'users' => $users,
            'stats' => $stats,
            // 'payoutRequests' => $payoutRequests,
        ]);
    }
    public function payments()
    {
        $payments = Payments::with('user')->orderBy('id', 'desc')->paginate(75);
        return view('admin.payment', [
            'payments' => $payments,
        ]);
    }
    public function usersList()
    {
        $users = User::where('id', '!=', 1)->orderBy('id', 'desc')->paginate(75);
        return view ('admin.users', [
            'users' => $users,
        ]);
        
    }

    public function setting()
    {
        return view('admin.setting');
    }

    public function deleteUser($id)
    {
        $stats = Stats::where('user_id', $id)->get();
        foreach ($stats as $stat) {
            $stat->delete();
        }
        $domains = Domains::where('user_id', $id)->get();
        foreach ($domains as $domain) {
            $domain->delete();
        }
        $payments = Payments::where('user_id', $id)->get();
        foreach ($payments as $payment) {
            $payment->delete();
        }
        $user = User::findOrFail($id);
        $user->delete();
        return redirect()->back()->with('status', 'User Deleted Successfully');
    }

}
