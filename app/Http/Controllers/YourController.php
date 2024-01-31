<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class YourController extends Controller
{
    public function showData()
    {
        $names = ['Java', 'Python', 'C#'];
        $dates = ['2022-12-2', '2021-03-14', '2024-01-21'];
        $publishers = ['Otto', 'Jacob', 'Larry'];

        $returnArr = [];

        for ($i = 0; $i < count($names); $i++) {
            $returnArr[] = (object) [
                'name' => $names[$i],
                'published_date' => $dates[$i],
                'publisher_name' => $publishers[$i]
            ];
        }

        return view('your-blade-view', ['data' => $returnArr]);
    }
}