
@extends('layouts.app')
@section('content')   

        <!-- Step wizard -->
      <div class="box box-default">
        <div class="box-header with-border">
          <h4 class="box-title">Client Registration</h4>
          <h6 class="box-subtitle">You can find the <a href="http://www.jquery-steps.com" target="_blank">offical website </a></h6>			
			<ul class="box-controls pull-right">
			  <li><a class="box-btn-close" href="#"></a></li>
			  <li><a class="box-btn-slide" href="#"></a></li>	
			  <li><a class="box-btn-fullscreen" href="#"></a></li>
			</ul>
        </div>
        <!-- /.box-header -->
        <div class="box-body wizard-content">
			<form action="#" class="tab-wizard wizard-circle">
				<!-- Step 1 -->
				<h6>Client Information</h6>
				<section>
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label for="firstName5">First Name :</label>
								<input type="text" class="form-control" id="firstName5"> </div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label for="lastName1">Last Name :</label>
								<input type="text" class="form-control" id="lastName1"> </div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label for="emailAddress1">Email Address :</label>
								<input type="email" class="form-control" id="emailAddress1"> </div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label for="phoneNumber1">Phone Number :</label>
								<input type="tel" class="form-control" id="phoneNumber1"> </div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label for="addressline1">Address Line 1 :</label>
								<input type="text" class="form-control" id="addressline1"> </div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label for="addressline2">Address Line 2 :</label>
								<input type="text" class="form-control" id="addressline2"> </div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label for="location3">Select City :</label>
								<select class="custom-select form-control" id="location3" name="location">
									<option value="">Select City</option>
									<option value="Amsterdam">India</option>
									<option value="Berlin">USA</option>
									<option value="Frankfurt">Dubai</option>
								</select>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label for="date1">Date of Birth :</label>
								<input type="date" class="form-control" id="date1"> </div>
						</div>
					</div>
				</section>
				<!-- Step 2 -->
				<h6>Account Setup</h6>
				<section>
					<div class="row">
						<div class="col-12">
							<div class="form-group">
								<label for="url123">URL :</label>
								<input type="url" class="form-control" id="url123" placeholder="http://">
							</div>
						</div>
						<div class="col-6">
							<div class="form-group">
								<label for="username123">Username :</label>
								<input type="text" class="form-control" id="username123">
							</div>
						</div>
						<div class="col-6">
							<div class="form-group">
								<label for="password123">Password :</label>
								<input type="password" class="form-control" id="password123">
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label>User Group :</label>
								<div class="c-inputs-stacked">
									<input name="group123" type="radio" id="radio_123" value="1">
									<label for="radio_123" class="block">Sales Person</label>
									<input name="group456" type="radio" id="radio_456" value="1">
									<label for="radio_456">Customer</label>
								</div>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label>Communications :</label>
								<div class="c-inputs-stacked">
									<input type="checkbox" id="checkbox_123">
									<label for="checkbox_123" class="block">Email</label>
									<input type="checkbox" id="checkbox_234">
									<label for="checkbox_234" class="block">SMS</label>
									<input type="checkbox" id="checkbox_345">
									<label for="checkbox_345" class="block">Phone</label>
								</div>
							</div>
						</div>
					</div>
				</section>
				<!-- Step 3 -->
				<h6>Billing Setup</h6>
				<section>
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label for="int123">Cardholder Name :</label>
								<input type="text" class="form-control" id="int123">
							</div>
							<div class="form-group">
								<label for="int234">Card Number :</label>
								<input type="text" class="form-control" id="int234" placeholder="" value="23124567854356">
							</div>
							
							<div class="form-group">
								<div class="row">
									<div class="col-4">
										<label for="intType1">Exp Month :</label>
										<select class="custom-select form-control" id="intType1" data-placeholder="Exp Month" name="intType1">
											<option value="">Select</option>
											<option value="01">01</option>
											<option value="02">02</option>
											<option value="03">03</option>
											<option value="04" selected="">04</option>
											<option value="05">05</option>
											<option value="06">06</option>
											<option value="07">07</option>
											<option value="08">08</option>
											<option value="09">09</option>
											<option value="10">10</option>
											<option value="11">11</option>
											<option value="12">12</option>
										</select>
									</div>
									<div class="col-4">
										<label for="intType1">Exp Year :</label>
										<select class="custom-select form-control" id="intType12" data-placeholder="Exp Year" name="intType12">
											<option value="">Select</option>
											<option value="2018">2018</option>
											<option value="2019">2019</option>
											<option value="2020">2020</option>
											<option value="2021" selected="">2021</option>
											<option value="2022">2022</option>
											<option value="2023">2023</option>
											<option value="2024">2024</option>
										</select>
									</div>
									<div class="col-4">
										<label for="intType1">CVV :</label>										
										<input type="number" class="form-control" name="billing_card_cvv" placeholder="" value="450" >
									</div>
								</div>
								
							</div>
							<div class="form-group">
								<label for="Location1">Location :</label>
								<select class="custom-select form-control" id="Location1" name="location">
									<option value="">Select City</option>
									<option value="India">India</option>
									<option value="USA">USA</option>
									<option value="Dubai">Dubai</option>
								</select>
							</div>
						</div>
						<div class="col-md-6">							
							<div class="form-group">
								<label for="addressline12">Address Line 1 :</label>
								<input type="text" class="form-control" id="addressline12">
							</div>
							
							<div class="form-group">
								<label for="addressline13">Address Line 1 :</label>
								<input type="text" class="form-control" id="addressline13">
							</div>
							<div class="form-group">
								<label>Delivery Type :</label>
								<div class="c-inputs-stacked">
									<input name="group1" type="radio" id="radio_1" value="1">
									<label for="radio_1" class="block">Standart Delevery</label>
									<input name="group1" type="radio" id="radio_2" value="1">
									<label for="radio_2">Fast Delevery</label>
								</div>
							</div>
						</div>
					</div>
				</section>
				<!-- Step 4 -->
				<h6>Confirmation</h6>
				<section>
					<div class="row">
						<div class="col-12">
							<div class="form-group">
								<label for="decisions1">Comments</label>
								<textarea name="decisions" id="decisions1" rows="4" class="form-control"></textarea>
							</div>
							<div class="form-group">
								<div class="c-inputs-stacked">
									<input type="checkbox" id="checkbox_1">
									<label for="checkbox_1" class="block">Click here to indicate that you have read and agree to the terms presented in the Terms and Conditions agreement</label>
								
								</div>
							</div>
						</div>
					</div>
				</section>
			</form>
        </div>
        <!-- /.box-body -->
      </div>
      <!-- /.box -->
@endsection

@section('added_scripts')
<!-- steps  -->
	<script src="{{asset('vendor_components/jquery-steps-master/build/jquery.steps.js')}}"></script>

<!-- wizard  -->
    <script src="{{asset('js/steps.js')}}"></script>
@endsection