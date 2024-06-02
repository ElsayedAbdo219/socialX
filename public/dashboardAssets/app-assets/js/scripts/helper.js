$(document).ready(function () {

    $(document).on('click', '.btn-trigger', function () {
        let that = $(this);

        let id = that.data('id');
        let type = that.data('type') || '';
        let model = that.data('model') || '';
        let route = that.data('route') || null;
        swal.fire({
            title: "{{trans('are you sure ?')}}",
            text: "{{trans('to change the status of this statement')}}",
            type: 'warning',
            showCancelButton: true,
            confirmButtonText: "{{trans('yes, make a change')}}",
            cancelButtonText: "{{trans('no, cancel')}}"
        }).then((isConfirm) => {
            if (isConfirm.isConfirmed) {
                console.log(isConfirm.isConfirmed);
                $.post(`${route ?? window.routes}${id}`, {
                    _method: 'PATCH',
                    type: type,
                    trigger_action: type,
                    value: (that.prop('checked') === true) ? 1 : 0
                }).done(function (response) {
                    console.log(response);
                    if (response.status) {
                        $('.datatable-ajax').DataTable().ajax.reload();
                        swal.fire("{{trans('good job')}}", response.message, "success");
                    }else{
                        $('.datatable-ajax').DataTable().ajax.reload();
                        swal.fire("{{trans('Failed!')}}", response.responseJSON.message, "error");
                    }
                }).fail(function (response) {
                    console.log(response);
                    $('.datatable-ajax').DataTable().ajax.reload();
                    swal.fire("{{trans('Failed!')}}", response.responseJSON.message, "error");
                })
            }else{
                console.log('test');
                $('.datatable-ajax').DataTable().ajax.reload();
                swal.fire("{{trans('Failed!')}}", "{{trans('Failed!')}}", "error");
            }

        });
    });



    $(document).on('click', '.btn-delete', function () {
        let id = $(this).data('id');
        iziToast.question({
            timeout: 20000,
            close: true,
            overlay: true,
            displayMode: 'once',
            id: 'question',
            color: 'red',
            zindex: 999,
            title: $('#deleteMessage').val(),
            message: $('#areYouSure').val(),
            position: 'center',
            buttons: [
                ['<button><b>'+$('#yesDelete').val()+'</b></button>', function (instance, toast) {
                    $.post(window.routes + id, {_method: 'DELETE'}).done(function (response) {
                        if (response.status) {
                            $('.datatable-ajax').DataTable().ajax.reload();
                            iziToast.success({
                                title: '',
                                position: 'topLeft',
                                message: $('#deletedDone').val()
                            });
                        }
                    }).fail(function (response) {
                        iziToast.error({
                            title: '',
                            position: 'topLeft',
                            message: 'Error!'
                        });                    })
                    instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');

                }, true],
                ['<button>'+$('#noCancel').val()+'</button>', function (instance, toast) {

                    instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');

                }],
            ]
        });
    });

});


function datatableInitComplete(settings, json) {

    var baseTable = window.LaravelDataTables[settings.sInstance];
    $('.custom_filter').on('change', function () {
        baseTable.draw();
    });
    refreshFsLightbox();
}

function datatableDrawCallback(settings, json) {
    refreshFsLightbox();
    // ___________TOOLTIP
    $('[data-toggle="tooltip"]').tooltip();
    // colored tooltip
    $('[data-toggle="tooltip-primary"]').tooltip({
        template: '<div class="tooltip tooltip-primary" role="tooltip"><div class="arrow"><\/div><div class="tooltip-inner"><\/div><\/div>'
    });
    $('[data-toggle="tooltip-secondary"]').tooltip({
        template: '<div class="tooltip tooltip-secondary" role="tooltip"><div class="arrow"><\/div><div class="tooltip-inner"><\/div><\/div>'
    });

    var query = window.location.search.substring(1);
    var vars = query.split("=");
    if (vars[0] === 'id') {
        var ID = vars[1];
        if (ID) {
            var elment = $('#' + ID);
            elment.addClass('bg-danger selected')
            elment.remove()
            $("tbody").prepend(elment);
            console.log(elment)
            elment.focus();
        }
    }
}
