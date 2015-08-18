<?php

namespace App\Http\Controllers\Api;

use App\Ccu\Dormitories\Roommate;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Cache;
use Carbon\Carbon;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class RoommatesController extends Controller
{
    public function search(Request $request)
    {
        $academic = $this->getAcademic();

        if ( ! Roommate::where('academic', '=', $academic)->where('name', '=', $request->input('name'))->where('room', '=', $request->input('room'))->exists())
        {
            $roommates = [];
        }
        else
        {
            $roommates = Roommate::where('academic', '=', $academic)->where('room', '=', $request->input('room'))->get();
        }

        return response()->json($roommates);
    }

    public function status()
    {
        $roommatesStatus = Cache::remember('roommatesStatus', 5, function()
        {
            $nums = [0, 0, 0, 0];

            foreach (Roommate::where('academic', '=', 108)->groupBy('room')->get(['room']) as $room)
            {
                $c = Roommate::where('academic', '=', 108)->where('room', '=', $room->room)->count();

                ++$nums[$c-1];
            }

            return $nums;
        });

        return response()->json($roommatesStatus);
    }

    public function store(Requests\DormitoriesRoommatesRequest $request)
    {
        try
        {
            Roommate::create([
                'academic' => $this->getAcademic(),
                'room' => $request->input('room'),
                'bed' => $request->input('bed'),
                'name' => $request->input('name'),
                'fb' => $request->input('fb'),
            ]);
        }
        catch (QueryException $e)
        {
            if (1062 == $e->errorInfo[1])
            {
                return response()->json(['message' => ['此床位已有資料，如這是您的床位，請聯繫管理員']], 422);
            }
            else
            {
                return response()->json(['message' => ['新增失敗']], 422);
            }
        }

        return response()->json(['message' => ['Create success.']]);
    }

    public function getAcademic()
    {
        $day = Carbon::now();

        $year = $day->year + 4;

        return ($day->month >= 8) ? ($year - 1911) : ($year - 1912);
    }
}