<div class="card">
    <div class='card-body'>
        <h5>
            <a href="{{ route('hike.show', ['slug' => $hike->getSlug(), 'hike' => $hike]) }}">{{ $hike->name }}</a>
        </h5>
        <p class='card-text'>
            {{ $hike->distance }} km - {{ $hike->duration }} min
        </p>
        <p class='card-text'>
            {{ $hike->description }}
        </p>
        <div class="text-primary" style="font-size: 1.4rem;">
            {{ $hike->elevation_gain }}
        </div>

    </div>
</div>
