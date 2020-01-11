<!-- jQuery -->
<script src="{{asset('public/assets/vendors/jquery/dist/jquery.min.js')}}"></script>

<!-- jQuery Validation-->
<script src="{{asset('public/assets/js/jquery.validate.min.js')}}"></script>
<script src="{{asset('public/js/additional-methods.min.js') }}"></script>

<!-- Bootstrap -->
<script src="{{asset('public/assets/vendors/bootstrap/dist/js/bootstrap.min.js')}}"></script>

<!-- FastClick -->
<script src="{{asset('public/assets/vendors/fastclick/lib/fastclick.js')}}"></script>

<!-- NProgress -->
<script src="{{asset('public/assets/vendors/nprogress/nprogress.js')}}"></script>


<!-- bootstrap-daterangepicker -->
<script src="{{asset('public/assets/vendors/moment/min/moment.min.js')}}"></script>
<script src="{{asset('public/assets/vendors/bootstrap-daterangepicker/daterangepicker.js')}}"></script>
<script src="{{asset('public/assets/vendors/bootstrap-datepicker/bootstrap-datepicker.min.js')}}"></script>

<!-- Select2 -->

<script src="{{asset('public/assets/select2/select2.js')}}"></script>
 <!-- Datatables -->
<script src="{{asset('public/assets/vendors/datatables.net/js/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('public/assets/vendors/datatables.net-bs/js/dataTables.bootstrap.min.js')}}"></script>
<script src="{{asset('public/assets/vendors/datatables.net-buttons/js/dataTables.buttons.min.js')}}"></script>
<script src="{{asset('public/assets/vendors/datatables.net-buttons-bs/js/buttons.bootstrap.min.js')}}"></script>
<script src="{{asset('public/assets/vendors/datatables.net-buttons/js/buttons.flash.min.js')}}"></script>
<script src="{{asset('public/assets/vendors/datatables.net-buttons/js/buttons.html5.min.js')}}"></script>
<script src="{{asset('public/assets/vendors/datatables.net-buttons/js/buttons.print.min.js')}}"></script>
<script src="{{asset('public/assets/vendors/datatables.net-fixedheader/js/dataTables.fixedHeader.min.js')}}"></script>
<script src="{{asset('public/assets/vendors/datatables.net-keytable/js/dataTables.keyTable.min.js')}}"></script>
<script src="{{asset('public/assets/vendors/datatables.net-responsive/js/dataTables.responsive.min.js')}}"></script>
<script src="{{asset('public/assets/vendors/datatables.net-responsive-bs/js/responsive.bootstrap.js')}}"></script>

<script src="{{asset('public/assets/vendors/jszip/dist/jszip.min.js')}}"></script>
<script src="{{asset('public/assets/vendors/pdfmake/build/pdfmake.min.js')}}"></script>
<script src="{{asset('public/assets/vendors/pdfmake/build/vfs_fonts.js')}}"></script>

<script src="{{asset('public/assets/vendors/pnotify/dist/pnotify.js')}}"></script>
<script src="{{asset('public/assets/vendors/pnotify/dist/pnotify.buttons.js')}}"></script>
<script src="{{asset('public/assets/vendors/pnotify/dist/pnotify.nonblock.js')}}"></script>

<!-- Custom Theme Scripts -->
<script src="{{asset('public/assets/build/js/custom.min.js')}}"></script>

<!--Sweet Alert-->
<script src="{{ asset('public/assets/js/sweetalert.min.js') }}"></script>

<!-- common js -->
<script src="{{ asset('public/assets/js/common.js')}}"></script>


<script>
  $(document).ready(function() {
    $.ajaxSetup({
      headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });

    /*$(".select2_single").select2({
      placeholder: "{{ trans('user.select') }} ",
      allowClear: true
    });

    $(".select2_multiple").select2({
      placeholder: "{{ trans('user.select') }}",
      allowClear: true
    });*/

    $('.datepicker').datepicker({
      autoclose: true,
      minViewMode: 0,
      format: 'dd-mm-yyyy'
    });

    $("body").on("change", ".select2", function(event){
      var select2 = $(this).data('select2');
      var $currentTarget = event.currentTarget;
      if($currentTarget.selectedIndex <= 0){
        setTimeout(function() {
            if (!select2.opened()) {
                select2.open();
            }
        }, 0);
      }
    });

  });
</script>

<style type="text/css">
  input:not(.select2-input), textarea{
    background:#fff;
    -webkit-transition: all 0.30s ease-in-out;
    -moz-transition: all 0.30s ease-in-out;
    -ms-transition: all 0.30s ease-in-out;
    -o-transition: all 0.30s ease-in-out;
    outline: none;
    /*padding: 3px 0px 3px 3px;
    margin: 5px 1px 3px 0px;*/
    border: 1px solid #DDDDDD;
  }

  input:not(.select2-input):focus, textarea:focus {
    font-size:14px;
    font-weight:900;
    background:rgba(255,255,0,0.88);
    box-shadow: 0 0 5px rgba(81, 203, 238, 1);
    /*padding: 3px 0px 3px 3px;
    margin: 5px 1px 3px 0px;*/
    border: 1px solid rgba(81, 203, 238, 1);
  }
  button[class*="add"]:focus,button[class*="bg_modal"]:focus{
    background:#d0b0ff;
  }
  button[class*="add"],button[class*="bg_modal"]{
    background:#A8E6B4;
    border-color:#A8E6B4;
  }
  button[class*="minus"]:focus{
    background:#d0b0ff;
  }
  button[class*="minus"]{
    background:#f98582;
    border-color:#f98582;
  }
  button[type="submit"]:focus,button[type="reset"]:focus{
    background:#d58512;
  }
</style>

</body>
</html>