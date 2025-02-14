@yield('navbar')
    <nav>
        <div class="container-fluid">
            <div class="left-ctn">
                <a href="{{route('home')}}">
                    <img src="{{ asset('storage/images/logo-fg.png') }}" alt="No logo">
                </a>
            </div>
            <div class="menu-right">
            <ul class="nav-menu">
                <li><a href="{{route('noutati')}}"  name="news">Noutati</li></a>
                <li><a href="{{route('fotografii')}}"  name="photo">Fotografii</li></a>
                <li><a href="{{route('about')}}"  name="about">Despre Noi</li></a>
                <li><a href="{{route('contacte')}}"  name="about">Contacte</li></a>
            </ul>
            <div class="hamburger">
                <span class="bar"></span>
                <span class="bar"></span>
                <span class="bar"></span>
            </div>
            </div>
        </div>
    </nav>
@php

@endphp
