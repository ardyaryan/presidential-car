$(document).ready(function(){


    $('#carDetails').DataTable({'bPaginate': false, 'bFilter': false, 'bInfo': false });
    $('#carTrips').DataTable({});


    $(document).on('click', '.btn.edit-driver', function(){
        var driverId = $(this).attr('data-id');
        editDriver(driverId);
    });

    $(document).on('click', '.btn.delete-driver', function(){
        var driverId = $(this).attr('data-id');
        $('#delete_driver_id').val(driverId);
        $('#deleteModal').modal('show');
    });


    $('#editModal').on('hidden.bs.modal', function () {
        $('#save_driver').html('Save');
    });

    $('#save_driver').on('click', function() {
        saveDriver();
    });

    $('#save_new_driver').on('click', function() {
        saveNewDriver();
    });

    $('#add_driver').on('click', function() {
        $('#addModal').modal('show');
    });

    $('#delete_driver_req').on('click', function() {
        deleteDriver();
    });

});
