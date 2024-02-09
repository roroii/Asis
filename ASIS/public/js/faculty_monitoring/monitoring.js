        // Function to handle page limit change and page navigation
        function handlePageLimitChange(pageLimit) {
            var currentPage = parseInt(data.current_page);
            var url = new URL(window.location.href);
            url.searchParams.set('limit', pageLimit);
            url.searchParams.set('page', 1);
            window.location.href = url.toString();
        }

        // Function to handle page navigation
        function handlePageNavigation(page) {
            var url = new URL(window.location.href);
            url.searchParams.set('page', page);
            url.searchParams.delete('limit');
            window.location.href = url.toString();
        }

        // Listen for page limit change event
        var pageLimitDropdown = document.getElementById('page-limit');
        pageLimitDropdown.addEventListener('change', function(e) {
            var pageLimit = e.target.value;
            handlePageLimitChange(pageLimit);
        });

        // Add event listeners for page navigation
        var pageLinks = document.querySelectorAll('#pagination .page-link');
        pageLinks.forEach(function(link) {
            link.addEventListener('click', function(e) {
                e.preventDefault();
                var page = this.textContent;
                handlePageNavigation(page);
            });
        });

        // Update active class on page buttons
        function updateActiveButton() {
            var pageItems = document.querySelectorAll('#pagination .page-item');
            pageItems.forEach(function(item) {
                var link = item.querySelector('.page-link');
                if (parseInt(link.textContent.trim()) === data.current_page) {
                    item.classList.add('active');
                } else {
                    item.classList.remove('active');
                }
            });
        }

        updateActiveButton();

        // Initialize the page limit dropdown
        function initializePageLimitDropdown() {
            var pageLimitDropdown = document.getElementById('page-limit');
            var limitQueryParam = parseInt(getQueryParam('limit'));
            pageLimitDropdown.value = limitQueryParam ? limitQueryParam : 8;
        }

        // Get the count element
        var pageEntryCount = document.getElementById('page-entry-count');

        // Update the entry count
        function updateEntryCount() {
            var entryCount = document.getElementById('page-entry-count');
            if (entryCount) {
                var currentPage = parseInt(data.current_page);
                var perPage = parseInt(data.per_page);
                var total = parseInt(data.total);
                var count = Math.min(perPage * currentPage, total);
                var start = (currentPage - 1) * perPage + 1;
                entryCount.textContent = 'Showing ' + start + ' to ' + count + ' of ' + total + ' sessions';
            }
        }

        // Call the initialization functions
        initializePageLimitDropdown();
        updateEntryCount();

        // Get the search input element
        var searchInput = document.getElementById('search-input');

        // Function to handle search
        function handleSearch() {
            var searchValue = searchInput.value.toLowerCase();
            var url = new URL(window.location.href);
            url.searchParams.set('search', searchValue);
            url.searchParams.set('page', 1);
            window.location.href = url.toString();
        }

        // Add an event listener for input changes
        // searchInput.addEventListener('input', function(e) {
        //     handleSearch();
        // });

        // Add an event listener for Enter key press
        searchInput.addEventListener('keyup', function(e) {
            if (e.key === 'Enter') {
                handleSearch();
            }
        });

        // Function to get query parameter by name
        function getQueryParam(name) {
            var urlParams = new URLSearchParams(window.location.search);
            return urlParams.get(name);
        }

        // Get the filter dropdown element
        var filterDropdown = document.getElementById('filter-dropdown');

        // Function to handle filter change
        function handleFilterChange() {
            var filterValue = filterDropdown.value;
            var url = new URL(window.location.href);
            url.searchParams.set('filter', filterValue);
            url.searchParams.set('page', 1);
            window.location.href = url.toString();
        }

        // Add an event listener for filter change
        filterDropdown.addEventListener('change', function(e) {
            handleFilterChange();
        });
