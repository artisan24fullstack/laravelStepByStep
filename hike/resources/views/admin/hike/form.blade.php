@extends('admin.admin')

@section('title', $hike->exists ? 'Editer un hike' : 'Créer un hike')


@section('content')

    <h1>@yield('title')</h1>

    <form class="vtstack gap-2" action="{{ route($hike->exists ? 'admin.hike.update' : 'admin.hike.store', $hike) }}"
        method="post">

        @csrf
        @method($hike->exists ? 'put' : 'post')

        <div class="row">
            @include('shared.input', [
                'class' => 'col',
                'label' => 'Name',
                'name' => 'name',
                'value' => $hike->name,
            ])

            @include('shared.input', [
                'class' => 'col',
                'name' => 'distance',
                'value' => $hike->distance,
            ])


        </div>
        <div class="col row">

            @include('shared.input', [
                'class' => 'col',
                'label' => 'Duration',
                'name' => 'duration',
                'value' => $hike->duration,
            ])
            @include('shared.input', [
                'class' => 'col',
                'label' => 'Elevation gain',
                'name' => 'elevation_gain',
                'value' => $hike->elevation_gain,
            ])
        </div>
        @include('shared.input', [
            'type' => 'textarea',
            'name' => 'description',
            'value' => $hike->description,
        ])


        <div>
            <button class="btn btn-primary">
                @if ($hike->exists)
                    Modifier
                @else
                    Créer
                @endif
            </button>
        </div>
    </form>
@endsection
