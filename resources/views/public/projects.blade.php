@extends('layouts.public')

@section('title', 'Nos Realisations - ' . Setting::get('site_name', 'VERDE PARIS 75'))

@section('content')
    <section class="hero hero-mini" style="background-image: url('https://images.unsplash.com/photo-1541888946425-d81bb19240f5?auto=format&fit=crop&w=1800&q=80');">
        <div class="container" style="text-align:center;">
            <h1>Nos Realisations</h1>
            <p style="margin:auto;">Decouvrez nos projets d'amenagement VRD et espaces verts</p>
        </div>
    </section>

    <section>
        <div class="container">
            @if($categories->count())
            <div style="text-align:center;margin-bottom:30px;">
                <div style="display:flex;flex-wrap:wrap;justify-content:center;gap:8px;">
                    <button class="btn btn-green btn-sm filter-btn active" data-category="all">Tous</button>
                    @foreach($categories as $category)
                    <button class="btn btn-outline btn-sm filter-btn" data-category="{{ Str::slug($category) }}">{{ $category }}</button>
                    @endforeach
                </div>
            </div>
            @endif

            @if($projects->count())
            <div class="grid" id="projectsGrid">
                @foreach($projects as $project)
                <a href="{{ route('projects.show', $project->slug) }}" style="text-decoration:none;" class="project-item" data-category="{{ $project->category ? Str::slug($project->category) : '' }}">
                    <div class="img-overlay">
                        <img src="{{ $project->cover_image ? asset('storage/' . $project->cover_image) : 'https://images.unsplash.com/photo-1541888946425-d81bb19240f5?auto=format&fit=crop&w=900&q=80' }}" alt="{{ $project->title }}">
                        <div class="overlay">
                            @if($project->category)
                            <span class="badge-vp">{{ $project->category }}</span>
                            @endif
                            <h5>{{ $project->title }}</h5>
                            @if($project->short_description)
                            <p>{{ Str::limit($project->short_description, 80) }}</p>
                            @endif
                        </div>
                    </div>
                </a>
                @endforeach
            </div>

            <div class="d-flex justify-content-center mt-5">
                {{ $projects->links() }}
            </div>
            @else
            <div style="text-align:center;padding:60px 0;">
                <i class="bi bi-briefcase" style="font-size:3rem;color:#0E7A32;opacity:.3;"></i>
                <p style="color:#999;margin-top:15px;">Nos realisations seront bientot disponibles.</p>
            </div>
            @endif
        </div>
    </section>
@endsection

@section('scripts')
<script>
    document.querySelectorAll('.filter-btn').forEach(function(btn) {
        btn.addEventListener('click', function() {
            var cat = this.getAttribute('data-category');
            document.querySelectorAll('.filter-btn').forEach(function(b) {
                b.classList.remove('active');
                b.className = b.className.replace('btn-green', 'btn-outline');
            });
            this.classList.add('active');
            this.className = this.className.replace('btn-outline', 'btn-green');

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
