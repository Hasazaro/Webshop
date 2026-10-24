<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Webshop</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css">
</head>
<body>
    <?php include "navbar.php"; ?>
    <div class="container">
        <!-- Cart Icon in Header -->
        <div class="cart">
            <i class='bx bx-cart'></i>
            <span id="cart-count">0</span>
        </div>

        <!-- Cart Container -->
        <div class="cart-container" id="cart-container">
            <h2>Your Cart</h2>
            <ul id="cart-items"></ul>
            <button id="checkout">Checkout</button>
        </div>

        <!-- Products Section -->
        <section class="products" id="products">
            <div class="heading">
                <h1>Our Popular <br><span>Products</span></h1>
                <a href="products.html" class="btn">View more<i class='bx bx-right-arrow-alt'></i></a>
            </div>
            <div class="products-container">
                <?php
                // Fetch products from the database
                $sql = "SELECT * FROM products";
                $dbStatement = $dbConnection->prepare($sql);
                $dbStatement->execute();
                $products = $dbStatement->fetchAll(PDO::FETCH_ASSOC);

                if (!empty($products)):
                    foreach ($products as $product):
                ?>
                <div class="box">
                    <img src="images/<?= $product['image']; ?>" alt="<?= $product['name']; ?>">
                    <h2><?= $product['name']; ?></h2>
                    <h3 class="price">$<?= $product['price']; ?></h3>
                    <p><b><?= $product['description']; ?></b></p>
                    <button class="add-to-cart" data-id="<?= $product['id']; ?>">Add to Cart</button>
                </div>
                <?php
                    endforeach;
                endif;
                ?>
            </div>
        </section>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const cart = [];
            const cartCount = document.getElementById('cart-count');
            const cartItems = document.getElementById('cart-items');
            const addToCartButtons = document.querySelectorAll('.add-to-cart');

            addToCartButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const productId = this.getAttribute('data-id');
                    addToCart(productId);
                });
            });

            function addToCart(productId) {
                const productInCart = cart.find(product => product.id === productId);
                if (productInCart) {
                    productInCart.quantity++;
                } else {
                    const product = {
                        id: productId,
                        name: document.querySelector(`.box button[data-id="${productId}"]`).parentNode.querySelector('h2').textContent,
                        price: document.querySelector(`.box button[data-id="${productId}"]`).parentNode.querySelector('.price').textContent,
                        quantity: 1
                    };
                    cart.push(product);
                }
                updateCartDisplay();
            }

            function updateCartDisplay() {
                cartItems.innerHTML = '';
                cart.forEach(product => {
                    const li = document.createElement('li');
                    li.textContent = `${product.name} - ${product.price} x ${product.quantity}`;
                    cartItems.appendChild(li);
                });
                cartCount.textContent = cart.length;
            }

            document.getElementById('checkout').addEventListener('click', function() {
                if (cart.length === 0) {
                    alert('Your cart is empty');
                } else {
                    alert('Proceeding to checkout...');
                }
            });
        });
    </script>
</body>
</html>
