@extends('layouts/layout')

@section('title')
  Company
@endsection

@section('content')

<section id="company-profile" class="container-fluid" style="padding-top:85px">

  <section id="company">
    <div id="background" style="background-image:@yield('CoverPhoto')"></div>
    <div class="info-bar">
      <div class="container">
        <div class="col-md-6 col-sm-8 col-xs-12">
          <img src=@yield('ProfilePicture')>
          <h1>@yield('name')<br>
          <span> @yield('FollowerCount') followers | @yield('PostCount') posts</span>
          </h1>
        </div>
        <div class="col-md-6 col-sm-4 col-xs-12">
          <a href="#" class="button-custom button-follow" ><i class="fa fa-user-plus"></i>Follow</a>
          <!-- <a href="#" class="button-custom button-unfollow" >Unfollow</a> -->
          @yield('href')
        </div>
      </div>
    </div>
  </section>
  <div class="vertical-div"></div>
  <div style="clear:both"></div>
  @yield('company-content')
  <div class="vertical-div"></div>
</section>



@endsection
