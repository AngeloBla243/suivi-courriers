@extends('adminlte::page')

@section('title', 'Modifier utilisateur')

@section('content_header')
    <h1 class="fw-bold mb-4" style="color:#1f94d2!important;">
        <i class="fas fa-user-edit me-2"></i> Modifier {{ $user->name }}
    </h1>
@stop

@section('content')
    <style>
        :root {
            --main-blue: #1f94d2;
            --main-yellow: #ffe243;
        }

        .card-edit {
            max-width: 500px;
            margin: 0 auto 2.3rem auto;
            border-radius: 1rem;
            box-shadow: 0 4px 18px rgba(31, 148, 210, 0.10);
            padding: 2.2rem 1.5rem 1.4rem 1.5rem;
            background: #fff;
            border: none;
        }

        .card-edit label {
            color: var(--main-blue);
            font-weight: 600;
            margin-bottom: .33rem;
        }

        .card-edit .form-control,
        .card-edit .form-control-file {
            border-radius: 10px;
            border: 1.7px solid #e4eef7;
            font-size: 1.08em;
            margin-bottom: 0.45rem;
            box-shadow: none;
            transition: border-color 0.17s;
        }

        .card-edit .form-control:focus {
            outline: none;
            border-color: var(--main-blue);
            box-shadow: 0 2px 12px rgba(31, 148, 210, 0.13);
        }

        .form-group {
            margin-bottom: 1.21rem;
        }

        .btn-primary {
            background-color: var(--main-blue);
            border-color: var(--main-blue);
            font-weight: 700;
            border-radius: 22px;
            padding: 0.63em 1.9em;
            font-size: 1.07em;
            transition: background 0.16s;
            margin-top: 1rem;
        }

        .btn-primary:hover {
            background-color: #1668a7;
        }

        .img-thumbnail.rounded-circle {
            border: 2.5px solid var(--main-blue);
            box-shadow: 0 1.5px 7px rgba(31, 148, 210, 0.08);
            object-fit: cover;
        }

        .text-danger {
            font-size: .96em;
            margin-top: 2px;
        }

        @media (max-width:600px) {
            .card-edit {
                padding: 1.2rem 0.6rem 0.8rem 0.6rem;
            }

            h1 {
                font-size: 1.18rem;
            }
        }
    </style>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show mb-3" role="alert">
            <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fermer"></button>
        </div>
    @endif

    <div class="card-edit mt-2">
        <form action="{{ route('admin.users.update', $user) }}" method="POST" enctype="multipart/form-data"
            autocomplete="off">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label>Nom</label>
                <input type="text" name="name" class="form-control" value="{{ old('name', $user->name) }}" required>
                @error('name')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" class="form-control" value="{{ old('email', $user->email) }}" required>
                @error('email')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group">
                <label>Photo (optionnel)</label>
                <input type="file" name="photo" class="form-control-file" accept="image/*" id="photo-input">
                @error('photo')
                    <span class="text-danger">{{ $message }}</span>
                @enderror

                @if ($user->photo)
                    <br>
                    <img id="photo-preview" src="{{ asset('storage/' . $user->photo) }}" alt="Photo" width="100"
                        class="img-thumbnail rounded-circle mt-2">
                @else
                    <img id="photo-preview" class="img-thumbnail rounded-circle mt-2" style="display:none;" width="100">
                @endif
            </div>
            <button type="submit" class="btn btn-primary w-100">
                <i class="fas fa-save me-2"></i> Mettre à jour
            </button>
        </form>
    </div>

    {{-- JS pour preview image immédiat --}}
    <script>
        document.getElementById('photo-input')?.addEventListener('change', function(e) {
            let file = e.target.files[0];
            let preview = document.getElementById('photo-preview');
            if (file) {
                let reader = new FileReader();
                reader.onload = function(ev) {
                    preview.src = ev.target.result;
                    preview.style.display = 'block';
                }
                reader.readAsDataURL(file);
            }
        });
    </script>
@stop
