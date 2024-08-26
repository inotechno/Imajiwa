<script src="{{asset('libs/jquery/jquery.min.js') }}"></script>
<script src="{{asset('libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{asset('libs/metismenu/metisMenu.min.js') }}"></script>
<script src="{{asset('libs/simplebar/simplebar.min.js') }}"></script>
<script src="{{asset('libs/node-waves/waves.min.js') }}"></script>


@stack('js')
<!-- App js -->
<script src="{{asset('js/app.js') }}"></script>

@livewireScripts
{{-- <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script> --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.js"></script>
<x-livewire-alert::scripts />
<script>
    document.addEventListener('DOMContentLoaded', function () {
        Livewire.on('themeChanged', theme => {
            const borderlessThemeLink = document.getElementById('borderless-theme');

            if (theme === 'dark') {
                borderlessThemeLink.style.display = 'block';
            } else {
                borderlessThemeLink.style.display = 'none';
            }
        });

        // Trigger themeChanged event on page load
        Livewire.dispatch('themeChanged', document.body.getAttribute('data-theme'));
    });
</script>
