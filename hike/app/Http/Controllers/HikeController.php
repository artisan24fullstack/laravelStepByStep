<?php

namespace App\Http\Controllers;

use App\Models\Hike;
use Illuminate\Http\Request;

class HikeController extends Controller
{
    public function show(string $slug, Hike $hike)
    {
        $expectedSlug = $hike->getSlug();

        if ($slug !== $expectedSlug) {
            return to_route('hike.show', ['slug' => $expectedSlug, 'hike' => $hike]);
        }

        return view('hike.show', [
            'hike' => $hike
        ]);
    }
}
