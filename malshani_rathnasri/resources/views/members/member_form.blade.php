@extends('layouts.app')

@section('content')
  <div>
    <canvas id="particleCanvas"></canvas>
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">{{ isset($member) ? 'Edit Member' : 'Add New Member' }}</h5>
            <button type="button" class="btn-close" aria-label="Close" onclick="redirectHome()"></button>
          </div>
          <div class="modal-body">
            <form method="POST" action="{{ route('members.storeAndEdit')}}">
                @csrf
                <input type="hidden" name="member_id" value="{{ $member->id ?? '' }}">
                <div class="mb-3">
                    <label for="firstName" class="form-label">First Name</label>
                    <input type="text" class="form-control" name="firstName" id="firstName" value="{{ $member->firstName ?? '' }}">
                </div>
                <div class="mb-2">
                    <label for="lastName" class="form-label">Last Name <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="lastName" id="lastName" value="{{ $member->lastName ?? '' }}" required>
                </div>
                <div class="mb-3">
                    <label for="ds_division" class="form-label">DS Division</label>
                    <select name="ds_division_id" id="ds_division" class="form-select">
                        <option value="">Select Division</option>
                          @foreach ($divisions as $division)
                             <option value="{{ $division->id }}" {{ isset($member) && $member->ds_division_id == $division->id ? 'selected' : '' }}>
                                  {{ $division->name }}
                              </option>
                          @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label for="summary" class="form-label">Summary</label>
                    <textarea class="form-control" name="summary" id="summary">{{ $member->summary ?? '' }}</textarea>
                </div>
                <div class="mb-3">
                    <label for="dob" class="form-label">Date of Birth</label>
                    <input type="date" class="form-control" name="dob" id="dob" value="{{ $member->dob ?? '' }}">
                </div>
                <div class="modal-footer">
                  @if(!isset ($member))
                    <button type="reset" class="btn btn-success">Reset</button>
                  @endif
                  <button type="submit" class="btn" style="background-color: #FC9905; border-color: #FC9905; color: #fff;">{{ isset($member) ? 'Update Member' : 'Add Member' }}</button>
                  <button type="button" class="btn btn-danger" onclick="redirectHome()">Close</button>
                </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection

{{-- Modal --}}
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

document.addEventListener("DOMContentLoaded", function () {
    var myModal = new bootstrap.Modal(document.getElementById('exampleModal'), {
        backdrop: 'static', 
        keyboard: false     
    });
    myModal.show();
});

function redirectHome() {
  window.location.href = "{{ route('home') }}"; 
}
</script>
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
</style>
@endsection

