@extends('layouts.app')

@section('page_title', 'Edit Account')

@section('content')
<div class="card">
    <div style="margin-bottom: 2rem;">
        <h2 style="font-size: 1.125rem; font-weight: 700;">Edit Account Forms</h2>
        <p style="font-size: 0.8125rem; color: var(--text-muted); margin-top: 0.25rem;">Please <span style="color: #db2777;">.fill-all</span> input form with right value.</p>
    </div>

    @if(session('success'))
        <div style="background: #d1fae5; color: #065f46; padding: 1rem; border-radius: 0.5rem; margin-bottom: 1.5rem;">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('staff.profile.update') }}" method="POST">
        @csrf
        @method('PUT')
        
        <div class="form-group" style="margin-bottom: 1.5rem;">
            <label class="form-label" style="font-weight: 600; color: var(--text-main); font-size: 1rem; margin-bottom: 0.75rem;">Name</label>
            <input type="text" name="name" class="form-control" value="{{ old('name', $user->name) }}" required style="background: #fff; padding: 1.25rem 1rem; border: 1px solid #f1f5f9;">
            @error('name') <span style="color: #ef4444; font-size: 0.75rem;">{{ $message }}</span> @enderror
        </div>

        <div class="form-group" style="margin-bottom: 1.5rem;">
            <label class="form-label" style="font-weight: 600; color: var(--text-main); font-size: 1rem; margin-bottom: 0.75rem;">Email</label>
            <input type="email" name="email" class="form-control" value="{{ old('email', $user->email) }}" required style="background: #fff; padding: 1.25rem 1rem; border: 1px solid #f1f5f9;">
            @error('email') <span style="color: #ef4444; font-size: 0.75rem;">{{ $message }}</span> @enderror
        </div>

        <div class="form-group" style="margin-bottom: 2rem;">
            <label class="form-label" style="font-weight: 600; color: var(--text-main); font-size: 1rem; margin-bottom: 0.75rem;">
                New Password <span style="color: #f59e0b; font-weight: 400; font-size: 0.875rem;">optional</span>
            </label>
            <input type="password" name="new_password" class="form-control" placeholder="Leave blank if no change" style="background: #fff; padding: 1.25rem 1rem; border: 1px solid #f1f5f9;">
            @error('new_password') <span style="color: #ef4444; font-size: 0.75rem;">{{ $message }}</span> @enderror
        </div>

        <div style="display: flex; justify-content: flex-end; gap: 1rem;">
            <a href="{{ url()->previous() }}" class="btn" style="background: #9ca3af; color: white; padding: 0.75rem 2.5rem; border-radius: 6px; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1);">Cancel</a>
            <button type="submit" class="btn" style="background: #6366f1; color: white; padding: 0.75rem 2.5rem; border-radius: 6px; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1);">Submit</button>
        </div>
    </form>
</div>
@endsection
