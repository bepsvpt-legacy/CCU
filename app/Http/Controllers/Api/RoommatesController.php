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
    /**
     * Current academic.
     *
     * @var int
     */
    protected $academic;

    public function __construct()
    {
        $this->academic = $this->getAcademic();
    }

    public function search(Request $request)
    {
        $roommates = [];

        if (Roommate::where('academic', '=', $this->academic)->where('name', '=', $request->input('name'))->where('room', '=', $request->input('room'))->exists()) {
            $roommates = Roommate::where('academic', '=', $this->academic)->where('room', '=', $request->input('room'))->get();
        }

        return response()->json($roommates);
    }

    public function status()
    {
        $roommatesStatus = Cache::remember('roommatesStatus', 60, function() {
            $nums = [0, 0, 0, 0];

            foreach (Roommate::select(['room'])->selectRaw('count(`room`) as num')->where('academic', '=', $this->academic)->groupBy('room')->get() as $room) {
                ++$nums[$room->num - 1];
            }

            return $nums;
        });

        return response()->json($roommatesStatus);
    }

    public function store(Requests\DormitoriesRoommatesRequest $request)
    {
        try {
            Roommate::create([
                'academic' => $this->academic,
                'room' => $request->input('room'),
                'bed' => $request->input('bed'),
                'name' => $request->input('name'),
                'fb' => $request->input('fb'),
            ]);
        } catch (QueryException $e) {
            if (1062 == $e->errorInfo[1]) {
                return response()->json(['message' => ['此床位已有資料，如這是您的床位，請聯繫管理員']], 422);
            } else {
                return response()->json(['message' => ['新增失敗，請聯繫管理員以協助處理此狀況']], 422);
            }
        }

        return response('', 200);
    }

    public function getAcademic()
    {
        $now = Carbon::now();

        $year = $now->year + 4;

        return ($now->month >= 8) ? ($year - 1911) : ($year - 1912);
    }
}
