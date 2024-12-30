class koneksisistem {
    constructor() {
        this.bookingData = {
            movieTitle: '',
            movieDescription: '',
            selectedDate: '',
            selectedTime: '',
            selectedSeats: [],
            ticketPrice: 50000,
            ticketCount: 1,
            totalPrice: 50000,
            customerName: '' // This would come from user authentication
        };
    }

    initializeBooking() {
        // Load any existing booking data from localStorage
        const savedData = localStorage.getItem('bookingData');
        if (savedData) {
            this.bookingData = JSON.parse(savedData);
        }

        this.setupEventListeners();
        this.updateDisplay();
    }

    setupEventListeners() {
        // Date selection
        const dateInput = document.querySelector('input[type="date"]');
        if (dateInput) {
            dateInput.addEventListener('change', (e) => {
                this.bookingData.selectedDate = e.target.value;
                this.saveBookingData();
            });
        }

        // Time slot selection
        const timeSlots = document.querySelectorAll('.time-slot');
        timeSlots.forEach(slot => {
            slot.addEventListener('click', (e) => {
                timeSlots.forEach(s => s.classList.remove('selected'));
                e.target.classList.add('selected');
                this.bookingData.selectedTime = e.target.textContent;
                this.saveBookingData();
            });
        });

        // Ticket count
        const ticketInput = document.querySelector('input[type="number"]');
        if (ticketInput) {
            ticketInput.addEventListener('change', (e) => {
                this.bookingData.ticketCount = parseInt(e.target.value);
                this.bookingData.totalPrice = this.bookingData.ticketPrice * this.bookingData.ticketCount;
                this.updateDisplay();
                this.saveBookingData();
            });
        }

        // Next button
        const nextButton = document.querySelector('.next-button');
        if (nextButton) {
            nextButton.addEventListener('click', () => {
                this.saveBookingData();
                window.location.href = 'pembayaran.html';
            });
        }
    }

    updateDisplay() {
        // Update selected seats display
        const seatsDisplay = document.getElementById('selected-seats-display');
        if (seatsDisplay) {
            const selectedSeats = JSON.parse(localStorage.getItem('selectedSeats')) || [];
            this.bookingData.selectedSeats = selectedSeats;
            seatsDisplay.textContent = selectedSeats.length > 0 
                ? `Kursi yang dipilih: ${selectedSeats.join(', ')}` 
                : 'Kursi yang dipilih: Belum ada';
        }

        // Update price displays
        const totalPriceElement = document.querySelector('.summary-row:last-child span:last-child');
        if (totalPriceElement) {
            totalPriceElement.textContent = `Rp ${this.bookingData.totalPrice.toLocaleString()}`;
        }
    }

    saveBookingData() {
        localStorage.setItem('bookingData', JSON.stringify(this.bookingData));
    }
}

// Payment handling code
class PaymentSystem {
    constructor() {
        this.bookingData = null;
    }

    initialize() {
        this.loadBookingData();
        this.updatePaymentDisplay();
    }

    loadBookingData() {
        const savedData = localStorage.getItem('bookingData');
        if (savedData) {
            this.bookingData = JSON.parse(savedData);
        }
    }

    updatePaymentDisplay() {
        if (!this.bookingData) return;

        // Update table data
        document.querySelector('td:nth-child(1)').textContent = this.bookingData.customerName || '[Nama]';
        document.querySelector('td:nth-child(2)').textContent = this.bookingData.movieTitle || '[Nama Film]';
        document.querySelector('td:nth-child(3)').textContent = this.bookingData.selectedSeats.join(', ') || '[Nomor kursi]';
        document.querySelector('td:nth-child(4)').textContent = this.bookingData.ticketCount || '[Jumlah tiket]';

        // Update price information
        const priceElements = document.querySelectorAll('p');
        priceElements[0].textContent = `Harga tiket: Rp ${this.bookingData.ticketPrice.toLocaleString()}`;
        priceElements[1].textContent = `Jumlah: ${this.bookingData.ticketCount}`;
        priceElements[2].textContent = `Total Harga: Rp ${this.bookingData.totalPrice.toLocaleString()}`;
    }
}