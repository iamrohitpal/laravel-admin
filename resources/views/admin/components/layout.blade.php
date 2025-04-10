@php
	$data['user'] = App\Models\User::first();
@endphp
<!doctype html>
<html lang="en">

<head>
	<!-- Required meta tags -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!--favicon-->
	<link rel="icon" href="{{asset('admin/assets/images/favicon-32x32.png')}}" type="image/png" />
	<!--plugins-->
	<link href="{{asset('admin/assets/plugins/vectormap/jquery-jvectormap-2.0.2.css')}}" rel="stylesheet"/>
	<link href="{{asset('admin/assets/plugins/simplebar/css/simplebar.css')}}" rel="stylesheet" />
	<link href="{{asset('admin/assets/plugins/perfect-scrollbar/css/perfect-scrollbar.css')}}" rel="stylesheet" />
	<link href="{{asset('admin/assets/plugins/metismenu/css/metisMenu.min.css')}}" rel="stylesheet" />
	<link href="{{asset('admin/assets/plugins/datatable/css/dataTables.bootstrap5.min.css')}}" rel="stylesheet" />
	<!-- loader-->
	<link href="{{asset('admin/assets/css/pace.min.css')}}" rel="stylesheet" />
	<script src="{{asset('admin/assets/js/pace.min.js')}}"></script>
	<!-- Bootstrap CSS -->
	<link href="{{asset('admin/assets/css/bootstrap.min.css')}}" rel="stylesheet">
	<link href="{{asset('admin/assets/css/bootstrap-extended.css')}}" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet">
	<link href="{{asset('admin/assets/css/app.css')}}" rel="stylesheet">
	<link href="{{asset('admin/assets/css/icons.css')}}" rel="stylesheet">
	<!-- Theme Style CSS -->
	<link rel="stylesheet" href="{{asset('admin/assets/css/dark-theme.css')}}" />
	<link rel="stylesheet" href="{{asset('admin/assets/css/semi-dark.css')}}" />
	<link rel="stylesheet" href="{{asset('admin/assets/css/header-colors.css')}}" />
	<title>Rocker - Bootstrap 5 Admin Dashboard Template</title>
</head>

<body>
	<!--wrapper-->
	<div class="wrapper">
		<!--sidebar wrapper -->
		<div class="sidebar-wrapper" data-simplebar="true">
			<div class="sidebar-header">
				<div>
					<img src="{{asset('admin/assets/images/logo-icon.png')}}" class="logo-icon" alt="logo icon">
				</div>
				<div>
					<h4 class="logo-text">Rocker</h4>
				</div>
				<div class="toggle-icon ms-auto"><i class='bx bx-arrow-to-left'></i>
				</div>
			</div>
			@php
				$dashoard = App\Models\Permission::getPermissionBySlugAndId('Dashboard');

				$category = App\Models\Permission::getPermissionBySlugAndId('Category');

				$subcategory = App\Models\Permission::getPermissionBySlugAndId('Sub Category');

				$product = App\Models\Permission::getPermissionBySlugAndId('Product');

				$enquiry = App\Models\Permission::getPermissionBySlugAndId('Enquiry');

				$role = App\Models\Permission::getPermissionBySlugAndId('Role');

				$user = App\Models\Permission::getPermissionBySlugAndId('User');
			@endphp
			<!--navigation-->
			<ul class="metismenu" id="menu">
				@if ($dashoard)
				<li class="{{ $type == 'dashboard' ? 'mm-active' : '' }}">
					<a href="{{route('dashboard')}}">
						<div class="parent-icon active"><i class='bx bx-home-circle'></i>
						</div>
						<div class="menu-title">Dashboard</div>
					</a>
				</li>
				@endif
				@if ($category)
				<li class="{{ $type == 'category' ? 'mm-active' : '' }}">
					<a href="{{route('category_list')}}">
						<div class="parent-icon"><i class="bx bx-category"></i>
						</div>
						<div class="menu-title">Category</div>
					</a>
				</li>
				@endif
				@if ($subcategory)
				<li class="{{ $type == 'subCategory' ? 'mm-active' : '' }}">
					<a href="{{route('subcategory_list')}}">
						<div class="parent-icon"><i class='bx bx-cookie'></i>
						</div>
						<div class="menu-title">Sub Category</div>
					</a>
				</li>
				@endif
				@if ($product)
				<li class="{{ $type == 'product' ? 'mm-active' : '' }}">
					<a href="{{route('product_list')}}">
						<div class="parent-icon"><i class='bx bx-cart'></i>
						</div>
						<div class="menu-title">Product</div>
					</a>
				</li>
				@endif
				{{-- @if ($category) --}}
				{{-- <li class="{{ $type == 'blog' ? 'mm-active' : '' }}">
					<a href="{{route('blog_list')}}">
						<div class="parent-icon"><i class='bx bx-bookmark-heart'></i>
						</div>
						<div class="menu-title">Blog</div>
					</a>
				</li> --}}
				{{-- @endif --}}
				@if ($enquiry)
				<li class="{{ $type == 'enquiry' ? 'mm-active' : '' }}">
					<a  href="{{route('enquiry_list')}}">
						<div class="parent-icon"><i class="bx bx-repeat"></i>
						</div>
						<div class="menu-title">Enquiry</div>
					</a>
				</li>
				@endif
				@if ($role)
				<li class="{{ $type == 'role' ? 'mm-active' : '' }}">
					<a  href="{{route('role_list')}}">
						<div class="parent-icon"><i class="bx bx-menu"></i>
						</div>
						<div class="menu-title">Role</div>
					</a>
				</li>
				@endif
				@if ($user)
				<li class="{{ $type == 'user' ? 'mm-active' : '' }}">
					<a  href="{{route('user_list')}}">
						<div class="parent-icon"><i class="bx bx-user-circle"></i>
						</div>
						<div class="menu-title">User</div>
					</a>
				</li>
				@endif
			</ul>
			<!--end navigation-->
		</div>
		<!--end sidebar wrapper -->
		<!--start header -->
		<header>
			<div class="topbar d-flex align-items-center">
				<nav class="navbar navbar-expand">
					<div class="mobile-toggle-menu"><i class='bx bx-menu'></i>
					</div>
					<div class="search-bar flex-grow-1">
						<div class="position-relative search-bar-box">
							<input type="text" class="form-control search-control" placeholder="Type to search..."> <span class="position-absolute top-50 search-show translate-middle-y"><i class='bx bx-search'></i></span>
							<span class="position-absolute top-50 search-close translate-middle-y"><i class='bx bx-x'></i></span>
						</div>
					</div>
					<div class="top-menu ms-auto">
						<ul class="navbar-nav align-items-center">
							<li class="nav-item mobile-search-icon">
								<a class="nav-link" href="#">	<i class='bx bx-search'></i>
								</a>
							</li>
						</ul>
					</div>
					<div class="user-box dropdown">
						<a class="d-flex align-items-center nav-link dropdown-toggle dropdown-toggle-nocaret" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
							<img src="{{asset('admin/assets/images/avatars/avatar-1.png')}}" class="user-img" alt="user avatar">
							<div class="user-info ps-3">
								<p class="user-name mb-0">{{$data['user']->name}}</p>
							</div>
						</a>
						<ul class="dropdown-menu dropdown-menu-end">
							<li><a class="dropdown-item" href="{{route('profile')}}"><i class="bx bx-user"></i><span>Profile</span></a>
							</li>
							<li>
								<div class="dropdown-divider mb-0"></div>
							</li>
							<li><a class="dropdown-item" href="{{route('logout')}}"><i class='bx bx-log-out-circle'></i><span>Logout</span></a>
							</li>
						</ul>
					</div>
				</nav>
			</div>
		</header>

		<!--start page wrapper -->
		<div class="page-wrapper">
			@include('admin.components.success')
			@include('admin.components.error')

        	{{ $slot }}

		</div>

        <!--start overlay-->
		<div class="overlay toggle-icon"></div>
		<!--end overlay-->
		<!--Start Back To Top Button-->
		<a href="javaScript:;" class="back-to-top"><i class='bx bxs-up-arrow-alt'></i></a>
		<!--End Back To Top Button-->
		<footer class="page-footer">
			<p class="mb-0">Copyright © 2021. All right reserved.</p>
		</footer>
	</div>
	<!--end wrapper-->

	<script src='https://cdn.jsdelivr.net/npm/tinymce@5/tinymce.min.js' referrerpolicy="origin">
	</script>
	<script src="https://unpkg.com/feather-icons"></script>
	<script>
		tinymce.init({
			selector: '#mytextarea',
			height: 250,
			plugins: [
				'advlist', 'autolink', 'link', 'image', 'lists', 'charmap', 'preview', 'anchor', 'pagebreak',
				'searchreplace', 'wordcount', 'visualblocks', 'visualchars', 'code', 'fullscreen', 'insertdatetime',
				'media', 'table', 'emoticons', 'help'
			],
			menubar: true,
			toolbar: 'undo redo | bold italic underline | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | code',
			extended_valid_elements: 'i[class|style]', // Allow <i> tags with classes and styles
			valid_elements: '*[*]', // Allows all elements
			content_css: false, // Ensures your custom content style isn't overridden
			content_style: 'i { font-style: italic; }', // Ensure the <i> tag renders as italic
			entity_encoding: 'raw', // Prevent encoding issues for special characters or HTML tags
			remove_trailing_brs: false, // Retain proper HTML structure
			valid_children: '+body[style|i]', // Ensure valid <i> as child elements
		});
		tinymce.init({
		  selector: '#longtextarea',
		  height: 250,
		  plugins: [
				'advlist', 'autolink', 'link', 'image', 'lists', 'charmap', 'preview', 'anchor', 'pagebreak',
				'searchreplace', 'wordcount', 'visualblocks', 'visualchars', 'code', 'fullscreen', 'insertdatetime',
				'media', 'table', 'emoticons', 'help'
			],
			menubar: true,
			toolbar: 'undo redo | bold italic underline | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | code',
			extended_valid_elements: 'i[class|style]', // Allow <i> tags with classes and styles
			valid_elements: '*[*]', // Allows all elements
			content_css: false, // Ensures your custom content style isn't overridden
			content_style: 'i { font-style: italic; }', // Ensure the <i> tag renders as italic
			entity_encoding: 'raw', // Prevent encoding issues for special characters or HTML tags
			remove_trailing_brs: false, // Retain proper HTML structure
			valid_children: '+body[style|i]', // Ensure valid <i> as child elements
		});
		feather.replace();
		setTimeout(function () {
            $('.alert-success,.alert-danger').fadeOut('fast');
        }, 3000);
	</script>

	<!-- Bootstrap JS -->
	<script src="{{asset('admin/assets/js/bootstrap.bundle.min.js')}}"></script>
	<!--plugins-->
	<script src="{{asset('admin/assets/js/jquery.min.js')}}"></script>
	<script src="{{asset('admin/assets/plugins/simplebar/js/simplebar.min.js')}}"></script>
	<script src="{{asset('admin/assets/plugins/metismenu/js/metisMenu.min.js')}}"></script>
	<script src="{{asset('admin/assets/plugins/perfect-scrollbar/js/perfect-scrollbar.js')}}"></script>
	<script src="{{asset('admin/assets/plugins/vectormap/jquery-jvectormap-2.0.2.min.js')}}"></script>
    <script src="{{asset('admin/assets/plugins/vectormap/jquery-jvectormap-world-mill-en.js')}}"></script>
	<script src="{{asset('admin/assets/plugins/chartjs/js/Chart.min.js')}}"></script>
	<script src="{{asset('admin/assets/plugins/chartjs/js/Chart.extension.js')}}"></script>
	<script src="{{asset('admin/assets/js/index.js')}}"></script>
	<script src="{{asset('admin/assets/plugins/datatable/js/jquery.dataTables.min.js')}}"></script>
	<script src="{{asset('admin/assets/plugins/datatable/js/dataTables.bootstrap5.min.js')}}"></script>
	<script>
		$(document).ready(function() {
			$('#example').DataTable();
		});
	</script>
	<!--app JS-->
	<script src="{{asset('admin/assets/js/app.js')}}"></script>
</body>

</html>