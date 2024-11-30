// File Upload Preview
$(document).ready(function() {
    // Custom file input
    $('.custom-file-input').on('change', function() {
        let fileName = $(this).val().split('\\').pop();
        $(this).next('.custom-file-label').addClass("selected").html(fileName);
        
        // Preview image
        if (this.files && this.files[0]) {
            let reader = new FileReader();
            reader.onload = function(e) {
                $('.profile-user-img').attr('src', e.target.result);
            }
            reader.readAsDataURL(this.files[0]);
        }
    });

    // Password strength meter
    $('input[name="new_password"]').on('input', function() {
        let password = $(this).val();
        let strength = 0;
        
        // Add points for password criteria
        if (password.length >= 8) strength += 25;
        if (password.match(/[A-Z]/)) strength += 25;
        if (password.match(/[0-9]/)) strength += 25;
        if (password.match(/[^A-Za-z0-9]/)) strength += 25;
        
        // Update strength bar
        let bar = $('.password-strength-bar');
        bar.css('width', strength + '%');
        
        // Change color based on strength
        if (strength < 25) {
            bar.css('background', '#dc3545');
        } else if (strength < 50) {
            bar.css('background', '#ffc107');
        } else if (strength < 75) {
            bar.css('background', '#17a2b8');
        } else {
            bar.css('background', '#28a745');
        }
    });

    // Form validation
    $('form').on('submit', function(e) {
        let newPass = $('input[name="new_password"]').val();
        let confirmPass = $('input[name="confirm_password"]').val();
        
        if (newPass !== confirmPass) {
            e.preventDefault();
            alert('Password baru dan konfirmasi password tidak cocok!');
        }
    });

    // Animate profile card on hover
    $('.profile-card').hover(
        function() {
            $(this).find('.profile-user-img').css('transform', 'scale(1.05)');
        },
        function() {
            $(this).find('.profile-user-img').css('transform', 'scale(1)');
        }
    );

    // Smooth scroll for navigation
    $('a[href^="#"]').on('click', function(e) {
        e.preventDefault();
        $('html, body').animate({
            scrollTop: $($(this).attr('href')).offset().top - 70
        }, 500);
    });
});

// Add loading animation
function showLoading() {
    $('#loading-screen').fadeIn();
}

function hideLoading() {
    $('#loading-screen').fadeOut();
}

// Form submit with loading
$('form').on('submit', function() {
    showLoading();
});
