<!DOCTYPE html>
<html {!! get_language_attributes() !!}>
    <head>
        @include('partials.head')
    </head>

    <body @php(body_class())>
        <div id="root">
            @php(do_action('get_header'))

            @include('partials.header')

            <div class="site">
                <div class="site__container">
                    <div class="site__content">
                        <main class="main">
                            @yield('content')
                        </main>

                        @if (App\display_sidebar())
                            <aside class="sidebar">
                                @include('partials.sidebar')
                            </aside>
                        @endif
                    </div>
                </div>
            </div>

            @php(do_action('get_footer'))

            @include('partials.footer')
        </div>

        @php(wp_footer())
  </body>
</html>
