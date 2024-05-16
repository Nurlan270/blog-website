<div class="footer container-fluid">
    <div class="footer-content container">
        <div class="row">
            <div class="footer-section about col-md-4 col-12">
                <h3 class="logo-text">My blog</h3>
                <p>
                    My blog - its about PHP and
                    some PHP frameworks and also databases
                </p>
                <div class="contact">
                    <span><i class="fas fa-phone"> &nbsp; 123-456-78-90</i></span>
                    <span><i class="fas fa-envelope"> &nbsp; info@myblog.com</i></span>
                </div>
                <div class="socials">
                    <a href="#"><i class="fab fa-facebook"></i></a>
                    <a href="#"><i class="fab fa-instagram"></i></a>
                    <a href="#"><i class="fab fa-twitter"></i></a>
                    <a href="#"><i class="fab fa-youtube"></i></a>
                </div>
            </div>
            <div class="footer-section links col-md-4 col-12">
                <h3>Quick Links</h3>
                <br>
                <ul>
                    <a href="#">
                        <li>⇒ Events</li>
                    </a>
                    <a href="#">
                        <li>⇒ Team</li>
                    </a>
                    <a href="#">
                        <li>⇒ Exercises</li>
                    </a>
                    <a href="#">
                        <li>⇒ Gallery</li>
                    </a>
                </ul>
            </div>

            <div class="footer-section contact-form col-md-4 col-12">
                <h3>Contacts</h3>
                <br>
                <form action="/" method="post">
                    <?php if (empty($_SESSION['id'])): ?>
                    <input type="email" name="email" class="text-input contact-input" placeholder="Your email address..." required>
                    <?php endif; ?>
                    <textarea rows="4" name="message" class="text-input contact-input"
                              placeholder="Your message..." required></textarea>
                    <button type="submit" name="sendEmail" class="btn btn-big contact-btn">
                        <i class="fas fa-envelope"></i>
                        Send
                    </button>
                </form>
            </div>
        </div>

        <div class="footer-bottom">
            &copy; myblog.com | Designed by our team with ❤ &nbsp; <a href="https://wakatime.com/badge/user/80806877-0f60-4335-8770-5f7f4880ae56/project/5760e79c-bd6e-4279-bb77-74fd19e8b057"><img src="https://wakatime.com/badge/user/80806877-0f60-4335-8770-5f7f4880ae56/project/5760e79c-bd6e-4279-bb77-74fd19e8b057.svg" alt="WakaTime Stats"></a>
        </div>
    </div>
</div>