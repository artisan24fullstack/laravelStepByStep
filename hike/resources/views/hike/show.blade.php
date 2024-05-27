@extends('base')

@section('title', $hike->name)


@section('content')
    <div class="container mt-5">

        <h1>{{ $hike->name }} </h1>

        <div class="text-primary" style="font-size: 1.4rem;">
            {{ $hike->description }}
        </div>

        <hr>
        <div class="mt-4">
            <div class="row">
                <div class="col-8">
                    <h2>Caractéristiques</h2>
                    <table class="table table-striped">
                        <tr>
                            <td>Distance</td>
                            <td>{{ $hike->distance }} km</td>
                        </tr>
                        <tr>
                            <td>Duration</td>
                            <td>{{ $hike->duration }} min</td>
                        </tr>
                        <tr>
                            <td>Elevation gain</td>
                            <td>{{ $hike->elevation_gain }}</td>
                        </tr>
                    </table>
                </div>
                <div class="col-4">
                    <h2>Tags</h2>
                    <ul class="list-group">

                    </ul>
                </div>
            </div>
        </div>
    </div>

@endsection
