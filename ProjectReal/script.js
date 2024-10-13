
    // Get the login circle and dropdown menu elements
    const loginCircle = document.querySelector('.login-circle');
    const dropdownMenu = document.querySelector('.dropdown-menu');

    // Toggle the visibility of the dropdown menu when login-circle is clicked
    loginCircle.addEventListener('click', () => {
        dropdownMenu.style.display = dropdownMenu.style.display === 'block' ? 'none' : 'block';
    });

    // Optional: Close the dropdown if the user clicks outside of it
    document.addEventListener('click', (event) => {
        if (!loginCircle.contains(event.target)) {
            dropdownMenu.style.display = 'none';
        }
    });

    document.getElementById('bid-button').addEventListener('click', function() {
        const bidderName = prompt("Enter your name to place a bid:");
        if (bidderName) {
            const bidderList = document.getElementById('bidder-list');
            const newBidder = document.createElement('li');
            newBidder.textContent = bidderName + " has placed a bid.";
            bidderList.appendChild(newBidder);
        }
    });
    