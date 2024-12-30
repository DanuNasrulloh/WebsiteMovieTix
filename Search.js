class Search {
    constructor() {
        this.movies = [
            { title: "Jurassic Park (1993)", element: null },
            { title: "The Lost World: Jurassic Park (1997)", element: null },
            { title: "Jurassic Park III (2001)", element: null },
            { title: "Jurassic World (2015)", element: null },
            { title: "Jurassic World: Fallen Kingdom (2018)", element: null },
            { title: "Jurassic World: Dominion (2022)", element: null }
        ];
    }

    initializeHome() {
        // Initialize search functionality
        const searchInput = document.getElementById('searchInput');
        const searchButton = document.getElementById('searchButton');
        
        // Get all movie cards and store them in the movies array
        const cards = document.querySelectorAll('.card');
        cards.forEach((card, index) => {
            this.movies[index].element = card;
        });

        // Add event listeners
        searchButton.addEventListener('click', () => this.performSearch());
        searchInput.addEventListener('keypress', (e) => {
            if (e.key === 'Enter') {
                this.performSearch();
            }
        });

        // Add input event for real-time search
        searchInput.addEventListener('input', () => this.performSearch());
    }

    performSearch() {
        const searchInput = document.getElementById('searchInput');
        const searchTerm = searchInput.value.toLowerCase().trim();
        let hasResults = false;

        // Remove existing "no results" message if it exists
        const existingNoResults = document.querySelector('.no-results');
        if (existingNoResults) {
            existingNoResults.remove();
        }

        // Search through movies
        this.movies.forEach(movie => {
            const isMatch = movie.title.toLowerCase().includes(searchTerm);
            
            if (isMatch) {
                movie.element.classList.remove('hidden');
                hasResults = true;
            } else {
                movie.element.classList.add('hidden');
            }
        });

        // Show "no results" message if necessary
        if (!hasResults && searchTerm !== '') {
            const cardGrid = document.querySelector('.card-grid');
            const noResults = document.createElement('div');
            noResults.className = 'no-results';
            noResults.textContent = 'Tidak ada film yang ditemukan';
            cardGrid.appendChild(noResults);
        }
    }
}