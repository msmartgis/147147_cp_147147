 <!-- jQuery 3 -->
 <script>
     $.ajaxSetup({
         headers: {
             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
         }
     });
 </script>
	<script src="{{asset('vendor_components/jquery-3.3.1/jquery-3.3.1.js')}}"></script>

	<!-- jQuery UI 1.11.4 -->
	<script src="{{asset('vendor_components/jquery-ui/jquery-ui.js')}}"></script>
	
	<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
	<script>
	  $.widget.bridge('uibutton', $.ui.button);
	</script>


	
<!-- popper -->
<script src="{{asset('vendor_components/popper/dist/popper.min.js')}}"></script>

<!-- Bootstrap 4.0-->
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

<!-- Slimscroll -->
<script src="{{asset('vendor_components/jquery-slimscroll/jquery.slimscroll.js')}}"></script>

<!-- FastClick -->
<script src="{{asset('vendor_components/fastclick/lib/fastclick.js')}}"></script>

<!-- peity -->
<script src="{{asset('vendor_components/jquery.peity/jquery.peity.js')}}"></script>

<!-- Fab Admin App -->
<script src="{{asset('js/template.js')}}"></script>


<script src="https://unpkg.com/ionicons@4.5.0/dist/ionicons.js"></script>

	<!-- Select2 -->
<script src="{{asset('vendor_components/select2/dist/js/select2.full.js')}}"></script>

<!-- iCheck 1.0.1 -->
<script src="{{asset('vendor_plugins/iCheck/icheck.min.js')}}"></script>

	<!-- Fab Admin for advanced form element -->
<script src="{{asset('js/advanced-form-element.js')}}"></script>

 <script src="{{asset('js/jquery.price_format.js')}}"></script>
 <script src="{{asset('js/functions/functions.js')}}"></script>

 <!-- Sweet-Alert  -->
 <script src="{{asset('vendor_components/sweetalert/sweetalert.min.js')}}"></script>
 <script src="{{asset('vendor_components/sweetalert/jquery.sweet-alert.custom.js')}}"></script>



 <script>
     var assetBaseUrl = "{{ asset('') }}";


        $(window).on('load', function () {
            // Animate loader off screen
            $(".se-pre-con").fadeOut("slow");
        });



 </script>

 @stack('added_scripts')
