@extends("layouts.app")

@section('content')

{{-- Toast message to show success feedback after create or edit --}}
@if(session('success'))
<div class="position-fixed top-0 end-0 p-3" style="z-index: 1055;">
    <div class="toast align-items-center text-white bg-success border-0" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="d-flex">
            <div class="toast-body">
                {{ session('success') }}
            </div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
    </div>
</div>
@endif

    <div>
        <canvas id="particleCanvas"></canvas>
        <div class="d-flex justify-content-center align-items-center">
            <h1 class="animated-text text-center">Accura Member List</h1>
        </div>
        <div class="d-flex justify-content-between mb-3">
            <form method="GET" action="{{ route('home') }}">
                <div class="input-group">
                    <input type="text" name="search" id="search" 
                        class="form-control" 
                        placeholder="Search by Last Name" 
                        value="{{ request('search') }}"
                        style="background: transparent; border: 1px solid #ffc107; padding: 5px; border-radius: 5px; color: #ffffff;"
                    >
                    <button class="btn btn-outline-warning" type="submit">Search</button>
                </div>
            </form>
            <a href="{{ route('members.index') }}" class="btn btn-outline-warning">Add New Member</a>
        </div>
        <div style="max-height: 470px; overflow-y: auto;">
            @if($members->count() > 0)
                <table class="table">
                    <thead class="table-dark">
                        <tr>
                            <th scope="col">First Name</th>
                            <th scope="col">Last First</th>
                            <th scope="col">Date of Birth</th>
                            <th scope="col">DS Division</th>
                            <th scope="col">Summary</th>
                            <th scope=""col>Action</th>
                        </tr>
                    </thead>
                    <tbody class="">
                        @foreach ($members as $member)
                            <tr>
                                <th>{{ $member->firstName}}</th>
                                <td>{{ $member->lastName}}</td>
                                <td>{{ $member->dob}}</td>
                                <td>{{ $member->division->name ?? '-' }}</td>
                                <td>{{ $member->summary}}</td>
                                <td>
                                    <a href="{{ route('members.index', ['member_id' => $member->id]) }}" class="btn btn-success">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <button type="button" class="btn btn-danger" 
                                        onclick="confirmDelete('{{ $member->id }}', '{{ $member->firstName }} {{ $member->lastName }}')">
                                            <i class="bi bi-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <div style="text-align: center; padding: 2px;">
                    <img src="{{ asset('images/no.gif') }}" alt="No Data" 
                        style="width:350px; height:auto; display:block; margin:0 auto;">
                    <p class="animated-text" style="color: #FC9905; margin-top: 10px; font-size: 30px; font-weight: bold;">No Data Available</p>
                </div>
            @endif
        </div>
        {{-- Delete Confirmation --}}
        <div class="modal fade" id="deleteModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Confirm Delete</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p id="deleteMessage"></p>
                    <input type="text" id="confirmInput" class="form-control mt-2" placeholder="Type full name here">
                </div>
                <div class="modal-footer">
                    <form id="deleteForm" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" id="deleteBtn" class="btn btn-danger" disabled>Yes, Delete</button>
                    </form>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                </div>
            </div>
        </div>
    </div>

    <style>
        body, html {
            margin: 0;
            padding: 0;
            height: 100%;
            overflow: hidden;
            font-family: Arial, sans-serif;
        }

        #particleCanvas {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: -1; 
            background:#131312 ; 
        }

        .content-wrapper {
            position: relative;
            z-index: 1;
            padding: 2rem;
            color: #050505;
        }
        .animated-text {
            opacity: 0;
            color: #FC9905;
            animation: fadeInUp 1.5s ease-in-out forwards;
        }

        @keyframes fadeInUp {
            0% {
                opacity: 0;
                transform: translateY(30px);
            }
            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }

        #search::placeholder {
            color: #ffc107;   
            opacity: 1;   
        }
    </style>

@endsection

@section('scripts')
    <script>
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
});
        //title text annimation script
        document.addEventListener("DOMContentLoaded", function() {
            const el = document.querySelector('.animated-text');
            if(el) el.style.animationPlayState = 'running';
        });
 
        //delete message script
        function confirmDelete(memberId, fullName) {
        var form = document.getElementById('deleteForm');
        form.action = '/members/' + memberId;

        document.getElementById('deleteMessage').innerHTML = 
            'Are you sure to delete "<strong>' + fullName + '</strong>"? To confirm, type the full name below:';

        var deleteBtn = document.getElementById('deleteBtn');
        deleteBtn.disabled = true;

        var confirmInput = document.getElementById('confirmInput');
        confirmInput.value = '';
        confirmInput.addEventListener('input', function() {
            deleteBtn.disabled = this.value !== fullName;
        });

        var myModal = new bootstrap.Modal(document.getElementById('deleteModal'));
        myModal.show();
        }

        //toast message script
        var toastElList = [].slice.call(document.querySelectorAll('.toast'))
        var toastList = toastElList.map(function(toastEl) {
            return new bootstrap.Toast(toastEl, { delay: 3000 }) 
        });
        toastList.forEach(toast => toast.show());
    </script>
@endsection