document.addEventListener('DOMContentLoaded', () => {
    const fileInput = document.getElementById('profile_pic');
    const imagePreview = document.getElementById('img-preview');

    // 1. Live Image Preview Logic
    fileInput.addEventListener('change', function(event) {
        const file = event.target.files[0];

        if (file) {
            if (!file.type.startsWith('image/')) {
                alert("Invalid format: Please select a valid image file (JPG, PNG).");
                this.value = ""; 
                return;
            }

            if (file.size > 2 * 1024 * 1024) {
                alert("File size limit exceeded: Please choose an image under 2MB.");
                this.value = "";
                return;
            }

            const reader = new FileReader();
            reader.onload = function(e) {
                imagePreview.src = e.target.result;
                imagePreview.style.display = 'block';
                
                imagePreview.style.opacity = 0;
                setTimeout(() => {
                    imagePreview.style.transition = "opacity 0.4s ease";
                    imagePreview.style.opacity = 1;
                }, 10);
            };

            reader.readAsDataURL(file);
        }
    });

    // 2. Subtle Input Animation
    const inputs = document.querySelectorAll('input, textarea');
    inputs.forEach(input => {
        input.addEventListener('focus', () => {
            input.parentElement.style.transform = "translateY(-2px)";
            input.parentElement.style.transition = "transform 0.3s ease";
        });
        
        input.addEventListener('blur', () => {
            input.parentElement.style.transform = "translateY(0)";
        });
    });
});
