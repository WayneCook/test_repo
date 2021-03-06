$(document).ready(function(){

  orderTable = $('#workOrders-table').DataTable({
    language: {
      emptyTable: "No maintenance request history found."
    },
    searching: false,
    bLengthChange: false,
     order: [[ 2, "desc" ]],
     columnDefs: [
         { orderable: false, targets: 3 }
       ],
     ajax: "../user/workOrders",
     rowReorder: {
         selector: 'td:nth-child(2)'
     },
          responsive: true,
     columns: [
        {data: 'category'},
        {data: 'order_status'},
        {data: 'created_at'},
        {mRender: function ( data, type, row ) {
          return '<a data-toggle="tooltip" title="View" data-placement="top" class="show-modal btn btn-info btn-sm action-btns" data-id="' + row.id +
          '">View</a>';}
      }]
  });


  $('.submit-button').on('click', '#create-order-btn', function(){

    var formData = $('#create-form').serializeArray();
    var formDataObj = {};

    $.each(formData, function(key, val){
      formDataObj[val.name] = val.value;
    })


    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });

    $.ajax({
       type: 'post',
       url: '/admin/workOrder/store',
       data: formDataObj,
       success: function(data) {
         if ($.isEmptyObject(data.error)) {

           clearForm();
           swal({
            type: 'success',
            title: 'Thank you!',
            text: 'Your maintenance request has successfully been Submitted, Please contact us for any additional questions you may have.',
            confirmButtonColor: '#337ab7'
          },
          function(isConfirm){
            orderTable.ajax.reload();
          })

         } else {
           toastr.error('Please check for errors in your submission', 'Error Alert', {timeOut: 5000});
           showErrors(data);

         }
       }
    });

    //Show form errors on submit
    function showErrors(errors) {

      $(".text-danger").each(function() {
          var elem = $(this);
          $(this).text('');

          var name = $(this).attr('name');

          if (errors.error[name]) {
            elem.after('<span>').append('<span>  ' + errors.error[name] + '</span>');
          }
      });
    }


    //Clear the form data
    function clearForm() {

      $('.show-order-data').each(function(order){

        $(this).val('');
        $('.change-status').val('0');
      })

      $(".text-danger").each(function() {
        $(this).text('');

      });
    }

  })
})


//Show modal
$(document).on('click', '.show-modal', function() {
     $('.modal-title').text('Work Order Details');
     var id = $(this).data('id');

     $.ajax({
          type: 'GET',
          url: '../admin/workOrder/' + id,
          success: function(data) {

            fillShowForm(data);
            $('#showModal').modal('show');
          }
      });

 });

 function fillShowForm(data){

  $('.show-order-data').each(function(order){
    var id = $(this).attr('id');
    $(this).val(data[id]);
  })

 var audit = data.audit_log;

  $('#audit_log').text(audit);

 }
