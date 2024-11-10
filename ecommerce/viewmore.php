<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Explore Batangas - Art Gallery</title>
    <link rel="stylesheet" href="css/librarys.css">
  
</head>
<body>
    <!-- Navigation Bar -->
    <header>
        <div class="logo">
            <img src="img/logo3.png" alt="Logo" />
        </div>
        <nav>
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="shop.php">Shop</a></li>
                <li><a href="#">About</a></li>
                <li><a href="login.html">Login</a></li>
            </ul>
        </nav>
        <div class="login-circle">
            <div class="user-icon"></div>
        </div>
    </header>

    <!-- Main Content -->
    <main id="pageContainer">
        <!-- Festival Sections -->
        <section class="page page1">
            <div class="page-image">
                <div class="page-image-fullscreen" style="background-image: url('img/tapusan.jpg');"></div>
            </div>
            <div class="page-content">
                <h1 class="event-title">Tapusan Festival</h1>
                <p class="event-location">Alitagtag, Batangas, Philippines</p>
                <p class="event-description">
                    Experience the vibrant culmination of Flores de Mayo at the Tapusan Festival. This cultural celebration honors the Holy Cross through stunning religious processions, elaborate floral installations, and a grand parade.
                </p>
                <a href="#" class="location-btn" onclick="openMap('mapModal1')">Location</a>
            </div>
        </section>
        <div id="mapModal1" class="modal">
            <div class="modal-content">
                <span class="close-btn" onclick="closeMap('mapModal1')">&times;</span>
                <iframe id="map-iframe"
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d15493.574003017357!2d121.01843721541371!3d13.87440039026992!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x33bd0fd80e54c34f%3A0x437f2087f5c21c53!2sAlitagtag%2C%20Batangas!5e0!3m2!1sen!2sph!4v1710645573513!5m2!1sen!2sph"
                    width="600" height="450"
                    style="border:0;"
                    allowfullscreen=""
                    loading="lazy"
                    referrerpolicy="no-referrer-when-downgrade">
                </iframe>
            </div>
        </div>

        <section class="page page2">
            <div class="page-image">
                <div class="page-image-fullscreen" style="background-image: url('img/sublian_festival.webp');"></div>
            </div>
            <div class="page-content">
                <h1 class="event-title">Sublian Festival</h1>
                <p class="event-location">Batangas City, Philippines</p>
                <p class="event-description">
                    This festival celebrates the devotion to the Holy Cross and Santo Niño (Child Jesus). It highlights the traditional Subli dance and other Batangueño cultural performances.
                </p>
                <a href="#" class="location-btn" onclick="openMap('mapModal2')">Location</a>
            </div>
        </section>
        <div id="mapModal2" class="modal">
            <div class="modal-content">
                <span class="close-btn" onclick="closeMap('mapModal2')">&times;</span>
                <iframe id="map-iframe"
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d123901.40751539036!2d121.00149824179688!3d13.756666!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x33bd0fea065f1aff%3A0x4c7f489de558ff2!2sBatangas%20City%2C%20Batangas!5e0!3m2!1sen!2sph!4v1710645573513!5m2!1sen!2sph"
                    width="600" height="450"
                    style="border:0;"
                    allowfullscreen=""
                    loading="lazy"
                    referrerpolicy="no-referrer-when-downgrade">
                </iframe>
            </div>
        </div>

        <section class="page page3">
            <div class="page-image">
                <div class="page-image-fullscreen" style="background-image: url('img/Paradanglechon.jpg');"></div>
            </div>
            <div class="page-content">
                <h1 class="event-title">Parada ng Lechon</h1>
                <p class="event-location">Balayan, Batangas, Philippines</p>
                <p class="event-description">
                    The festival features a grand parade of roasted pigs (lechon), decorated in colorful attire. Attendees usually douse each other with water, celebrating both the feast and Filipino culture.
                </p>
                <a href="#" class="location-btn" onclick="openMap('mapModal3')">Location</a>
            </div>
        </section>
        <div id="mapModal3" class="modal">
            <div class="modal-content">
                <span class="close-btn" onclick="closeMap('mapModal3')">&times;</span>
                
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d61954.15373830944!2d120.68866516552214!3d13.95058966976329!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x33bda321fa23c4af%3A0x15255e1209796544!2sBalayan%2C%20Batangas!5e0!3m2!1sen!2sph!4v1730648892917!5m2!1sen!2sph"
                        width="600"
                        height="450"
                        style="border:0;"
                        allowfullscreen=""
                        loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade">
                    </iframe>
            </div>
        </div>

        <section class="page page4">
            <div class="page-image">
                <div class="page-image-fullscreen" style="background-image: url('img/ElPasubatFestival.jpg');"></div>
            </div>
            <div class="page-content">
                <h1 class="event-title">El Pasubat Festival</h1>
                <p class="event-location">Taal, Batangas, Philippines</p>
                <p class="event-description">
                    Named after Taal’s delicacies (Empanada, Longganisa, Panutsa, Suman, Barong, Balisong, Tapang Taal), this festival highlights the town's rich culinary and cultural heritage.
                </p>
                <a href="#" class="location-btn" onclick="openMap('mapModal4')">Location</a>
            </div>
        </section>
        <div id="mapModal4" class="modal">
            <div class="modal-content">
                <span class="close-btn" onclick="closeMap('mapModal4')">&times;</span>
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d61970.33001393953!2d120.89698658833612!3d13.89023934794681!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x33bd0a1efabef203%3A0x4ef524d256f82617!2sTaal%2C%20Batangas!5e0!3m2!1sen!2sph!4v1730645524610!5m2!1sen!2sph"
                        width="600"
                        height="450"
                        style="border:0;"
                        allowfullscreen=""
                        loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade">
                    </iframe>
            </div>
        </div>

        <section class="page page5">
            <div class="page-image">
                <div class="page-image-fullscreen" style="background-image: url('img/BalsaFesitval.jpg');"></div>
            </div>
            <div class="page-content">
                <h1 class="event-title">Balsa Festival</h1>
                <p class="event-location">Lian, Batangas, Philippines</p>
                <p class="event-description">
                    A celebration of thanksgiving for the town's bountiful sea resources, with a focus on traditional bamboo rafts (balsa) and fluvial parades.
                </p>
                <a href="#" class="location-btn" onclick="openMap('mapModal5')">Location</a>
            </div>
        </section>
        <div id="mapModal5" class="modal">
            <div class="modal-content">
                <span class="close-btn" onclick="closeMap('mapModal5')">&times;</span>
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d123885.52554903114!2d120.56275800456045!3d13.992933897040006!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x33bd965879bed27b%3A0x5621337013ad1e0e!2sLian%2C%20Batangas!5e0!3m2!1sen!2sph!4v1730645542639!5m2!1sen!2sph" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>
        </div>

        <section class="page page6">
            <div class="page-image">
                <div class="page-image-fullscreen" style="background-image: url('img/sublian_festival.webp');"></div>
            </div>
            <div class="page-content">
                <h1 class="event-title">Kapurpurawan Festival</h1>
                <p class="event-location">Lobo, Batangas, Philippines</p>
                <p class="event-description">
                    Known as the "Kapeng Barako Festival," it honors the coffee industry, especially Batangas’ famous barako coffee. It includes cultural shows, coffee exhibits, and dance parades.
                </p>
                <a href="#" class="location-btn" onclick="openMap('mapModal6')">Location</a>
            </div>
        </section>
        <div id="mapModal6" class="modal">
            <div class="modal-content">
                <span class="close-btn" onclick="closeMap('mapModal6')">&times;</span>
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d62013.95129148797!2d120.87576503742214!3d13.726201085524549!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x33bd2203014b54d7%3A0x7716e3f4d7c9cf0c!2sLobo%2C%20Batangas!5e0!3m2!1sen!2sph!4v1730645674895!5m2!1sen!2sph" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>
        </div>

        <section class="page page7">
            <div class="page-image">
                <div class="page-image-fullscreen" style="background-image: url('img/sigpawanfestuival.jfif');"></div>
            </div>
            <div class="page-content">
                <h1 class="event-title">Sigpawan Festival</h1>
                <p class="event-location">Calaca, Batangas, Philippines</p>
                <p class="event-description">
                    This festival celebrates the end of the harvest season, highlighting the community's agricultural roots with street dancing and displays of local produce.
                </p>
                <a href="#" class="location-btn" onclick="openMap('mapModal7')">Location</a>
            </div>
        </section>
        <div id="mapModal7" class="modal">
            <div class="modal-content">
                <span class="close-btn" onclick="closeMap('mapModal7')">&times;</span>
                <iframe id="map-iframe"
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d61957.91474672417!2d120.78947611878667!3d13.934999141570461!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x33bd9d5f6e0f5d4f%3A0x95d885c5f4183f0e!2sCalaca%2C%20Batangas!5e0!3m2!1sen!2sph!4v1710646892133!5m2!1sen!2sph"
                    width="600"
                    height="450"
                    style="border:0;"
                    allowfullscreen=""
                    loading="lazy"
                    referrerpolicy="no-referrer-when-downgrade">
                </iframe>
            </div>
        </div>

        <section class="page page8">
            <div class="page-image">
                <div class="page-image-fullscreen" style="background-image: url('img/tinapayfestival.jfif');"></div>
            </div>
            <div class="page-content">
                <h1 class="event-title">Tinapay Festival</h1>
                <p class="event-location">Cuenca, Batangas, Philippines</p>
                <p class="event-description">
                    This festival celebrates the town's bread-making industry, with a grand display of local bread and pastries, parades, and cultural events.
                </p>
                <a href="#" class="location-btn" onclick="openMap('mapModal8')">Location</a>
            </div>
        </section>
        <div id="mapModal8" class="modal">
            <div class="modal-content">
                <span class="close-btn" onclick="closeMap('mapModal8')">&times;</span>
                <iframe id="map-iframe"
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d61965.74282710775!2d121.04244583125!3d13.904999000000002!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x33bd0f9f591f7acf%3A0x46d7625e587b927e!2sCuenca%2C%20Batangas!5e0!3m2!1sen!2sph!4v1710647892133!5m2!1sen!2sph"
                    width="600" height="450"
                    style="border:0;"
                    allowfullscreen=""
                    loading="lazy"
                    referrerpolicy="no-referrer-when-downgrade">
                </iframe>
            </div>
        </div>

        <section class="page page9">
            <div class="page-image">
                <div class="page-image-fullscreen" style="background-image: url('img/sublian_festival.webp');"></div>
            </div>
            <div class="page-content">
                <h1 class="event-title">Mabini Founding Anniversary and Dive Festival</h1>
                <p class="event-location">Mabini, Batangas, Philippines</p>
                <p class="event-description">
                    Celebrated in honor of the town’s foundation, it highlights the world-renowned diving spots and marine biodiversity of Anilao, Mabini.
                </p>
                <a href="#" class="location-btn" onclick="openMap('mapModal9')">Location</a>
            </div>
        </section>
        <div id="mapModal9" class="modal">
            <div class="modal-content">
                <span class="close-btn" onclick="closeMap('mapModal9')">&times;</span>
                <iframe id="map-iframe"
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d61965.74282710775!2d121.0424458312!3d13.904999000000002!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x33bd0f9f591f7acf%3A0x46d7625e587b927e!2sMabini%2C%20Batangas!5e0!3m2!1sen!2sph!4v1710647892133!5m2!1sen!2sph"
                    width="600" height="450"
                    style="border:0;"
                    allowfullscreen=""
                    loading="lazy"
                    referrerpolicy="no-referrer-when-downgrade">
                </iframe>
            </div>
        </div>

        <section class="page page10">
            <div class="page-image">
                <div class="page-image-fullscreen" style="background-image: url('img/Tilapia.jfif');"></div>
            </div>
            <div class="page-content">
                <h1 class="event-title">Tilapia Festival</h1>
                <p class="event-location">Laurel, Batangas, Philippines</p>
                <p class="event-description">
                    Tilapia Festival is a vibrant celebration highlighting the significance of tilapia farming in the region. Tanauan, located near Taal Lake—a major source of tilapia—hosts this annual festival to honor local fish farmers, showcase various tilapia dishes, and promote sustainable aquaculture practices.
                </p>
                <a href="#" class="location-btn" onclick="openMap('mapModal10')">Location</a>
            </div>
        </section>
        <div id="mapModal10" class="modal">
            <div class="modal-content">
                <span class="close-btn" onclick="closeMap('mapModal10')">&times;</span>
                <iframe id="map-iframe"
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d61965.74282710775!2d120.9424458312!3d13.904999000000002!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x33bd0f9f591f7acf%3A0x46d7625e587b927e!2sLaurel%2C%20Batangas!5e0!3m2!1sen!2sph!4v1710647892133!5m2!1sen!2sph"
                    width="600" height="450"
                    style="border:0;"
                    allowfullscreen=""
                    loading="lazy"
                    referrerpolicy="no-referrer-when-downgrade">
                </iframe>
            </div>
        </div>

        <section class="page page11">
            <div class="page-image">
                <div class="page-image-fullscreen" style="background-image: url('img/lambayok.webp');"></div>
            </div>
            <div class="page-content">
                <h1 class="event-title">Lambayok Festival</h1>
                <p class="event-location">San Juan, Batangas, Philippines</p>
                <p class="event-description">
                    The Lambayok Festival highlights the town's main sources of livelihood: "Lambanog" (local coconut wine), "Palayok" (clay pots), and "Karagatan" (the sea). The festival includes parades, street dances, and contests, promoting local products and tourism.
                </p>
                <a href="#" class="location-btn" onclick="openMap('mapModal11')">Location</a>
            </div>
        </section>
        <div id="mapModal11" class="modal">
            <div class="modal-content">
                <span class="close-btn" onclick="closeMap('mapModal11')">&times;</span>
                <iframe id="map-iframe"
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d61965.74282710775!2d121.3524458312!3d13.824999000000002!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x33bd101e87c1b84f%3A0xa0f829f24d013e0!2sSan%20Juan%2C%20Batangas!5e0!3m2!1sen!2sph!4v1710647892133!5m2!1sen!2sph"
                    width="600" height="450"
                    style="border:0;"
                    allowfullscreen=""
                    loading="lazy"
                    referrerpolicy="no-referrer-when-downgrade">
                </iframe>
            </div>
        </div>

        <div id="pageCounter" class="page-counter">
            Page <span id="currentPageNum">1</span> / <span id="totalPageNum">11</span>
        </div>
    </main>

    <!-- Navigation Arrows -->
    <div class="nav-arrows">
        <div class="nav-arrow" id="leftArrow">&#8592;</div>
        <div class="nav-arrow" id="rightArrow">&#8594;</div>
    </div>

    <!-- Footer -->
    <footer>
        <p>&copy; 2024 Explore Batangas. All Rights Reserved.</p>
        <a href="#">Privacy Policy</a> | 
        <a href="#">Terms of Service</a> | 
        <a href="#">Contact Us</a>
    </footer>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
        const pages = document.querySelectorAll('.page');
        const leftArrow = document.getElementById("leftArrow");
        const rightArrow = document.getElementById("rightArrow");
        
        let currentPage = 0;
        const totalPages = pages.length;
        
        // Update total pages counter
        document.getElementById('totalPageNum').textContent = totalPages;

        function updatePage() {
            // Hide all pages first
            pages.forEach(page => page.classList.remove('active'));
            
            // Show current page
            pages[currentPage].classList.add('active');
            
            // Update arrows visibility
            leftArrow.style.display = currentPage === 0 ? 'none' : 'block';
            rightArrow.style.display = currentPage === totalPages - 1 ? 'none' : 'block';
            
            // Update page counter
            document.getElementById('currentPageNum').textContent = currentPage + 1;
        }

        leftArrow.addEventListener("click", () => {
            if (currentPage > 0) {
                currentPage--;
                updatePage();
            }
        });

        rightArrow.addEventListener("click", () => {
            if (currentPage < totalPages - 1) {
                currentPage++;
                updatePage();
            }
        });

        // Initialize first page
        updatePage();
    });

    function openMap(modalId) {
        document.getElementById(modalId).style.display = "block";
    }

    function closeMap(modalId) {
        document.getElementById(modalId).style.display = "none";
    }

    // Close modal when clicking outside of it
    window.onclick = function(event) {
        if (event.target.classList.contains('modal')) {
            event.target.style.display = "none";
        }
    }
    </script>
</body>
</html>
