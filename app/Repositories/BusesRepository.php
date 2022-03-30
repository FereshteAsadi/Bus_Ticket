<?php

namespace App\Repositories;

use App\Models\Bus;
use Illuminate\Support\Facades\DB;

class BusesRepository
{
    public function createBuses(array $data)
    {
        return Bus::create([
            'capacity' => $data['capacity'],
            'name' => $data['name'],
            'is_vip' => $data['is_vip'],
            'user_id' => $data['user_id'],
        ]);
    }
    public function archive($id){
        $archive =Bus::find($id);
        if ($archive) {
            $archive->delete();
            return $message = " information deleted successfully";
        }
        return $message = "no found";


    }

}
