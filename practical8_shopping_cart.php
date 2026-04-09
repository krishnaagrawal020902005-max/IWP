<?php
session_start();

// Initialize cart
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Products catalog
$products = [
    1 => ['id'=>1,'name'=>'Wireless Headphones','price'=>2499,'category'=>'Electronics','stock'=>15,'img'=>'🎧'],
    2 => ['id'=>2,'name'=>'Mechanical Keyboard','price'=>3299,'category'=>'Electronics','stock'=>8,'img'=>'⌨️'],
    3 => ['id'=>3,'name'=>'USB-C Hub (7-in-1)','price'=>1899,'category'=>'Electronics','stock'=>20,'img'=>'🔌'],
    4 => ['id'=>4,'name'=>'Laptop Stand','price'=>999,'category'=>'Accessories','stock'=>30,'img'=>'💻'],
    5 => ['id'=>5,'name'=>'Mouse Pad XL','price'=>599,'category'=>'Accessories','stock'=>50,'img'=>'🖱️'],
    6 => ['id'=>6,'name'=>'Webcam HD 1080p','price'=>2199,'category'=>'Electronics','stock'=>12,'img'=>'📷'],
    7 => ['id'=>7,'name'=>'Cable Organizer','price'=>349,'category'=>'Accessories','stock'=>100,'img'=>'🗂️'],
    8 => ['id'=>8,'name'=>'Monitor Light Bar','price'=>1799,'category'=>'Electronics','stock'=>7,'img'=>'💡'],
];

// Handle actions
$msg = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    $pid = (int)($_POST['product_id'] ?? 0);
    $qty = (int)($_POST['qty'] ?? 1);

    if ($action === 'add' && isset($products[$pid])) {
        if (isset($_SESSION['cart'][$pid])) {
            $_SESSION['cart'][$pid] += $qty;
        } else {
            $_SESSION['cart'][$pid] = $qty;
        }
        $msg = "✓ " . $products[$pid]['name'] . " added to cart!";
    } elseif ($action === 'remove' && isset($_SESSION['cart'][$pid])) {
        unset($_SESSION['cart'][$pid]);
        $msg = "Removed from cart.";
    } elseif ($action === 'update' && isset($_SESSION['cart'][$pid])) {
        if ($qty <= 0) unset($_SESSION['cart'][$pid]);
        else $_SESSION['cart'][$pid] = $qty;
        $msg = "Cart updated.";
    } elseif ($action === 'clear') {
        $_SESSION['cart'] = [];
        $msg = "Cart cleared.";
    } elseif ($action === 'checkout') {
        $_SESSION['cart'] = [];
        $msg = "ORDER_SUCCESS";
    }
}

// Cart totals
$subtotal = 0;
$cart_count = 0;
foreach ($_SESSION['cart'] as $pid => $qty) {
    if (isset($products[$pid])) {
        $subtotal += $products[$pid]['price'] * $qty;
        $cart_count += $qty;
    }
}
$shipping = $subtotal > 0 ? ($subtotal >= 2000 ? 0 : 99) : 0;
$total = $subtotal + $shipping;
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>TechCart — Online Store</title>
  <style>
    @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap');
    :root {
      --bg:#f7f8fa; --card:#fff; --primary:#6c47ff; --hover:#5236cc;
      --text:#1a1a2e; --muted:#8892a4; --border:#eaedf2;
      --success:#22c55e; --shadow:0 2px 12px rgba(0,0,0,0.07);
    }
    * { margin:0; padding:0; box-sizing:border-box; }
    body { background:var(--bg); color:var(--text); font-family:'Plus Jakarta Sans',sans-serif; }
    a { text-decoration:none; }

    /* NAV */
    nav {
      background:var(--card); border-bottom:1px solid var(--border);
      padding:0 40px; display:flex; align-items:center; justify-content:space-between; height:64px;
      position:sticky; top:0; z-index:100; box-shadow:var(--shadow);
    }
    .nav-logo { font-size:1.4rem; font-weight:700; color:var(--primary); }
    .nav-logo span { color:var(--text); }
    .cart-icon {
      display:flex; align-items:center; gap:8px;
      background:var(--primary); color:#fff; padding:8px 18px; border-radius:8px;
      font-size:0.85rem; font-weight:600; cursor:pointer;
    }
    .cart-badge {
      background:#fff; color:var(--primary); border-radius:50%; width:20px; height:20px;
      display:flex; align-items:center; justify-content:center; font-size:0.7rem; font-weight:700;
    }

    .layout { display:grid; grid-template-columns:1fr 360px; gap:24px; padding:30px 40px; max-width:1400px; margin:0 auto; }

    /* PRODUCTS */
    .section-title { font-size:1.2rem; font-weight:700; margin-bottom:20px; }
    .products-grid { display:grid; grid-template-columns:repeat(auto-fill,minmax(220px,1fr)); gap:16px; }
    .product-card {
      background:var(--card); border:1px solid var(--border); border-radius:12px;
      padding:20px; transition:box-shadow .2s, transform .2s;
    }
    .product-card:hover { box-shadow:0 6px 20px rgba(0,0,0,0.1); transform:translateY(-2px); }
    .prod-icon { font-size:2.5rem; margin-bottom:12px; }
    .prod-category { font-size:0.65rem; letter-spacing:2px; text-transform:uppercase; color:var(--muted); margin-bottom:6px; }
    .prod-name { font-weight:600; font-size:0.95rem; margin-bottom:8px; line-height:1.3; }
    .prod-price { font-size:1.2rem; font-weight:700; color:var(--primary); margin-bottom:16px; }
    .prod-price small { font-size:0.7rem; font-weight:400; color:var(--muted); }
    .add-form { display:flex; gap:6px; }
    .qty-input {
      width:50px; border:1px solid var(--border); border-radius:6px;
      padding:6px 8px; text-align:center; font-family:'Plus Jakarta Sans',sans-serif; outline:none;
    }
    .add-btn {
      flex:1; background:var(--primary); color:#fff; border:none;
      border-radius:6px; font-family:'Plus Jakarta Sans',sans-serif; font-size:0.8rem;
      font-weight:600; cursor:pointer; padding:8px; transition:background .2s;
    }
    .add-btn:hover { background:var(--hover); }

    /* CART */
    .cart-panel {
      background:var(--card); border:1px solid var(--border); border-radius:12px;
      padding:24px; position:sticky; top:84px; height:fit-content;
    }
    .cart-panel h2 { font-size:1rem; font-weight:700; margin-bottom:16px; display:flex; justify-content:space-between; align-items:center; }
    .cart-empty { text-align:center; padding:30px 0; color:var(--muted); font-size:0.9rem; }
    .cart-item {
      display:flex; align-items:center; gap:12px;
      padding:10px 0; border-bottom:1px solid var(--border);
    }
    .ci-icon { font-size:1.5rem; }
    .ci-info { flex:1; }
    .ci-name { font-size:0.85rem; font-weight:600; }
    .ci-price { font-size:0.75rem; color:var(--muted); }
    .ci-actions { display:flex; align-items:center; gap:6px; }
    .qty-form input { width:40px; border:1px solid var(--border); border-radius:4px; padding:4px; text-align:center; font-size:0.8rem; outline:none; }
    .rem-btn {
      background:transparent; border:1px solid #ffcdd2; color:#e57373;
      border-radius:4px; width:24px; height:24px; cursor:pointer; font-size:0.8rem;
      display:flex; align-items:center; justify-content:center;
    }

    .cart-summary { margin-top:16px; }
    .summary-row { display:flex; justify-content:space-between; font-size:0.85rem; margin-bottom:8px; color:var(--muted); }
    .summary-row.total { color:var(--text); font-weight:700; font-size:1rem; border-top:1px solid var(--border); padding-top:10px; margin-top:4px; }
    .free-ship { font-size:0.72rem; color:var(--success); margin-bottom:12px; }
    .checkout-btn {
      width:100%; background:var(--primary); color:#fff; border:none;
      padding:13px; border-radius:8px; font-family:'Plus Jakarta Sans',sans-serif;
      font-size:0.95rem; font-weight:700; cursor:pointer; transition:background .2s; margin-top:10px;
    }
    .checkout-btn:hover { background:var(--hover); }
    .clear-btn {
      width:100%; background:transparent; color:var(--muted); border:1px solid var(--border);
      padding:10px; border-radius:8px; font-family:'Plus Jakarta Sans',sans-serif;
      font-size:0.85rem; cursor:pointer; margin-top:8px; transition:all .2s;
    }
    .clear-btn:hover { border-color:#e57373; color:#e57373; }

    /* MSG */
    .msg-banner {
      margin:0 40px 20px; padding:12px 20px; border-radius:8px;
      font-size:0.85rem; font-weight:600;
    }
    .msg-add { background:#f0fdf4; color:#166534; border:1px solid #bbf7d0; }
    .msg-clear { background:#fef9c3; color:#713f12; border:1px solid #fde047; }

    /* SUCCESS */
    .order-success {
      text-align:center; padding:60px 40px;
      display:<?= ($msg==='ORDER_SUCCESS'?'block':'none') ?>;
    }
    .order-success h1 { font-size:2rem; color:var(--success); margin-bottom:10px; }
    .order-success p { color:var(--muted); margin-bottom:20px; }

    @media(max-width:900px){
      .layout { grid-template-columns:1fr; }
      .cart-panel { position:static; }
    }
  </style>
</head>
<body>

<nav>
  <div class="nav-logo">Tech<span>Cart</span></div>
  <div class="cart-icon">
    🛒 Cart <div class="cart-badge"><?= $cart_count ?></div>
  </div>
</nav>

<?php if ($msg === 'ORDER_SUCCESS'): ?>
<div class="order-success">
  <div style="font-size:5rem;margin-bottom:20px">🎉</div>
  <h1>Order Placed Successfully!</h1>
  <p>Thank you for shopping with TechCart. Your order has been confirmed.</p>
  <p style="font-size:0.85rem;color:var(--muted)">Order ID: TC-<?= rand(100000,999999) ?></p>
  <a href="practical8_shopping_cart.php">
    <button class="checkout-btn" style="max-width:200px;margin:20px auto 0">Continue Shopping</button>
  </a>
</div>
<?php else: ?>

<?php if ($msg && $msg !== 'ORDER_SUCCESS'): ?>
<div class="msg-banner msg-<?= strpos($msg,'✓')!==false?'add':'clear' ?>"><?= htmlspecialchars($msg) ?></div>
<?php endif; ?>

<div class="layout">
  <div>
    <div class="section-title">All Products</div>
    <div class="products-grid">
      <?php foreach ($products as $p): ?>
      <div class="product-card">
        <div class="prod-icon"><?= $p['img'] ?></div>
        <div class="prod-category"><?= $p['category'] ?></div>
        <div class="prod-name"><?= htmlspecialchars($p['name']) ?></div>
        <div class="prod-price">₹<?= number_format($p['price']) ?> <small>incl. taxes</small></div>
        <form method="POST" class="add-form">
          <input type="hidden" name="action" value="add"/>
          <input type="hidden" name="product_id" value="<?= $p['id'] ?>"/>
          <input class="qty-input" type="number" name="qty" value="1" min="1" max="<?= $p['stock'] ?>"/>
          <button type="submit" class="add-btn">Add to Cart</button>
        </form>
      </div>
      <?php endforeach; ?>
    </div>
  </div>

  <div class="cart-panel">
    <h2>Your Cart
      <?php if ($cart_count > 0): ?>
      <span style="font-size:0.75rem;color:var(--muted);font-weight:400"><?= $cart_count ?> items</span>
      <?php endif; ?>
    </h2>

    <?php if (empty($_SESSION['cart'])): ?>
    <div class="cart-empty">🛒<br/>Your cart is empty</div>
    <?php else: ?>
      <?php foreach ($_SESSION['cart'] as $pid => $qty):
        if (!isset($products[$pid])) continue;
        $p = $products[$pid]; ?>
      <div class="cart-item">
        <div class="ci-icon"><?= $p['img'] ?></div>
        <div class="ci-info">
          <div class="ci-name"><?= htmlspecialchars($p['name']) ?></div>
          <div class="ci-price">₹<?= number_format($p['price'] * $qty) ?></div>
        </div>
        <div class="ci-actions">
          <form method="POST" class="qty-form" style="display:flex;align-items:center;gap:4px">
            <input type="hidden" name="action" value="update"/>
            <input type="hidden" name="product_id" value="<?= $pid ?>"/>
            <input type="number" name="qty" value="<?= $qty ?>" min="0" max="10"
                   onchange="this.form.submit()" style="width:40px;border:1px solid var(--border);border-radius:4px;padding:4px;text-align:center;font-size:0.8rem;outline:none;"/>
          </form>
          <form method="POST">
            <input type="hidden" name="action" value="remove"/>
            <input type="hidden" name="product_id" value="<?= $pid ?>"/>
            <button type="submit" class="rem-btn">✕</button>
          </form>
        </div>
      </div>
      <?php endforeach; ?>

      <div class="cart-summary">
        <div class="summary-row"><span>Subtotal</span><span>₹<?= number_format($subtotal) ?></span></div>
        <div class="summary-row"><span>Shipping</span><span><?= $shipping===0?'<span style="color:var(--success)">Free</span>':'₹'.$shipping ?></span></div>
        <?php if ($subtotal > 0 && $subtotal < 2000): ?>
        <div class="free-ship">Add ₹<?= number_format(2000-$subtotal) ?> more for free shipping</div>
        <?php endif; ?>
        <div class="summary-row total"><span>Total</span><span>₹<?= number_format($total) ?></span></div>
      </div>

      <form method="POST">
        <input type="hidden" name="action" value="checkout"/>
        <button type="submit" class="checkout-btn">Proceed to Checkout →</button>
      </form>
      <form method="POST">
        <input type="hidden" name="action" value="clear"/>
        <button type="submit" class="clear-btn">Clear Cart</button>
      </form>
    <?php endif; ?>
  </div>
</div>

<?php endif; ?>

</body>
</html>
