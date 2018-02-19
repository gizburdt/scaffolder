<?php

namespace App;

add_filter('mce_buttons', function ($buttons) {
    if (! in_array('hr', $buttons)) {
        return array_add($buttons, 'hr', 'hr');
    }
});
