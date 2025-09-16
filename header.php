<!-- header.php -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm">
  <div class="container-fluid">
    <a class="navbar-brand fw-bold" href="index.php">Site de Recettes</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
      aria-controls="navbarNav" aria-expanded="false" aria-label="Menu">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ms-auto align-items-lg-center">
        <li class="nav-item">
          <a class="nav-link px-3" href="index.php">Accueil</a>
        </li>
        <li class="nav-item">
          <a class="nav-link px-3" href="contact.php">Contact</a>
        </li>
      </ul>
    </div>
  </div>
</nav>

<style>
  .nav-link {
    transition: color 0.3s, transform 0.2s;
  }

  .nav-link:hover {
    color: #ffc107;
    transform: scale(1.05);
  }

  .navbar-brand {
    transition: transform 0.3s;
  }

  .navbar-brand:hover {
    transform: scale(1.1);
  }
</style>