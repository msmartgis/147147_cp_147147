 <!-- jQuery 3 -->
	<script src="{{asset('vendor_components/jquery-3.3.1/jquery-3.3.1.js')}}"></script>
	
	<!-- jQuery UI 1.11.4 -->
	{{-- <script src="{{asset('vendor_components/jquery-ui/jquery-ui.js')}}"></script> --}}
	
	<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
	<script>
	  $.widget.bridge('uibutton', $.ui.button);
	</script>
	
	<!-- popper -->
	<script src="{{asset('vendor_components/popper/dist/popper.min.js')}}"></script>
	
	<!-- Bootstrap 4.0-->
	<script src="{{asset('vendor_components/bootstrap/dist/js/bootstrap.js')}}"></script>	
	
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


	<!-- Fab Admin for advanced form element -->
<script src="{{asset('js/advanced-form-element.js')}}"></script>


	@stack('added_scripts')