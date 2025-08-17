import './bootstrap';

document.addEventListener("DOMContentLoaded", function() {
    const canvas = document.getElementById('particleCanvas');
    const ctx = canvas.getContext('2d');
    let width = canvas.width = window.innerWidth;
    let height = canvas.height = window.innerHeight;

    window.addEventListener('resize', () => {
        width = canvas.width = window.innerWidth;
        height = canvas.height = window.innerHeight;
    });

    const particles = [];
    const particleCount = 80;

    for(let i = 0; i < particleCount; i++) {
        particles.push({
            x: Math.random() * width,
            y: Math.random() * height,
            radius: Math.random() * 3 + 1,
            dx: (Math.random() - 0.5) * 1.5,
            dy: (Math.random() - 0.5) * 1.5
        });
    }

    function draw() {
        ctx.clearRect(0, 0, width, height);
        particles.forEach(p => {
            ctx.beginPath();
            ctx.arc(p.x, p.y, p.radius, 0, Math.PI * 2);
            ctx.fillStyle = '#FC9905';
            ctx.fill();

            p.x += p.dx;
            p.y += p.dy;

            if(p.x < 0 || p.x > width) p.dx *= -1;
            if(p.y < 0 || p.y > height) p.dy *= -1;
        });

        requestAnimationFrame(draw);
    }

    draw();

    const modalEl = document.getElementById('exampleModal');
    const myModal = new bootstrap.Modal(modalEl, {backdrop:'static', keyboard:false});
    myModal.show();

    const form = document.getElementById('memberForm');
    form.addEventListener('submit', function(e){
        let isValid = true;

        ['firstNameError','lastNameError','dsDivisionError','summaryError','dobError'].forEach(id=>{
            document.getElementById(id).innerText = '';
        });

        const firstName = document.getElementById('firstName').value.trim();
        if(!firstName){ 
            document.getElementById('firstNameError').innerText = 'First Name is required'; 
            isValid = false;
        }

        const lastName = document.getElementById('lastName').value.trim();
        if(!lastName){ 
            document.getElementById('lastNameError').innerText = 'Last Name is required'; 
            isValid = false;
        }

        const dsDivision = document.getElementById('ds_division').value;
        if(!dsDivision){ 
            document.getElementById('dsDivisionError').innerText = 'Please select a DS Division'; 
            isValid = false;
        }

        const summary = document.getElementById('summary').value.trim();
        if(!summary){ 
            document.getElementById('summaryError').innerText = 'Summary is required'; 
            isValid = false;
        }

        const dob = document.getElementById('dob').value;
        if(!dob){ 
            document.getElementById('dobError').innerText = 'Date of Birth is required'; 
            isValid = false;
        }

        if(!isValid) e.preventDefault();
    });
});

function redirectHome() {
  window.location.href = "{{ route('home') }}";
}