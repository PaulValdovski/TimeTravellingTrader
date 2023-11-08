<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\History;
use Illuminate\Support\Facades\Auth;

class HistoryController extends Controller
{
    public function index()
    {
        $userId = Auth::id();
        $history = History::where('user_id', $userId)->paginate(20);

        return view('History', ['History' => $history]);
    }
}
