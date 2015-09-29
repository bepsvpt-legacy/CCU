<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;

abstract class Controller extends BaseController
{
    use DispatchesJobs, ValidatesRequests;

    /**
     * @param Carbon $carbon
     * @param string $originalFieldName
     * @return \Illuminate\Support\Collection
     */
    public function convertTimeFieldToHumanReadable(Carbon $carbon, $originalFieldName = '')
    {
        $dataFieldName = $originalFieldName ?: 'date';

        return collect([
            $dataFieldName => $carbon->toDateTimeString(),
            'human' => $carbon->diffForHumans(Carbon::now())
        ]);
    }
}
