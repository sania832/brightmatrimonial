@extends('layouts.backend.master')

@section('content')
				<div class="app-page-title app-page-title-simple">
					<div class="page-title-wrapper">
						<div class="page-title-heading">
							<div>
								<div class="page-title-head center-elem">
									<span class="d-inline-block pr-2"><i class="lnr-apartment opacity-6"></i></span>
									<span class="d-inline-block">Dashboard</span>
								</div>
							</div>
						</div>
					</div>
				</div>
				
				<div class="row">
					<div class="col-md-6 col-lg-3">
						<div class="widget-chart widget-chart2 text-left mb-3 card-btm-border card-shadow-primary border-primary card">
							<div class="widget-chat-wrapper-outer">
								<div class="widget-chart-content">
									<div class="widget-title opacity-5 text-uppercase">Total Users</div>
									<div class="widget-numbers mt-2 fsize-4 mb-0 w-100">
										<div class="widget-chart-flex align-items-center">
											<div>0</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="col-md-6 col-lg-3">
						<div class="widget-chart widget-chart2 text-left mb-3 card-btm-border card-shadow-danger border-danger card">
							<div class="widget-chat-wrapper-outer">
								<div class="widget-chart-content">
									<div class="widget-title opacity-5 text-uppercase">Open Profiles</div>
									<div class="widget-numbers mt-2 fsize-4 mb-0 w-100">
										<div class="widget-chart-flex align-items-center">
											<div>0</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="col-md-6 col-lg-3">
						<div class="widget-chart widget-chart2 text-left mb-3 card-btm-border card-shadow-success border-success card">
							<div class="widget-chat-wrapper-outer">
								<div class="widget-chart-content">
									<div class="widget-title opacity-5 text-uppercase">Wedding Services</div>
									<div class="widget-numbers mt-2 fsize-4 mb-0 w-100">
										<div class="widget-chart-flex align-items-center">
											<div>0</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="col-md-6 col-lg-3">
						<div class="widget-chart widget-chart2 text-left mb-3 card-btm-border card-shadow-warning border-warning card">
							<div class="widget-chat-wrapper-outer">
								<div class="widget-chart-content">
									<div class="widget-title opacity-5 text-uppercase">Total Revenue</div>
									<div class="widget-numbers mt-2 fsize-4 mb-0 w-100">
										<div class="widget-chart-flex align-items-center">
											<div>0</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-12 col-md-7 col-lg-8">
						<div class="mb-3 card">
							<div class="card-header-tab card-header">
								<div class="card-header-title font-size-lg text-capitalize font-weight-normal">Traffic Sources</div>
							</div>
							<div class="pt-0 card-body">
								<div id="chart-combined"></div>
							</div>
						</div>
					</div>
					<div class="col-sm-12 col-md-5 col-lg-4">
						<div class="mb-3 card">
							<div class="card-header-tab card-header">
								<div class="card-header-title font-size-lg text-capitalize font-weight-normal">Income</div>
							</div>
							<div class="p-0 card-body">
								<div id="chart-radial"></div>
								<div class="widget-content pt-0 w-100">
									<div class="widget-content-outer">
										<div class="widget-content-wrapper"></div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
@endsection