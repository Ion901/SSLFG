@yield('footer')
<footer>
    <div class="section">
        <div class="gb-shapes">
            <div class="gb-shape gb-shape-1"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 230"
                    preserveAspectRatio="none">
                    <path d="M1200 207.2L600 0 0 207.2V230h1200z" fill="rgba(255,255,255,.25)"></path>
                </svg></div>
            <div class="gb-shape gb-shape-2"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 230"
                    preserveAspectRatio="none">
                    <path d="M1200 207.2L600 0 0 207.2V230h1200z" fill="rgba(255,255,255,.25)"></path>
                </svg></div>
            <div class="gb-shape gb-shape-3"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 230"
                    preserveAspectRatio="none">
                    <path d="M1200 207.2L600 0 0 207.2V230h1200z" fill="rgba(255,255,255,.25)"></path>
                </svg></div>
            <div class="gb-shape gb-shape-4"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 230"
                    preserveAspectRatio="none">
                    <path d="M1200 207.2L600 0 0 207.2V230h1200z" fill="rgba(255,255,255,.25)"></path>
                </svg></div>
        </div>
        <div class="section-container">
            <div class="description-number">
                <a href="{{route('home')}}"><img src="{{ asset('storage/images/logo-fg.png') }}" alt="No LOGO"></a>
                <p>Școala Sportivă Fundul Galbenei este una dintre cele mai eficiente școli din intreaga țară. <br> Nu o
                    spunem noi, numerele vorbesc de la sine</p>
                <h2>0269-75-725</h2>
            </div>
            <div class="info">
                <h2>Info</h2>
                <ul>
                    <li><a href="{{ route('noutati') }}" name="news">Noutati</li></a>
                    <li><a href="{{ route('fotografii') }}" name="photo">Fotografii</li></a>
                    <li><a href="{{ route('about') }}" name="about">Despre Noi</li></a>
                    <li><a href="{{ route('contacte') }}" name="about">Contacte</li></a>
                </ul>
            </div>
            <div class="info-hours">
                <h2>Orar</h2>
                <div class="orar">
                    <table>
                        <tr>
                            <td>Luni-Vineri</td>
                            <td>15:00 - 19:00</td>
                        </tr>
                        <tr>
                            <td>Simbata</td>
                            <td>Inchis</td>
                        </tr>
                        <tr>
                            <td>Duminica</td>
                            <td>Inchis</td>
                        </tr>
                    </table>
                </div>
                <div class="links">
                    <a href="mailto:{{env('MAIL_SSLFG')}}"><div><i class="fa-regular fa-envelope"></i></div></a>
                    <a href="tel:{{env('TEL_SSLFG')}}"><div><i class="fa-solid fa-phone"></i></div></a>
                    <a href="https://www.facebook.com/profile.php?id=100063663441299"><div><i class="fa-brands fa-facebook-f"></i></div></a>
                </div>
            </div>
        </div>
        <p class="copyright"><i class="fa-regular fa-copyright"></i> Școala Sportivă de lupte Fundul Galbenei - Toate drepturile rezervate
        </p>
    </div>

</footer>
