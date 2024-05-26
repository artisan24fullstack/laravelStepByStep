@extends('admin.admin')

@section('title', 'Tous les hikes')


@section('content')
    <div class="d-flex justify-content-between align-items-center">
        <h1>@yield('title')</h1>
        <a class="btn btn-primary" href="{{ route('admin.hike.create') }}">Ajouter un hike</a>
    </div>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Name</th>
                <th>Distance</th>
                <th>Duration</th>
                <th>Elevation gain</th>
                <th>Description</th>
                <th class="text-end">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($hikes as $hike)
                <tr>

                    <td>{{ $hike->name }}</td>
                    <td>{{ $hike->distance }}km</td>
                    <td>{{ $hike->duration }}min</td>
                    <td>{{ $hike->elevation_gain }}</td>
                    <td>{{ $hike->description }}</td>

                    <td>
                        <div class='d-flex gap-2 justify-content-end'>
                            <a class="btn btn-primary" href="{{ route('admin.hike.edit', $hike) }}">Editer</a>
                            <form action="{{ route('admin.hike.destroy', $hike) }}" method="post">

                                @csrf
                                @method('delete')
                                <button class="btn btn-danger">Supprimer</button>
                            </form>
                        </div>
                    </td>
                </tr>
            @endforeach

        </tbody>
    </table>

    {{ $hikes->links() }}
@endsection
