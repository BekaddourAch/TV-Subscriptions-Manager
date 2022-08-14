/******/ (() => { // webpackBootstrap
    var __webpack_exports__ = {};
    /*!*********************************!*\
      !*** ./resources/js/backend.js ***!
      \*********************************/
    $(document).ready(function () {
      window.addEventListener('hide-form', function (event) {
        $('#form').modal('hide');
      });

    });

    window.addEventListener('show-form', function (event) {
      $('#form').modal('show');
    });

    window.addEventListener('show-delete-modal', function (event) {
      $('#confirmationModal').modal('show');
    });

    window.addEventListener('hide-delete-modal', function (event) {
      $('#confirmationModal').modal('hide');
    });

    /******/ })()
    ;
