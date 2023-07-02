<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
  <div class="container">
    <a class="navbar-brand" href="/"><?= APP_NAME ?></a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbar" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbar">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link <?= isActive(url('/')) ?>" href="<?= url('/') ?>">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link <?= isActive(url('/products')) ?>" href="<?= url('/products') ?>">Products List</a>
        </li>
      </ul>
    </div>
  </div>
</nav>
