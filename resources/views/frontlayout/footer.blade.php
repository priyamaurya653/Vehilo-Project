<footer class="site-footer">
    <div class="footer-orb footer-orb-1" aria-hidden="true"></div>
    <div class="footer-orb footer-orb-2" aria-hidden="true"></div>

    <div class="container">

        <div class="footer-grid">

            {{-- Brand --}}
            <div class="footer-brand">
                <a href="{{ url('/') }}" class="brand brand-light">
                    <img src="{{ asset('image/vehilo1.png') }}" alt="Wheelo" class="brand-logo footer-logo"
                    >

                </a>
                <p class="footer-tagline">Smarter. Cleaner. Connected.</p>
                <p class="footer-about">India's complete vehicle rental marketplace — rent, list or partner with every kind of vehicle in one place.</p>

                <ul class="footer-contact">
                    <li><span><i data-lucide="map-pin" class="ic-xs"></i></span> Lucknow, India</li>
                    <li><span><i data-lucide="mail" class="ic-xs"></i></span> <a href="mailto:info@wheelo.in">info@wheelo.in</a></li>
                    <li><span><i data-lucide="phone" class="ic-xs"></i></span> <a href="tel:+910000000000">+91 00000 00000</a></li>
                </ul>
            </div>

            {{-- Company --}}
            <div class="footer-col">
                <h4>Company</h4>
                <ul>
                    <li><a href="{{ url('/about') }}">About Us</a></li>
                    <li><a href="{{ url('/vision') }}">Our Vision</a></li>
                    <li><a href="{{ url('/partner') }}">Become a Partner</a></li>
                    <li><a href="{{ url('/careers') }}">Careers</a></li>
                    <li><a href="{{ url('/contact') }}">Contact</a></li>
                </ul>
            </div>

            {{-- Legal --}}
            <div class="footer-col">
                <h4>Legal</h4>
                <ul>
                    <li><a href="{{ url('/privacy-policy') }}">Privacy Policy</a></li>
                    <li><a href="{{ url('/terms') }}">Terms &amp; Conditions</a></li>
                    <li><a href="{{ url('/refund-policy') }}">Refund Policy</a></li>
                    <li><a href="{{ url('/contact') }}">Help Center</a></li>
                </ul>
            </div>

            {{-- Social + CTA --}}
            <div class="footer-col">
                <h4>Follow Wheelo</h4>
                <div class="social-row">
                    <a href="#" aria-label="Instagram"><i data-lucide="instagram" class="ic-sm"></i></a>
                    <a href="#" aria-label="Facebook"><i data-lucide="facebook" class="ic-sm"></i></a>
                    <a href="#" aria-label="LinkedIn"><i data-lucide="linkedin" class="ic-sm"></i></a>
                    <a href="#" aria-label="X / Twitter"><i data-lucide="twitter" class="ic-sm"></i></a>
                </div>

                <div class="footer-cta">
                    <span class="footer-cta-ic"><i data-lucide="zap" class="ic-sm"></i></span>
                    <div>
                        <p>Ready to move smarter?</p>
                        <a href="{{ url('/vehicles') }}">Book your EV <i data-lucide="arrow-right" class="ic-xs"></i></a>
                    </div>
                </div>

                <p class="footer-support"><span class="live-dot"></span> 24/7 customer support</p>
            </div>

        </div>

        {{-- Big wordmark --}}
        <div class="footer-wordmark" aria-hidden="true">VEHILO</div>

        <div class="footer-bottom">
            <span>&copy; {{ date('Y') }} Wheelo Mobility Pvt. Ltd. All rights reserved.</span>
            <span class="mono">India's Smart Electric Mobility Platform</span>
            <button type="button" class="to-top" id="toTop" aria-label="Back to top">
                <i data-lucide="arrow-up" class="ic-sm"></i>
            </button>
        </div>

    </div>
</footer>