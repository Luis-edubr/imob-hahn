import './bootstrap';
import Alpine from 'alpinejs';

window.Alpine = Alpine;
Alpine.start();

// ============= FILTER BTN INTERACTIVITY =============
document.addEventListener('DOMContentLoaded', () => {
    const filterButtons = document.querySelectorAll('.filter-btn');
    
    filterButtons.forEach(button => {
        button.addEventListener('click', (e) => {
            e.preventDefault();
            
            // Toggle active state
            button.classList.toggle('active');
            
            // Close other filter buttons
            filterButtons.forEach(otherBtn => {
                if (otherBtn !== button && otherBtn.classList.contains('active')) {
                    otherBtn.classList.remove('active');
                }
            });
        });
    });

    // Close filters when clicking outside
    document.addEventListener('click', (e) => {
        if (!e.target.closest('.search-bar')) {
            filterButtons.forEach(btn => btn.classList.remove('active'));
        }
    });

    // Smooth scroll for anchor links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function(e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({ behavior: 'smooth' });
            }
        });
    });

    // Add page ready class
    document.body.classList.add('js-ready');
});
