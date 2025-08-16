@extends("layouts.app")

@section('content')
    <div>
        <div class="d-flex justify-content-center align-items-center">
            <h1 class="animated-text text-center">Accura Member List</h1>
        </div>
        <div class="d-flex justify-content-between mb-3">
            <input type="text" id="search" class="" placeholder="Search by Last Name">
            <button type="button" class="btn btn-outline-warning">Warning</button>
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
                <tr>
                    <th scope="row">1</th>
                    <td>Mark</td>
                    <td>Otto</td>
                    <td>@mdo</td>
                    <td>
                        <button type="button" class="btn btn-success">Edit</button>
                        <button type="button" class="btn btn-danger">Delete</button>
                    </td>
                </tr>
            </tbody>
        </table>
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
    document.addEventListener("DOMContentLoaded", function() {
        const el = document.querySelector('.animated-text');
        if(el) el.style.animationPlayState = 'running';
    });
    </script>
@endsection