<style>
    body {
        background-image: url('../image/dev4.jpg');
        background-size: cover;
        background-position: center;
        height: 100vh;
    }

    body::after {
        content: '';
        display: block;
        position: fixed;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(255, 255, 255, 0.1); 
        z-index: -1; 
    }
</style>
