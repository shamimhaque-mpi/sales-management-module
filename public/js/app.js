document.addEventListener('DOMContentLoaded', function () {

    document.querySelectorAll('.delete-link').forEach(function (el) {
        el.addEventListener('click', function (e) {
            e.preventDefault();
            const url = el.getAttribute('data-url');

            Swal.fire({
                title: 'Are you sure?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = url;
                }
            });
        });
    });



    flatpickr(".datepicker", {
        dateFormat: "Y-m-d"
    });
            
    if($('.selectpicker').html())
        new TomSelect('.selectpicker', {
            create: false,
            sortField: {
                field: "text",
                direction: "asc"
            }
        });
});

