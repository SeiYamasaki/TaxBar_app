@props(['backgroundImage' => '/images/bar_7.jpeg'])

<div class="relative h-[250px] overflow-hidden bg-gradient-to-b from-[#1a237e] to-[#283593] z-0">
    <div id="parallax-bg" class="absolute inset-0 w-full h-[120%] bg-cover bg-center opacity-50 transform translate-z-0"
        style="background-image: url('{{ $backgroundImage }}'); will-change: transform;">
    </div>
</div>

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            window.addEventListener('scroll', function() {
                const parallax = document.querySelector('#parallax-bg');
                const scrolled = window.pageYOffset;
                parallax.style.transform = 'translateY(' + (scrolled * 0.5) + 'px)';
            });
        });
    </script>
@endpush
