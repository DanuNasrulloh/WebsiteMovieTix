// MovieSystem.js
class MovieSystem {
    constructor() {
        this.movies = [
            {
                id: 1,
                title: "Jurassic Park (1993)",
                image: "../IMAGE/jurasicOne.jpg",
                description: "Taman hiburan yang menampilkan dinosaurus hasil kloning menjadi kacau ketika sistem keamanan gagal.",
                price: 50000
            },
            {
                id: 2,
                title: "The Lost World: Jurassic Park (1997)", 
                image: "../IMAGE/urutanDua.jpg",
                description: "Tim peneliti dikirim ke pulau kedua tempat dinosaurus hasil kloning hidup bebas.",
                price: 50000
            },
            {
                id: 3,
                title: "Jurassic Park III (2001)",
                image: "../IMAGE/urutanTiga.jpg",
                description: "Dalam Jurassic Park III (2001), Dr. Alan Grant, seorang paleontolog, diminta untuk menemani sepasang suami istri yang memiliki motif tersembunyi ke pulau Isla Sorna, yang merupakan tempat tinggal dinosaurus. Mereka berusaha mencari anak mereka yang hilang. Namun, setelah mereka tiba di pulau tersebut, situasi menjadi berbahaya ketika mereka menghadapi berbagai ancaman dari dinosaurus yang menghuninya.",
                price: 50000
            },
            {
                id: 4,
                title: "Jurassic World (2015)",
                image: "../IMAGE/urutanKeempat.jpg",
                description: "Taman dinosaurus baru menghadapi bencana ketika dinosaurus hybrid kabur.",
                price: 50000
            },
            {
                id: 5,
                title: "Jurassic World: Fallen Kingdom (2018)",
                image: "../IMAGE/urutankelima.jpg",
                description: "Misi penyelamatan dinosaurus dari pulau yang akan meledak.",
                price: 50000
            },
            {
                id: 6,
                title: "Jurassic World: Dominion (2022)",
                image: "../IMAGE/urutankeenam.jpg",
                description: "Dinosaurus kini hidup bebas di seluruh dunia bersama manusia.",
                price: 50000
            }
        ];

        // Binding methods
        this.handleQuantityChange = this.handleQuantityChange.bind(this);
        this.handleTimeSlotClick = this.handleTimeSlotClick.bind(this);
    }

    initializeHome() {
        const cards = document.querySelectorAll('.card');
        cards.forEach((card, index) => {
            card.addEventListener('click', () => {
                this.redirectToBooking(this.movies[index]);
            });
            // Make cards clickable
            card.style.cursor = 'pointer';
        });
    }

    redirectToBooking(movie) {
        localStorage.setItem('selectedMovie', JSON.stringify(movie));
        window.location.href = 'Booking.html';
    }

    initializeBooking() {
        const movieData = JSON.parse(localStorage.getItem('selectedMovie'));
        if (!movieData) return;

        // Update UI elements
        document.querySelector('.movie-poster img').src = movieData.image;
        document.querySelector('.movie-title').textContent = movieData.title;
        document.querySelector('.movie-description').textContent = movieData.description;

        // Setup event listeners
        const quantityInput = document.querySelector('input[type="number"]');
        quantityInput.addEventListener('change', this.handleQuantityChange);

        const timeSlots = document.querySelectorAll('.time-slot');
        timeSlots.forEach(slot => {
            slot.addEventListener('click', this.handleTimeSlotClick);
        });

        // Initialize booking summary
        this.updateTotalPrice(1);
    }

    handleQuantityChange(event) {
        const quantity = parseInt(event.target.value);
        this.updateTotalPrice(quantity);
    }

    handleTimeSlotClick(event) {
        const timeSlots = document.querySelectorAll('.time-slot');
        timeSlots.forEach(slot => slot.style.backgroundColor = '#f0f0f0');
        event.target.style.backgroundColor = '#007bff';
        event.target.style.color = 'white';
    }

    updateTotalPrice(quantity) {
        const movieData = JSON.parse(localStorage.getItem('selectedMovie'));
        const totalPrice = movieData.price * quantity;
        document.querySelector('.summary-row:last-child span:last-child')
            .textContent = `Rp ${totalPrice.toLocaleString()}`;
    }
}