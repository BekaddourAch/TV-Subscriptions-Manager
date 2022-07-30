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

    // $('[x-ref="profileLink"]').on('click', function () {
    //   localStorage.setItem('_x_currentTab', '"profile"');
    // });

    // $('[x-ref="changePasswordLink"]').on('click', function () {
    //   localStorage.setItem('_x_currentTab', '"changePassword"');
    // });

    /******/ })()
    ;
