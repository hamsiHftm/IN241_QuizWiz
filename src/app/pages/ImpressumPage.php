<?php
require_once '../controllers/AuthController.php';

// Start the session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php require_once '../components/HeadComponent.php' ?>
</head>
<body>
<?php require_once '../components/HeaderComponent.php'; ?>
<div class="container-sm">
    <div class="qw-content">
        <div>
            <h1>Impressum</h1>

            <section class="qw-section">
                <h2>Höhere Fachschule Technik Mittelland</h2>
                <ul class="list-unstyled">
                    <li>
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                             class="bi bi-telephone" viewBox="0 0 16 16">
                            <path d="M3.654 1.328a.678.678 0 0 0-1.015-.063L1.605 2.3c-.483.484-.661 1.169-.45 1.77a17.568 17.568 0 0 0 4.168 6.608 17.569 17.569 0 0 0 6.608 4.168c.601.211 1.286.033 1.77-.45l1.034-1.034a.678.678 0 0 0-.063-1.015l-2.307-1.794a.678.678 0 0 0-.58-.122l-2.19.547a1.745 1.745 0 0 1-1.657-.459L5.482 8.062a1.745 1.745 0 0 1-.46-1.657l.548-2.19a.678.678 0 0 0-.122-.58L3.654 1.328zM1.884.511a1.745 1.745 0 0 1 2.612.163L6.29 2.98c.329.423.445.974.315 1.494l-.547 2.19a.678.678 0 0 0 .178.643l2.457 2.457a.678.678 0 0 0 .644.178l2.189-.547a1.745 1.745 0 0 1 1.494.315l2.306 1.794c.829.645.905 1.87.163 2.611l-1.034 1.034c-.74.74-1.846 1.065-2.877.702a18.634 18.634 0 0 1-7.01-4.42 18.634 18.634 0 0 1-4.42-7.009c-.362-1.03-.037-2.137.703-2.877L1.885.511z"/>
                        </svg>
                        +41 032 654 12 00
                    </li>
                    <li>
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                             class="bi bi-envelope" viewBox="0 0 16 16">
                            <path d="M0 4a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V4Zm2-1a1 1 0 0 0-1 1v.217l7 4.2 7-4.2V4a1 1 0 0 0-1-1H2Zm13 2.383-4.708 2.825L15 11.105V5.383Zm-.034 6.876-5.64-3.471L8 9.583l-1.326-.795-5.64 3.47A1 1 0 0 0 2 13h12a1 1 0 0 0 .966-.741ZM1 11.105l4.708-2.897L1 5.383v5.722Z"/>
                        </svg>
                        sekretariat@hftm.ch
                    </li>
                </ul>
            </section>

            <section class="qw-section">
                <h2>Kavi Kanagalingam &amp; Hamsiga Rajaratnam</h2>
                <ul class="list-unstyled">
                    <li>
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                             class="bi bi-envelope" viewBox="0 0 16 16">
                            <path d="M0 4a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V4Zm2-1a1 1 0 0 0-1 1v.217l7 4.2 7-4.2V4a1 1 0 0 0-1-1H2Zm13 2.383-4.708 2.825L15 11.105V5.383Zm-.034 6.876-5.64-3.471L8 9.583l-1.326-.795-5.64 3.47A1 1 0 0 0 2 13h12a1 1 0 0 0 .966-.741ZM1 11.105l4.708-2.897L1 5.383v5.722Z"/>
                        </svg>
                        kavi.kanagalingam@hftm.ch
                    </li>
                    <li>
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                             class="bi bi-envelope" viewBox="0 0 16 16">
                            <path d="M0 4a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V4Zm2-1a1 1 0 0 0-1 1v.217l7 4.2 7-4.2V4a1 1 0 0 0-1-1H2Zm13 2.383-4.708 2.825L15 11.105V5.383Zm-.034 6.876-5.64-3.471L8 9.583l-1.326-.795-5.64 3.47A1 1 0 0 0 2 13h12a1 1 0 0 0 .966-.741ZM1 11.105l4.708-2.897L1 5.383v5.722Z"/>
                        </svg>
                        hamsiga.rajaratnam@hftm.ch
                    </li>
                </ul>
            </section>

            <section class="qw-section">
                <h2>Authorised representatives</h2>
                <p>Kavi Kanagalingam, Hamsiga Rajaratnam</p>
            </section>

            <section class="qw-section">
                <h2>Disclaimer</h2>
                <p>The information provided on this website is for general informational purposes only. We strive to
                    keep the information accurate and up to date, but we make no representations or warranties of any
                    kind, express or implied, about the completeness, accuracy, reliability, suitability, or
                    availability with respect to the website or the information, products, services, or related graphics
                    contained on the website.</p>
            </section>

            <section class="qw-section">
                <h2>Liability for Links</h2>
                <p>The information provided on this website is for general informational purposes only. We strive to
                    keep the information accurate and up to date, but we make no representations or warranties of any
                    kind, express or implied, about the completeness, accuracy, reliability, suitability, or
                    availability with respect to the website or the information, products, services, or related graphics
                    contained on the website.</p>
            </section>

        </div>
    </div>
</div>
<?php require_once '../components/FooterComponent.php'; ?>
</body>
</html>
