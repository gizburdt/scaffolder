/* eslint-env browser */
/* globals SCAFFOLDER_DIST_PATH */

/** Dynamically set absolute public path from current protocol and host */
if (SCAFFOLDER_DIST_PATH) {
    __webpack_public_path__ = SCAFFOLDER_DIST_PATH; // eslint-disable-line no-undef, camelcase
}