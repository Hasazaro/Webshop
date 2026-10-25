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
    // The cart is a list of { id, name, price, qty }, saved in localStorage
    // so it is still there after a page reload.
    const CART_KEY = 'jumbo-cart';
    const cartToggle = document.getElementById('cart-toggle');
    const cartContainer = document.getElementById('cart-container');
    const cartCountEl = document.getElementById('cart-count');
    const cartItemsList = document.getElementById('cart-items');
    const cartTotalEl = document.getElementById('cart-total');
    const checkoutBtn = document.getElementById('checkout');

    let cart = loadCart();

    function loadCart() {
        try {
            const saved = JSON.parse(localStorage.getItem(CART_KEY));
            // Ignore carts saved by the old version (they had no id/qty)
            return Array.isArray(saved) ? saved.filter(item => item.id && item.qty) : [];
        } catch (e) {
            return [];
        }
    }

    function saveCart() {
        localStorage.setItem(CART_KEY, JSON.stringify(cart));
    }

    function formatPrice(amount) {
        return amount.toLocaleString('nl-NL', { style: 'currency', currency: 'EUR' });
    }

    function addToCart(product) {
        const existing = cart.find(item => item.id === product.id);
        if (existing) {
            existing.qty++;
        } else {
            cart.push({ ...product, qty: 1 });
        }
        saveCart();
        renderCart();
    }

    function changeQty(id, change) {
        const item = cart.find(item => item.id === id);
        if (!item) return;
        item.qty += change;
        if (item.qty <= 0) {
            cart = cart.filter(item => item.id !== id);
        }
        saveCart();
        renderCart();
    }

    // Small helper to create an element with a class and text
    function createEl(tag, className, text) {
        const el = document.createElement(tag);
        if (className) el.className = className;
        if (text !== undefined) el.textContent = text;
        return el;
    }

    function renderCart() {
        if (!cartItemsList || !cartCountEl) return;

        cartItemsList.innerHTML = '';
        if (cart.length === 0) {
            cartItemsList.appendChild(createEl('li', 'cart-empty', 'Je winkelwagen is leeg'));
        }

        cart.forEach(item => {
            // textContent instead of innerHTML: a product name can never inject HTML or scripts
            const minus = createEl('button', 'qty-btn', '−');
            const plus = createEl('button', 'qty-btn', '+');
            minus.addEventListener('click', () => changeQty(item.id, -1));
            plus.addEventListener('click', () => changeQty(item.id, 1));

            const controls = createEl('span', 'cart-item-controls');
            controls.append(minus, createEl('span', '', item.qty), plus,
                createEl('strong', '', formatPrice(item.price * item.qty)));

            const li = document.createElement('li');
            li.append(createEl('span', 'cart-item-name', item.name), controls);
            cartItemsList.appendChild(li);
        });

        const count = cart.reduce((sum, item) => sum + item.qty, 0);
        const total = cart.reduce((sum, item) => sum + item.price * item.qty, 0);
        cartCountEl.textContent = count;
        if (cartTotalEl) cartTotalEl.textContent = formatPrice(total);
    }

    // Toggle cart dropdown
    if (cartToggle && cartContainer) {
        cartToggle.addEventListener('click', function (e) {
            e.stopPropagation();
            cartContainer.classList.toggle('active');
        });
        // Close when clicking outside the cart
        document.addEventListener('click', function (e) {
            const clickedInside = cartContainer.contains(e.target)
                || cartToggle.contains(e.target)
                || e.target.closest('.add-to-cart');
            if (!clickedInside) {
                cartContainer.classList.remove('active');
            }
        });
    }

    // Add to cart buttons: the product data comes from the data-* attributes set in product-card.php
    document.querySelectorAll('.add-to-cart').forEach(function (btn) {
        btn.addEventListener('click', function () {
            addToCart({
                id: Number(this.dataset.id),
                name: this.dataset.name,
                price: Number(this.dataset.price),
            });
            // Visual feedback
            this.classList.add('added');
            setTimeout(() => this.classList.remove('added'), 600);
            if (cartContainer) cartContainer.classList.add('active');
        });
    });

    // Checkout: send the cart to checkout.php with a hidden form.
    // Only id + qty are sent. The server looks up the prices itself, because
    // anything coming from the browser (like a price) can be changed by the user.
    if (checkoutBtn) {
        checkoutBtn.addEventListener('click', function () {
            if (cart.length === 0) {
                alert('Je winkelwagen is leeg!');
                return;
            }
            if (this.dataset.loggedIn !== '1') {
                window.location.href = this.dataset.loginUrl;
                return;
            }

            const form = document.createElement('form');
            form.method = 'post';
            form.action = this.dataset.checkoutUrl;

            const fields = {
                csrf_token: document.querySelector('meta[name="csrf-token"]').content,
                cart: JSON.stringify(cart.map(item => ({ id: item.id, qty: item.qty }))),
            };
            for (const [name, value] of Object.entries(fields)) {
                const input = document.createElement('input');
                input.type = 'hidden';
                input.name = name;
                input.value = value;
                form.appendChild(input);
            }

            document.body.appendChild(form);
            form.submit();
        });
    }

    // Right after a successful order (order.php?new=1) the cart is emptied
    if (document.querySelector('[data-clear-cart]')) {
        cart = [];
        saveCart();
    }

    // Like buttons
    document.querySelectorAll('.bx-like').forEach(function (btn) {
        btn.addEventListener('click', function () {
            this.classList.toggle('active');
            this.classList.toggle('bxs-like');
        });
    });

    // Show password checkbox (login page)
    const showPassword = document.getElementById('show-password');
    const passwordInput = document.getElementById('password');
    if (showPassword && passwordInput) {
        showPassword.addEventListener('change', function () {
            passwordInput.type = this.checked ? 'text' : 'password';
        });
    }

    // Flash message: fade out after 4 seconds
    const flash = document.getElementById('flash-message');
    if (flash) {
        setTimeout(() => flash.classList.add('hide'), 4000);
        setTimeout(() => flash.remove(), 4500);
    }

    // Initial render
    renderCart();
});
