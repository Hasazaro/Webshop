document.addEventListener('DOMContentLoaded', function () {

    // ===== Swiper Slider =====
    if (document.querySelector('.swiper')) {
        new Swiper('.swiper', {
            loop: true,
            autoplay: { delay: 4000, disableOnInteraction: false },
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },
        });
    }

    // ===== Mobile Menu =====
    const menuIcon = document.getElementById('menu-icon');
    const navbar = document.getElementById('navbar');
    if (menuIcon && navbar) {
        menuIcon.addEventListener('click', function () {
            navbar.classList.toggle('open');
        });
        // Close menu when a link is clicked
        navbar.querySelectorAll('a').forEach(link => {
            link.addEventListener('click', () => navbar.classList.remove('open'));
        });
    }

    // ===== Cart =====
    const cartToggle = document.getElementById('cart-toggle');
    const cartContainer = document.getElementById('cart-container');
    const cartCountEl = document.getElementById('cart-count');
    const cartItemsList = document.getElementById('cart-items');
    const checkoutBtn = document.getElementById('checkout');

    let cart = JSON.parse(localStorage.getItem('jumbo-cart') || '[]');

    function saveCart() {
        localStorage.setItem('jumbo-cart', JSON.stringify(cart));
    }

    function renderCart() {
        if (!cartItemsList || !cartCountEl) return;

        cartItemsList.innerHTML = '';
        if (cart.length === 0) {
            cartItemsList.innerHTML = '<li class="cart-empty">Je winkelwagen is leeg</li>';
        } else {
            cart.forEach((item, index) => {
                const li = document.createElement('li');
                li.innerHTML = `
                    <span>${item.name}</span>
                    <span style="display:flex;align-items:center;gap:0.5rem;">
                        <strong>${item.price}</strong>
                        <i class='bx bx-trash' style="cursor:pointer;color:var(--accent)" data-index="${index}"></i>
                    </span>`;
                cartItemsList.appendChild(li);
            });
            // Remove item
            cartItemsList.querySelectorAll('.bx-trash').forEach(btn => {
                btn.addEventListener('click', function () {
                    cart.splice(parseInt(this.dataset.index), 1);
                    saveCart();
                    renderCart();
                });
            });
        }
        cartCountEl.textContent = cart.length;
    }

    // Toggle cart dropdown
    if (cartToggle && cartContainer) {
        cartToggle.addEventListener('click', function (e) {
            e.stopPropagation();
            cartContainer.classList.toggle('active');
        });
        // Close when clicking outside
        document.addEventListener('click', function (e) {
            if (!cartContainer.contains(e.target) && e.target !== cartToggle) {
                cartContainer.classList.remove('active');
            }
        });
    }

    // Add to cart buttons
    document.querySelectorAll('.bx-cart-alt').forEach(function (btn) {
        btn.addEventListener('click', function () {
            const box = this.closest('.box');
            if (!box) return;
            const nameEl = box.querySelector('h2');
            const priceEl = box.querySelector('.price');
            if (!nameEl || !priceEl) return;
            const name = nameEl.textContent.trim();
            const price = priceEl.textContent.trim();
            cart.push({ name, price });
            saveCart();
            renderCart();
            // Visual feedback
            this.style.background = 'var(--accent)';
            this.style.color = 'var(--white)';
            setTimeout(() => {
                this.style.background = '';
                this.style.color = '';
            }, 600);
            if (cartContainer) cartContainer.classList.add('active');
        });
    });

    // Checkout
    if (checkoutBtn) {
        checkoutBtn.addEventListener('click', function () {
            if (cart.length === 0) {
                alert('Je winkelwagen is leeg!');
                return;
            }
            alert('Bedankt voor je bestelling! We verwerken deze zo snel mogelijk.');
            cart = [];
            saveCart();
            renderCart();
            if (cartContainer) cartContainer.classList.remove('active');
        });
    }

    // Like buttons
    document.querySelectorAll('.bx-like').forEach(function (btn) {
        btn.addEventListener('click', function () {
            this.classList.toggle('active');
            this.classList.toggle('bxs-like');
        });
    });

    // Initial render
    renderCart();
});
