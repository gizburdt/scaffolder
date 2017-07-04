<div class="navigation">
    <div class="navigation__content">
        <nav class="navbar navbar-toggleable-md">
            <div class="container">
                <button
                    class="navbar-toggler navbar-toggler-right"
                    type="button"
                    data-toggle="collapse"
                    data-target="#primaryMenu"
                    aria-controls="primaryMenu"
                    aria-expanded="false"
                    aria-label="Toggle navigation"
                >
                    <span class="navbar-toggler-icon">
                        <i class="fa fa-bars"></i>
                    </span>
                </button>

                <?php wp_nav_menu(array(
                    'theme_location'    => 'primary-menu',
                    'container_class'   => 'collapse navbar-collapse',
                    'container_id'      => 'primaryMenu',
                    'items_wrap'        => '<ul id="%1$s" class="%2$s navbar-nav">%3$s</ul>',
                    'depth'             => 0
                )); ?>
            </div>
        </nav>
    </div>
</div>