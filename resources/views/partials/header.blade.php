<header class="header">
    <div class="header__container">
        <a class="logo" href="{{ home_url('/') }}">{{ get_bloginfo('name', 'display') }}</a>

        <nav class="navigation">
            @if (has_nav_menu('menu-primary'))
                {!! wp_nav_menu(['theme_location' => 'menu-primary', 'menu_class' => 'nav']) !!}
            @endif
        </nav>
    </div>
</header>
