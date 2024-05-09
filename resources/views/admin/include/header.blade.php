<!DOCTYPE html>
<html lang="en">


<!-- datatables.html  21 Nov 2019 03:55:21 GMT -->
<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <!-- General CSS Files -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/cdbootstrap/css/bootstrap.min.css" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/cdbootstrap/css/cdb.min.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  
  <link rel="stylesheet" href="{{ asset('public/assets/css/app.min.css') }}">
  <link rel="stylesheet" href="{{ asset('public/assets/bundles/datatables/datatables.min.css') }}">
  <link rel="stylesheet" href="{{ asset('public/assets/bundles/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css') }}">

  <link rel="stylesheet" href="{{ asset('public/assets/bundles/izitoast/css/iziToast.min.css') }}">

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.4/jquery-confirm.min.css">

  <!-- Template CSS -->
  <link rel="stylesheet" href="{{ asset('public/assets/css/style.css') }}">
  <link rel="stylesheet" href="{{ asset('public/assets/css/custom.css') }}">
  <link rel="stylesheet" href="{{ asset('public/assets/css/components.css')}}">
  <!-- Custom style CSS -->
  <link rel="stylesheet" href="{{ asset('public/assets/css/custom.css') }}">
  {{-- <link rel='shortcut icon' type='image/x-icon' href='{{ asset('public/indianoil_logo.png') }}' /> --}}
</head>
<style>
  .selected {
    background-color: #6777ef  !important;
    color: white !important;
}

.dropdown{
  padding:1px !important;
}

</style>

<body>
  <div class="loader"></div>
  <div id="app">
    <div class="main-wrapper main-wrapper-1">
      <div class="navbar-bg"></div>
      <nav class="navbar navbar-expand-lg main-navbar sticky">
        <div class="form-inline mr-auto">
          <ul class="navbar-nav mr-3">
            <li><a href="#" data-toggle="sidebar" class="nav-link nav-link-lg
									collapse-btn"> <i data-feather="align-justify"></i></a></li>
            <li><a href="#" class="nav-link nav-link-lg fullscreen-btn"> <i data-feather="maximize"></i> </a></li>
          </ul>
        </div>
        <ul class="navbar-nav navbar-right">
          <li class="dropdown">
            <a href="#" data-toggle="dropdown"
              class="nav-link dropdown-toggle nav-link-lg nav-link-user"> 
              @auth
              {{-- <img alt="image" src="{{ Auth::user()->profile ? asset('public/assets/images/' . Auth::user()->profile) : asset('public/assets/img/user.png') }}" class="user-img-radious-style"> --}}
              <img alt="image" src="{{ Auth::user()->profile ? asset('public/assets/images/' . Auth::user()->profile) : asset('public/assets/img/admin.jpg') }}" class="user-img-radious-style " style="
              width: 50px;
          ">

              @endauth      
               <span class="d-sm-none d-lg-inline-block"></span>
            </a>
            <div class="dropdown-menu dropdown-menu-right pullDown">
              <div class="dropdown-title">
                @auth
                Welcome, {{ Auth::user()->name }}
            @endauth
            </div>
              <a href="{{ url('logout') }}" class="dropdown-item has-icon text-danger"> <i class="fas fa-sign-out-alt"></i>
                Logout
              </a>
            </div>
          </li>
        </ul>
      </nav>
      <div class="main-sidebar sidebar-style-2">
        <aside id="sidebar-wrapper">
          <div class="sidebar-brand">
            <a href="#"> 
              {{-- <img alt="image" src="{{ asset('public/indianoil_logo.png') }}" class="header-logo" />  --}}
              <span
                class="logo-name">Demo</span>
            </a>
          </div>
          <ul class="sidebar-menu">
              <li class="dropdown">
                  <a class="nav-link" href="{{route('admin.dashboard')}}"><i class="fa fa-home"></i><span>Dashboard</span></a>    
              </li>
              
           
           
          
          </ul>
        </aside>
      </div>