</div>
    <!-- Footer: shared across all pages -->
    <footer class="footer text-center py-3 bg-light border-top fixed-bottom w-100" style="color:#666;font-size:13px;z-index:1030;">
      NJ MERCH SHOP COMPANY LTD &copy; <?=date('Y')?> | Designed by IT Patrick
    </footer>

    <!-- Scripts: only include here for reusability -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
    // Dark mode toggle (affects whole system and persists)
    document.getElementById('darkModeToggle').onclick = function() {
      document.body.classList.toggle('dark-mode');
      if(document.body.classList.contains('dark-mode')) {
        localStorage.setItem('darkMode', 'on');
      } else {
        localStorage.setItem('darkMode', 'off');
      }
      // Adjust footer for dark mode
      var footer = document.querySelector('footer.footer');
      if(document.body.classList.contains('dark-mode')) {
        footer.classList.add('bg-dark');
        footer.classList.remove('bg-light');
        footer.style.color = '#e0e0e0';
      } else {
        footer.classList.remove('bg-dark');
        footer.classList.add('bg-light');
        footer.style.color = '#666';
      }
    };
    // On load, set footer color for dark mode
    document.addEventListener('DOMContentLoaded', function() {
      var footer = document.querySelector('footer.footer');
      if(document.body.classList.contains('dark-mode')) {
        footer.classList.add('bg-dark');
        footer.classList.remove('bg-light');
        footer.style.color = '#e0e0e0';
      } else {
        footer.classList.remove('bg-dark');
        footer.classList.add('bg-light');
        footer.style.color = '#666';
      }
    });
    // If content is loaded dynamically, you may want to trigger a re-render or force a refresh of styles here.
    </script>

    <!-- End of main content. Do not add page-specific HTML below this line. -->
  </body>
</html>
