/* main.js */

// Import bricks.js.
import Bricks from '../assets/bricks.js';
jQuery(document).ready(function($) {
    
    // Initialize AOS.
    AOS.init({ once: true });

    // Sizes.
    const sizes = [
        { columns: 2, gutter: 10 },
        { mq: '768px', columns: 3, gutter: 25 },
        { mq: '1024px', columns: 4, gutter: 50 }
    ];

    // Initialize Bricks.
    const instance = Bricks({
        container: '.bricks-container',
        packed:    'data-packed',
        item:     '.brick',
        position:  true,
        sizes:     sizes
    });

    // Callbacks.
    instance.on('pack', function() {
        console.log('All grid items packed.');
    });

    // Start packing.
    instance.pack();
    
    // Repack on window resize.
    window.addEventListener('resize', function() {
        instance.resize(true);
    });

});