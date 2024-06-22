<!-- JQuery min js -->
<script src="{{ asset('dashboard/plugins/jquery/jquery.min.js') }}"></script>

<!-- Bootstrap Bundle js -->
<script src="{{ asset('dashboard/plugins/bootstrap/js/popper.min.js') }}"></script>
<script src="{{ asset('dashboard/plugins/bootstrap/js/bootstrap.min.js') }}"></script>

<!-- Moment js -->
<script src="{{ asset('dashboard/plugins/moment/moment.js') }}"></script>

<!-- P-scroll js -->
<script src="{{ asset('dashboard/plugins/perfect-scrollbar/perfect-scrollbar.min.js') }}"></script>
<script src="{{ asset('dashboard/plugins/perfect-scrollbar/p-scroll.js') }}"></script>

<!-- Sticky js -->
<script src="{{ asset('dashboard/js/sticky.js') }}"></script>

<!-- eva-icons js -->
<script src="{{ asset('dashboard/js/eva-icons.min.js') }}"></script>

<!-- Sidebar js -->
<script src="{{ asset('dashboard/plugins/side-menu/sidemenu.js') }}"></script>

<!-- Right-sidebar js -->
<script src="{{ asset('dashboard/plugins/sidebar/sidebar.js') }}"></script>
<script src="{{ asset('dashboard/plugins/sidebar/sidebar-custom.js') }}"></script>

<!-- Switcher js -->
<script src="{{ asset('dashboard/switcher/js/switcher.js') }}"></script>

<!--themecolor js-->
<script src="{{ asset('dashboard/js/themecolor.js') }}"></script>

<!-- custom js -->
<script src="{{ asset('dashboard/js/custom.js') }}"></script>


<!-- switcher-styles js -->
<script src="{{ asset('dashboard/js/swither-styles.js') }}"></script>

<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
</script>

@yield('script')

{{--<script src="{{ mix('js/app.js') }}"></script>--}}
<script src="{{ asset('vendor/datatables/buttons.server-side.js') }}"></script>
{{--@stack('scripts')--}}


