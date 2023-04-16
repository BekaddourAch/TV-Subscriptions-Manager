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
      console.log('cccccccccccccccccccc');
      $('#confirmationModal').modal('show');
      console.log('fffffffffffffffffffffff');
    });

    window.addEventListener('hide-delete-modal', function (event) {
      $('#confirmationModal').modal('hide');
    });

    /******/ })()
    ;
