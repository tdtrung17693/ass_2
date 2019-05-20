/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require("./bootstrap");
require("bootstrap-multiselect");
require("gijgo");
const Swal = require("sweetalert2");

window.Vue = require("vue");

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i);
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default));

// Vue.component('example-component', require('./components/ExampleComponent.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

// const app = new Vue({
//     el: '#app',
// });

$(function() {
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": token
        }
    });

    $("#book-pubdate, #dob").datepicker({
        uiLibrary: "bootstrap4",
        format: "yyyy-mm-dd"
    });

    $(".action-trash").click(function(ev) {
        ev.preventDefault();

        Swal.fire({
            title: "Are you sure?",
            text: "You won't be able to revert this!",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, delete it!"
        }).then(result => {
            if (result.value) {
                window.location.replace(`${$(this).attr("href")}`);
            }
        });
    });

    $("#authors-select").multiselect();

    $("#add-author-modal form").on("submit", function(ev) {
        ev.preventDefault();

        let name = this.querySelector("#author-name").value;
        let desc = this.querySelector("#desc").value;

        $.ajax({
            type: "POST",

            url: "/authors/new_from_book",

            data: { "author-name": name, "author-desc": desc },

            success: function(data) {
                if (data.success) {
                    $("#authors-select").append(
                        `<option value=${data.author.AuthorID}>${
                            data.author.AuthorName
                        }</option>`
                    );
                    $("#authors-select").multiselect("rebuild");
                    Swal.fire("Success", data.success, "success");
                    $("#add-author-modal").modal("toggle");
                } else if (data.error) {
                    Swal.fire({
                        type: "error",
                        title: "Oops...",
                        text: data.error
                    });
                }
            }
        });
    });
});
