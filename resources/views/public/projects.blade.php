@extends('layouts.public')

@section('title', 'Nos R&eacute;alisations - ' . Setting::get('site_name', 'VerdeParis75'))

@section('content')
    {{-- ── Hero ── --}}
    <section class="hero-section hero-mini" style="background-image: url('{{ asset('images/projects-hero.jpg') }}');">
        <div class="container">
            <div class="hero-content text-center w-100">
                <h1>Nos R&eacute;alisations</h1>
                <p>D&eacute;couvrez nos projets d'am&eacute;nagement paysager</p>
            </div>
        </div>
    </section>

    {{-- ── Filter + Grid ── --}}
    <section class="section-padding">
        <div class="container">
            {{-- Category Filter --}}
            @if($categories->count())
            <div class="text-center mb-4">
                <div class="d-flex flex-wrap justify-content-center gap-2">
                    <button class="btn btn-sm btn-vp filter-btn active" data-category="all">Tous</button>
                    @foreach($categories as $category)
                    <button class="btn btn-sm btn-vp-outline filter-btn" data-category="{{ Str::slug($category) }}">{{ $category }}</button>
                    @endforeach
                </div>
            </div>
            @endif

            @if($projects->count())
            <div class="row g-4" id="projectsGrid">
                @foreach($projects as $project)
                <div class="col-lg-4 col-md-6 project-item" data-category="{{ $project->category ? Str::slug($project->category) : '' }}">
                    <a href="{{ route('projects.show', $project->slug) }}" class="text-decoration-none">
                        <div class="img-overlay-card">
                            <img src="{{ $project->cover_image ? asset('storage/' . $project->cover_image) : asset('images/placeholder.jpg') }}" alt="{{ $project->title }}">
                            <div class="overlay">
                                @if($project->category)
                                <span class="badge-vp mb-2 align-self-start">{{ $project->category }}</span>
                                @endif
                                <h5>{{ $project->title }}</h5>
                                @if($project->short_description)
                                <p>{{ Str::limit($project->short_description, 80) }}</p>
                                @endif
                            </div>
                        </div>
                    </a>
                </div>
                @endforeach
            </div>

            {{-- Pagination --}}
            <div class="d-flex justify-content-center mt-5">
                {{ $projects->links() }}
            </div>
            @else
            <div class="text-center py-5">
                <i class="bi bi-briefcase" style="font-size: 3rem; color: var(--vp-green-light); opacity: .4;"></i>
                <p class="text-muted mt-3">Nos r&eacute;alisations seront bient&ocirc;t disponibles.</p>
            </div>
            @endif
        </div>
    </section>
@endsection

@section('scripts')
<script>
    // Category filter
    document.querySelectorAll('.filter-btn').forEach(function(btn) {
        btn.addEventListener('click', function() {
            var cat = this.getAttribute('data-category');

            // Update active state
            document.querySelectorAll('.filter-btn').forEach(function(b) {
                b.classList.remove('active', 'btn-vp');
                b.classList.add('btn-vp-outline');
            });
            this.classList.remove('btn-vp-outline');
            this.classList.add('active', 'btn-vp');

            // Filter items
            document.querySelectorAll('.project-item').forEach(function(item) {
                if (cat === 'all' || item.getAttribute('data-category') === cat) {
                    item.style.display = '';
                } else {
                    item.style.display = 'none';
                }
            });
        });
    });
</script>
@endsection
