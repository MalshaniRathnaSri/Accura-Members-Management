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
        <div class="d-flex justify-content-center align-items-center">
            <h1 class="animated-text text-center">Accura Member List</h1>
        </div>
        <div class="d-flex justify-content-between mb-3">
            <form method="GET" action="{{ route('home') }}">
                <input type="text" name="search" id="search" placeholder="Search by Last Name" value="{{ request('search') }}">
                <button type="submit">Search</button>
            </form>
            <a href="{{ route('members.index') }}" class="btn btn-outline-warning">Add New Member</a>
        </div>
        <table class="table">
            <thead class="table-dark">
                <tr>
                    <th scope="col">First Name</th>
                    <th scope="col">Last First</th>
                    <th scope="col">Date of Birth</th>
                    <th scope="col">DS Division</th>
                    <th scope=""col>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($members as $member)
                    <tr>
                        <th>{{ $member->firstName}}</th>
                        <td>{{ $member->lastName}}</td>
                        <td>{{ $member->dob}}</td>
                        <td>{{ $member->division->name ?? '-' }}</td>
                        <td>
                            <a href="{{ route('members.index', ['member_id' => $member->id]) }}" class="btn btn-success">Edit</a>
                            <button type="button" class="btn btn-danger" 
                                    onclick="confirmDelete('{{ $member->id }}', '{{ $member->firstName }} {{ $member->lastName }}')">
                                Delete
                            </button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
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
    </style>

@endsection

@section('scripts')
    <script>
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