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
<script src="{{asset('public/assets/vendors/select2/dist/js/select2.full.min.js')}}"></script>
{{--  <script src="{{asset('public/select2/select2.js')}}"></script>  --}}
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

    $(".select2_single").select2({
      placeholder: "Select ",
      allowClear: true
    });

    $(".select2_multiple").select2({
      placeholder: "Select ",
      allowClear: true
    });

    $('.datepicker').datepicker({
      autoclose: true,
      minViewMode: 0,
      format: 'dd-mm-yyyy'
    });
  });
</script>

</body>
</html>