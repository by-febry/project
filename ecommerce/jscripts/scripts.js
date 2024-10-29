const loginBtn = document.querySelector('.btnLogin-popup');
        const popup = document.getElementById('popupForm');
        const closeBtn = document.getElementById('closeBtn');
        const closeRegisterBtn = document.getElementById('closeRegisterBtn');
        const registerLink = document.querySelector('.register-link');
        const loginLink = document.querySelector('.login-link');

        loginBtn.addEventListener('click', () => {
            popup.style.display = 'flex';
            document.getElementById('loginForm').style.display = 'block';
        });

        closeBtn.addEventListener('click', () => {
            popup.style.display = 'none';
        });

        closeRegisterBtn.addEventListener('click', () => {
            popup.style.display = 'none';
        });

        registerLink.addEventListener('click', (e) => {
            e.preventDefault();
            document.getElementById('loginForm').style.display = 'none';
            document.getElementById('registerForm').style.display = 'block';
        });

        loginLink.addEventListener('click', (e) => {
            e.preventDefault();
            document.getElementById('registerForm').style.display = 'none';
            document.getElementById('loginForm').style.display = 'block';
        });

        