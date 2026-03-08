<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    document.querySelector(".sidebar-toggle").onclick = function() {

      document.querySelector(".sidebar").classList.toggle("collapsed");

    }

    function toggleDark() {

      document.body.classList.toggle("dark-mode");

    }

    function mobileMenu() {

      document.querySelector(".sidebar").classList.toggle("active");

    }
  </script>
