<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<style>
    /* ================= FOOTER ================= */
.site-footer {
    background: #4b0008; /* deep maroon */
    padding: 70px 0 60px;
    color: #e6e6e6;
    font-family: 'Inter', sans-serif;
}

.site-footer h4 {
    font-family: 'Merriweather', serif;
    font-size: 22px;
    margin-bottom: 14px;
    color: #fff;
}

.site-footer h6 {
    font-family: 'Inter', sans-serif;
    font-size: 13px;
    font-weight: 600;
    margin-bottom: 14px;
    color: #fff;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.site-footer p {
    font-size: 13px;
    line-height: 1.6;
    color: #d2d2d2;
    margin-bottom: 18px;
}

/* LINKS */
.site-footer ul {
    list-style: none;
    padding: 0;
    margin: 0;
}

.site-footer ul li {
    font-size: 13px;
    margin-bottom: 8px;
    color: #d2d2d2;
}

.site-footer ul li a {
    color: #d2d2d2;
    text-decoration: none;
}

.site-footer ul li a:hover {
    color: #ffffff;
}

/* SOCIAL */
.footer-social {
    display: flex;
    gap: 12px;
}

.footer-social a {
    color: #ffffff;
    font-size: 14px;
}

/* CONTACT LIST */
.contact-list li {
    margin-bottom: 14px;
    line-height: 1.5;
}

.contact-list strong {
    font-size: 12px;
    color: #ffffff;
}

/* RESPONSIVE */
@media (max-width: 768px) {
    .site-footer {
        text-align: center;
    }

    .footer-social {
        justify-content: center;
    }
}

</style>
<footer class="site-footer">
    <div class="container">
        <div class="row">

            <!-- BRAND -->
            <div class="col-lg-3 col-md-6 footer-brand">
                <h4>ArtistiQe</h4>
                <p>
                    A global art space dedicated to bridging the
                    gap between artistic creation and meaningful
                    collection.
                </p>

                <div class="footer-social">
                    <a href="#"><i class="fab fa-facebook-f"></i></a>
                    <a href="#"><i class="fab fa-instagram"></i></a>
                    <a href="#"><i class="fab fa-linkedin-in"></i></a>
                    <a href="#"><i class="fab fa-youtube"></i></a>
                </div>
            </div>

            <!-- ARTISTIQE -->
            <div class="col-lg-2 col-md-6">
                <h6>ArtistiQe</h6>
                <ul>
                    <li><a href="#">About ArtistiQe</a></li>
                    <li><a href="#">Mission &amp; Values</a></li>
                    <li><a href="#">ArtistiQe Team</a></li>
                </ul>
            </div>

            <!-- EXPLORE -->
            <div class="col-lg-2 col-md-6">
                <h6>Explore</h6>
                <ul>
                    <li><a href="#">Collections</a></li>
                    <li><a href="#">Artists</a></li>
                    <li><a href="#">Events</a></li>
                    <li><a href="#">Publications</a></li>
                </ul>
            </div>

            <!-- SUPPORT -->
            <div class="col-lg-2 col-md-6">
                <h6>Support</h6>
                <ul>
                    <li><a href="#">Contact</a></li>
                    <li><a href="#">FAQs</a></li>
                    <li><a href="#">Policies</a></li>
                    <li><a href="#">Shipping &amp; Logistics</a></li>
                </ul>
            </div>

            <!-- CONTACT -->
            <div class="col-lg-3 col-md-6">
                <h6>Contacts</h6>
                <ul class="contact-list">
                    <li><strong>Email</strong><br>info@artistiqe.com</li>
                    <li><strong>Phone</strong><br>9311442886</li>
                    <li>
                        <strong>Address</strong><br>
                        30/78, 3rd Floor, I Thum Tower-A, A-40,
                        Sector 62, Noida, Uttar Pradesh 201301
                    </li>
                </ul>
            </div>

        </div>
    </div>
</footer>
