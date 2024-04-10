@extends('base')

@section('content')
    <div class="edit">
        <h1>Dashboard</h1>
        <h3>Notice aanmaken</h3>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('notices.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group mb-3">
			    <label for="mentor_id" class="form-label">Mentor</label>
                <select name="mentor_id" id="mentor_id">
                    @foreach($mentors as $mentor)
                        <option value="{{ $mentor->id }}">{{ $mentor->name }}</option>   
                    @endforeach 
                </select>
            </div>
            <div class="form-group mb-3">
                <label for="reason_id" class="form-label">Reason</label>
                <select name="reason_id" id="reason_id">
                <option value=NULL>-- Reason --</option>
                    @foreach($reasons as $reason)
                        <option value="{{ $reason->id }}">{{ $reason->title }}</option>   
                    @endforeach 
                </select>
		    </div>
            <div class="form-group mb-3">
                <label for="img" class="form-label">Image</label>
                <input type="file" name="img" id="img" class="form-control">
            </div>
               
            <button type="submit" class="form-control btn btn-primary my-2">Save</button>
            {{ csrf_field() }}
        </form>
    </div>
@endsection