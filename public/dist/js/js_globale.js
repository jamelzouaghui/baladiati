/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */



/**
 * AdminLTE Demo Menu
 * ------------------
 * You should not use this file in production.
 * This file is for demo purposes only.
 */
$(function () {
    'use strict'

    /**
     * Get access to plugins
     */


    $('#users').DataTable({
        scrollX: true,
        'paging': true,
        'lengthChange': false,
        'searching': false,
        'ordering': true,
        'info': true,
        'autoWidth': true
    })

    $('#example').DataTable({
        initComplete: function () {
            this.api().columns([4]).every(function () {
                var column = this;
                var select = $('<select><option value="" class="form-control"></option></select>')
                       .appendTo( $(column.header()) )
                        .on('change', function () {
                            var val = $.fn.dataTable.util.escapeRegex(
                                    $(this).val()
                                    );

                            column
                                    .search(val ? '^' + val + '$' : '', true, false)
                                    .draw();
                        });

                column.data().unique().sort().each(function (d, j) {
                    select.append('<option value="' + d + '">' + d + '</option>')
                });
            });
        }
    });





    $('.select2').select2({
        closeOnSelect: false,
    });
    








})

