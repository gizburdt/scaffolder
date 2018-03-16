
window.Vue = require('vue');

/**
 * Mixins.
 */
window.mixins = {
    //
};

/**
 * Install.
 */
Vue.use({
    install: function() {
        Vue.prototype.window = window;

        Vue.prototype._ = window._;

        Vue.prototype.$http = axios;
    }
});

/**
 * Filters
 */
Vue.filter('ucfirst', function(value) {
    return value ? value.toString().charAt(0).toUpperCase() + value.slice(1) : '';
});